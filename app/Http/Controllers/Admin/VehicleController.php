<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleController extends Controller
{
    /**
     * Display all registered vehicles.
     */
    public function index(): View
    {
        $vehicles = Vehicle::with('customer')
            ->orderBy('make')
            ->get();

        $customers = Customer::orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('admin.vehicles', [
            'vehicles' => $vehicles,
            'customers' => $customers,
        ]);
    }

    /**
     * Show the add vehicle form.
     */
    public function create(Request $request): View
    {
        $customers = Customer::orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $selectedCustomer = $request->query('customer');

        return view('admin.users.addvehicles', [
            'customers' => $customers,
            'selectedCustomer' => $selectedCustomer,
        ]);
    }

    /**
     * Store a new vehicle.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cust_id' => ['required', 'exists:Customer,cust_id'],
            'make' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => [
                'required',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 1),
            ],
            'plate_number' => ['required', 'string', 'max:50'],
            'engine_model' => ['required', 'string', 'max:255'],
        ]);

        $vehicleDescription =
            $validated['make'] . ' ' .
            $validated['model'] . ' ' .
            $validated['year'];

        Vehicle::create([
            'cust_id' => $validated['cust_id'],
            'plate_number' => $validated['plate_number'],
            'make' => $vehicleDescription,
            'engine_model' => $validated['engine_model'],
        ]);

        return redirect()
            ->route('admin.vehicles')
            ->with('success', 'Vehicle added successfully.');
    }

    /**
     * Update an existing vehicle.
     */
    public function update(
        Request $request,
        Vehicle $vehicle
    ): RedirectResponse {
        $validated = $request->validate([
            'cust_id' => ['required', 'exists:Customer,cust_id'],
            'make' => ['required', 'string', 'max:255'],
            'plate_number' => ['required', 'string', 'max:50'],
            'engine_model' => ['required', 'string', 'max:255'],
        ]);

        $vehicle->update([
            'cust_id' => $validated['cust_id'],
            'make' => $validated['make'],
            'plate_number' => $validated['plate_number'],
            'engine_model' => $validated['engine_model'],
        ]);

        return redirect()
            ->route('admin.vehicles')
            ->with('success', 'Vehicle updated successfully.');
    }

    /**
     * Delete an existing vehicle.
     */
    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        try {
            $vehicle->delete();
        } catch (QueryException $e) {
            return redirect()->route('admin.vehicles')->with('error', 'Vehicle cannot be deleted because it is linked to a job order.');
        }

        return redirect()
            ->route('admin.vehicles')
            ->with('success', 'Vehicle deleted successfully.');
    }
}