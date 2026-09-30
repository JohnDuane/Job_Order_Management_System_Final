<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Staff;
use App\Models\JobOrderAssignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display all staff accounts.
     */
    public function index(): View
    {
        $staff = User::whereIn('role', ['admin', 'supervisor', 'mechanic'])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $staffData = $staff->map(function ($user) {
            return [
                'id' => $user->id,

                'full_name' => trim(
                    $user->first_name . ' ' .
                    ($user->middle_name ? $user->middle_name . ' ' : '') .
                    $user->last_name
                ),

                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name' => $user->last_name,

                'email' => $user->email,
                'role' => $user->role,

                // Used by the frontend to identify the currently
                // authenticated account.
                'is_current_user' => auth()->id() === $user->id,
            ];
        })->values();

        return view('admin.staff', [
            'staff' => $staff,
            'staffData' => $staffData,
        ]);
    }


    /**
     * Show the create staff form.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }


    /**
     * Store a new staff account.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:100'
            ],

            'middle_name' => [
                'nullable',
                'string',
                'max:100'
            ],

            'last_name' => [
                'required',
                'string',
                'max:100'
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class
            ],

            'role' => [
                'required',
                'in:supervisor,mechanic'
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ],
        ]);

        $fullName = trim(
            $request->first_name . ' ' .
            ($request->middle_name ? $request->middle_name . ' ' : '') .
            $request->last_name
        );

        $user = User::create([
            'name' => $fullName,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($user->role === 'mechanic') {
            Staff::create([
                'user_id' => $user->id,
                'staff_first' => $user->first_name,
                'staff_middle' => $user->middle_name,
                'staff_last' => $user->last_name,
                'contact_number' => 9000000000,
                'address' => 'Not provided',
                'created_by' => auth()->id(),
            ]);
        }

        return redirect()
            ->route('admin.staff')
            ->with('success', 'User account created successfully.');
    }


    /**
     * Update a staff account.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:100'
            ],

            'middle_name' => [
                'nullable',
                'string',
                'max:100'
            ],

            'last_name' => [
                'required',
                'string',
                'max:100'
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'role' => [
                'required',
                'in:admin,supervisor,mechanic',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | PREVENT SELF ROLE CHANGE
        |--------------------------------------------------------------------------
        |
        | If the admin is editing their own account, their role MUST NOT
        | change.
        |
        | This prevents:
        |
        | Admin -> Supervisor
        | Admin -> Mechanic
        |
        | while the admin is currently logged in.
        |
        | Otherwise the next request would fail the admin role middleware
        | and return HTTP 403.
        |
        */

        $isEditingSelf = auth()->id() === $user->id;

        if ($isEditingSelf) {
            $request->merge([
                'role' => $user->role,
            ]);
        }


        $fullName = trim(
            $request->first_name . ' ' .
            ($request->middle_name ? $request->middle_name . ' ' : '') .
            $request->last_name
        );


        DB::transaction(function () use ($user, $request, $fullName) {
            $user->update([
                'name' => $fullName,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'role' => $request->role,
            ]);

            if ($user->role === 'mechanic') {
                Staff::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'staff_first' => $user->first_name,
                        'staff_middle' => $user->middle_name,
                        'staff_last' => $user->last_name,
                        'contact_number' => 9000000000,
                        'address' => 'Not provided',
                        'created_by' => auth()->id(),
                    ]
                );
            }
        });


        return redirect()
            ->route('admin.staff')
            ->with(
                'success',
                $isEditingSelf
                    ? 'Your account was updated successfully. Your role cannot be changed while you are logged in.'
                    : 'Staff account updated successfully.'
            );
    }


    /**
     * Delete a staff account.
     */
    public function destroy(User $user): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | PREVENT SELF DELETE
        |--------------------------------------------------------------------------
        |
        | An administrator must not be able to delete the account that
        | is currently being used to access the admin panel.
        |
        */

        if (auth()->id() === $user->id) {
            return redirect()
                ->route('admin.staff')
                ->with(
                    'error',
                    'You cannot delete the account you are currently logged in with.'
                );
        }


        if (JobOrderAssignment::whereHas('staff', fn ($q) => $q->where('user_id', $user->id))->exists()) {
            return redirect()->route('admin.staff')->with('error', 'This staff account cannot be deleted because it has job-order assignments.');
        }

        DB::transaction(function () use ($user) {
            Staff::where('user_id', $user->id)->delete();
            $user->delete();
        });


        return redirect()
            ->route('admin.staff')
            ->with(
                'success',
                'Staff account deleted successfully.'
            );
    }
}