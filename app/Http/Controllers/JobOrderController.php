<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\JobOrder;
use App\Models\JobOrderApproval;
use App\Models\JobOrderAssignment;
use App\Models\User;
use App\Models\Service;
use App\Models\Staff;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JobOrderController extends Controller
{
    public function create(): View
    {
        return view('mechanic.CJO', [
            'customers' => Customer::with('vehicles')->orderBy('last_name')->orderBy('first_name')->get(),
            'services' => Service::orderBy('service_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'cust_id' => ['required', 'exists:Customer,cust_id'],
            'vehicle_id' => [
                'required',
                Rule::exists('Vehicle', 'vehicle_id')->where(fn ($q) => $q->where('cust_id', $request->input('cust_id'))),
            ],
            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => ['integer', 'exists:Services,service_id'],
            'problem_description' => ['required', 'string', 'min:10', 'max:5000'],
            'remarks' => ['nullable', 'string', 'max:5000'],
            'expected_empl_date' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $services = Service::whereIn('service_id', $data['service_ids'])->get();
        $total = $services->sum(fn ($service) => (float) $service->price);

        $job = DB::transaction(function () use ($data, $total, $services) {
            $job = JobOrder::create([
                'cust_id' => $data['cust_id'],
                'vehicle_id' => $data['vehicle_id'],
                'created_by' => auth()->id(),
                'problem_description' => $data['problem_description'],
                'remarks' => $data['remarks'] ?? null,
                'status' => 'pending_approval',
                'date_issued' => now()->toDateString(),
                'expected_empl_date' => $data['expected_empl_date'] ?? null,
                'total_cost' => $total,
            ]);

            $job->services()->attach($services->pluck('service_id'));
            return $job;
        });

        return redirect()->route('mechanic.MJO')->with('success', $job->code . ' was submitted for supervisor approval.');
    }

    public function edit(JobOrder $jobOrder): View
    {
        abort_unless(auth()->user()->isMechanic(), 403);
        abort_unless($jobOrder->created_by === auth()->id(), 403);
        abort_unless($jobOrder->status === 'needs_revision', 422);

        return view('mechanic.CJO', [
            'customers' => Customer::with('vehicles')->orderBy('last_name')->orderBy('first_name')->get(),
            'services' => Service::orderBy('service_name')->get(),
            'jobOrder' => $jobOrder->load('services'),
        ]);
    }

    public function update(Request $request, JobOrder $jobOrder): RedirectResponse
    {
        abort_unless(auth()->user()->isMechanic(), 403);
        abort_unless($jobOrder->created_by === auth()->id(), 403);
        abort_unless(in_array($jobOrder->status, ['pending_approval', 'needs_revision'], true), 422);

        $data = $request->validate([
            'cust_id' => ['required', 'exists:Customer,cust_id'],
            'vehicle_id' => [Rule::exists('Vehicle', 'vehicle_id')->where(fn ($q) => $q->where('cust_id', $request->input('cust_id')))],
            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => ['integer', 'exists:Services,service_id'],
            'problem_description' => ['required', 'string', 'min:10', 'max:5000'],
            'remarks' => ['nullable', 'string', 'max:5000'],
            'expected_empl_date' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $services = Service::whereIn('service_id', $data['service_ids'])->get();
        $total = $services->sum(fn ($service) => (float) $service->price);

        DB::transaction(function () use ($jobOrder, $data, $services, $total) {
            $jobOrder->update([
                'cust_id' => $data['cust_id'],
                'vehicle_id' => $data['vehicle_id'],
                'problem_description' => $data['problem_description'],
                'remarks' => $data['remarks'] ?? null,
                'status' => 'pending_approval',
                'expected_empl_date' => $data['expected_empl_date'] ?? null,
                'total_cost' => $total,
            ]);
            $jobOrder->services()->sync($services->pluck('service_id'));
        });

        return redirect()->route('mechanic.needs-revision')->with('success', $jobOrder->code . ' was revised and resubmitted.');
    }

    public function start(JobOrder $jobOrder): RedirectResponse
    {
        abort_unless(auth()->user()->isMechanic(), 403);
        abort_unless($jobOrder->assignments()->whereHas('staff', fn ($q) => $q->where('user_id', auth()->id()))->exists(), 403);
        if ($jobOrder->status !== 'assigned') {
            return back()->with('error', $jobOrder->code . ' is not currently ready to start.');
        }
        $jobOrder->update(['status' => 'in_progress']);
        return back()->with('success', $jobOrder->code . ' is now in progress.');
    }

    public function complete(JobOrder $jobOrder): RedirectResponse
    {
        abort_unless(auth()->user()->isMechanic(), 403);
        abort_unless($jobOrder->assignments()->whereHas('staff', fn ($q) => $q->where('user_id', auth()->id()))->exists(), 403);
        if ($jobOrder->status !== 'in_progress') {
            return back()->with('error', $jobOrder->code . ' is not currently in progress.');
        }
        $jobOrder->update(['status' => 'completed']);
        return back()->with('success', $jobOrder->code . ' was marked completed.');
    }

    public function adminIndex(Request $request): View
    {
        $query = JobOrder::with(['customer', 'vehicle', 'services', 'assignments.staff.user', 'creator'])->latest('job_order_id');
        $this->applyFilters($query, $request);
        $jobs = $query->paginate(20)->withQueryString();
        return view('admin.job-orders', compact('jobs'));
    }

    public function supervisorAll(Request $request): View
    {
        $query = JobOrder::with(['customer', 'vehicle', 'services', 'assignments.staff.user', 'creator'])->latest('job_order_id');
        $this->applyFilters($query, $request);
        $jobs = $query->paginate(20)->withQueryString();
        return view('supervisor.AJO', compact('jobs'));
    }

    public function pendingApprovals(Request $request): View
    {
        $query = JobOrder::with(['customer', 'vehicle', 'services', 'creator'])
            ->where('status', 'pending_approval')
            ->latest('job_order_id');
        $this->applyFilters($query, $request);
        $jobs = $query->paginate(20)->withQueryString();
        return view('supervisor.pending-approvals', compact('jobs'));
    }

    public function approvalHistory(Request $request): View
    {
        $approvals = JobOrderApproval::with(['jobOrder.customer', 'jobOrder.vehicle', 'approvedBy'])
            ->latest('id')->paginate(20)->withQueryString();
        return view('supervisor.approval-history', compact('approvals'));
    }

    public function approve(Request $request, JobOrder $jobOrder): RedirectResponse
    {
        if ($jobOrder->status !== 'pending_approval') {
            return back()->with('error', $jobOrder->code . ' is no longer awaiting approval.');
        }
        $data = $request->validate(['remarks' => ['nullable', 'string', 'max:2000']]);

        DB::transaction(function () use ($jobOrder, $data) {
            JobOrderApproval::create([
                'job_order_id' => $jobOrder->job_order_id,
                'approved_by' => auth()->id(),
                'status' => 'approved',
                'remarks' => $data['remarks'] ?? null,
                'action_date' => now()->toDateString(),
            ]);
            $jobOrder->update(['status' => 'approved', 'remarks' => $data['remarks'] ?? $jobOrder->remarks]);
        });
        return back()->with('success', $jobOrder->code . ' was approved.');
    }

    public function reject(Request $request, JobOrder $jobOrder): RedirectResponse
    {
        if ($jobOrder->status !== 'pending_approval') {
            return back()->with('error', $jobOrder->code . ' is no longer awaiting approval.');
        }
        $data = $request->validate(['remarks' => ['required', 'string', 'min:5', 'max:2000']]);

        DB::transaction(function () use ($jobOrder, $data) {
            JobOrderApproval::create([
                'job_order_id' => $jobOrder->job_order_id,
                'approved_by' => auth()->id(),
                'status' => 'needs_revision',
                'remarks' => $data['remarks'],
                'action_date' => now()->toDateString(),
            ]);
            $jobOrder->update(['status' => 'needs_revision', 'remarks' => $data['remarks']]);
        });
        return back()->with('success', $jobOrder->code . ' was returned for revision.');
    }

    public function assignmentPage(Request $request): View
    {
        $jobs = JobOrder::with(['customer', 'vehicle', 'services', 'assignments.staff.user'])
            ->whereIn('status', ['approved', 'assigned', 'in_progress'])
            ->latest('job_order_id')->paginate(20)->withQueryString();
        $mechanics = Staff::with('user')->whereHas('user', fn ($q) => $q->where('role', 'mechanic'))->orderBy('staff_last')->get();
        return view('supervisor.assign-mechanic', compact('jobs', 'mechanics'));
    }

    public function assign(Request $request, JobOrder $jobOrder): RedirectResponse
    {
        if (! in_array($jobOrder->status, ['approved', 'assigned'], true)) {
            return back()->with('error', $jobOrder->code . ' must be approved before it can be assigned.');
        }
        $data = $request->validate([
            'staff_ids' => ['required', 'array', 'min:1'],
            'staff_ids.*' => ['integer', Rule::exists('Staff', 'staff_id')],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($jobOrder, $data) {
            $jobOrder->assignments()->delete();
            foreach (array_unique($data['staff_ids']) as $staffId) {
                JobOrderAssignment::create([
                    'job_order_id' => $jobOrder->job_order_id,
                    'staff_id' => $staffId,
                    'assigned_by' => auth()->id(),
                    'assigned_date' => now()->toDateString(),
                    'remarks' => $data['remarks'] ?? null,
                ]);
            }
            $jobOrder->update(['status' => 'assigned']);
        });

        return back()->with('success', $jobOrder->code . ' was assigned successfully.');
    }

    public function mechanicOrders(Request $request): View
    {
        $staff = Staff::where('user_id', auth()->id())->firstOrFail();
        $query = JobOrder::with(['customer', 'vehicle', 'services', 'assignments.staff.user'])
            ->whereHas('assignments', fn ($q) => $q->where('staff_id', $staff->staff_id))
            ->latest('job_order_id');
        $this->applyFilters($query, $request);
        $jobs = $query->paginate(20)->withQueryString();
        return view('mechanic.MJO', compact('jobs'));
    }

    public function needsRevision(): View
    {
        $jobs = JobOrder::with(['customer', 'vehicle', 'services', 'approvals' => fn ($q) => $q->latest('id')])
            ->where('created_by', auth()->id())
            ->where('status', 'needs_revision')
            ->latest('job_order_id')->get();
        return view('mechanic.needs-revision', compact('jobs'));
    }

    public function dashboard(): View
    {
        $base = JobOrder::query();

        /*
        |--------------------------------------------------------------------------
        | Mechanic-specific dashboard filtering
        |--------------------------------------------------------------------------
        */
        if (auth()->user()->isMechanic()) {

            $staff = Staff::where('user_id', auth()->id())->first();

            $base->when($staff, function ($q) use ($staff) {
                $q->whereHas('assignments', function ($assignment) use ($staff) {
                    $assignment->where('staff_id', $staff->staff_id);
                });
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Current week job activity
        |--------------------------------------------------------------------------
        |
        | Creates one value for each day of the current week.
        | If there are no jobs on a particular day, it returns 0.
        |
        */

        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        $weeklyJobs = (clone $base)
            ->whereBetween('date_issued', [
                $weekStart->toDateString(),
                $weekEnd->toDateString(),
            ])
            ->get()
            ->groupBy(function ($job) {
                return $job->date_issued->format('Y-m-d');
            });


        $jobActivityLabels = [];
        $jobActivityData = [];

        for ($date = $weekStart->copy(); $date->lte($weekEnd); $date->addDay()) {

            $dateKey = $date->format('Y-m-d');

            $jobActivityLabels[] = $date->format('D');

            $jobActivityData[] = $weeklyJobs->get($dateKey, collect())->count();
        }


        /*
        |--------------------------------------------------------------------------
        | Job status chart
        |--------------------------------------------------------------------------
        */

        $jobStatusData = [
            'pending_approval' => (clone $base)
                ->where('status', 'pending_approval')
                ->count(),

            'approved' => (clone $base)
                ->where('status', 'approved')
                ->count(),

            'assigned' => (clone $base)
                ->where('status', 'assigned')
                ->count(),

            'in_progress' => (clone $base)
                ->where('status', 'in_progress')
                ->count(),

            'completed' => (clone $base)
                ->where('status', 'completed')
                ->count(),

            'needs_revision' => (clone $base)
                ->where('status', 'needs_revision')
                ->count(),
        ];


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view(auth()->user()->role . '.dashboard', [

            'customerCount' => Customer::count(),

            'vehicleCount' => Vehicle::count(),

            'staffCount' => User::whereIn('role', [
                'admin',
                'supervisor',
                'mechanic',
            ])->count(),

            'jobCountWeek' => (clone $base)
                ->whereBetween('date_issued', [
                    now()->startOfWeek()->toDateString(),
                    now()->endOfWeek()->toDateString(),
                ])
                ->count(),

            'jobCountMonth' => (clone $base)
                ->whereBetween('date_issued', [
                    now()->startOfMonth()->toDateString(),
                    now()->endOfMonth()->toDateString(),
                ])
                ->count(),

            'jobCountYear' => (clone $base)
                ->whereBetween('date_issued', [
                    now()->startOfYear()->toDateString(),
                    now()->endOfYear()->toDateString(),
                ])
                ->count(),

            'recentJobs' => (clone $base)
                ->with([
                    'customer',
                    'vehicle',
                ])
                ->latest('job_order_id')
                ->limit(8)
                ->get(),

            /*
            |--------------------------------------------------------------------------
            | Chart data
            |--------------------------------------------------------------------------
            */

            'jobActivityLabels' => $jobActivityLabels,

            'jobActivityData' => $jobActivityData,

            'jobStatusData' => $jobStatusData,
        ]);
    }

    private function applyFilters($query, Request $request): void
    {
        $search = trim((string) $request->input('search'));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('job_order_id', 'like', '%' . preg_replace('/[^0-9]/', '', $search) . '%')
                    ->orWhereHas('customer', fn ($c) => $c->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]))
                    ->orWhereHas('vehicle', fn ($v) => $v->where('plate_number', 'like', "%{$search}%")->orWhere('make', 'like', "%{$search}%"));
            });
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
    }
}
