<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{

    public function index(): View
    {
        $customers = Customer::with('vehicles')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('admin.customers', [
            'customers' => $customers,
        ]);
    }


    /**
     * Show the add customer form.
     */
    public function create(): View
    {
        return view('admin.users.addcustomer');
    }

    /**
     * Store a new customer.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'contact_number' => [
                'required',
                'digits_between:10,15',
                'regex:/^09\d{9}$/',
            ],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $customer = Customer::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'contact_number' => $validated['contact_number'],
            'address' => $validated['address'],
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.users.addcustomer')
            ->with('success', 'Customer added successfully.')
            ->with('customer_id', $customer->cust_id);
    }

    /**
     * Update an existing customer.
     */
    public function update(
        Request $request,
        Customer $customer
    ): RedirectResponse {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'contact_number' => [
                'required',
                'digits_between:10,15',
                'regex:/^09\d{9}$/',
            ],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $customer->update([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'contact_number' => $validated['contact_number'],
            'address' => $validated['address'],
        ]);

        return redirect()
            ->route('admin.customers')
            ->with('success', 'Customer updated successfully.');
    }


    /**
     * Delete an existing customer.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        try {
            $customer->delete();
        } catch (QueryException $e) {
            return redirect()->route('admin.customers')->with('error', 'Customer cannot be deleted because vehicles or job orders are linked to this record.');
        }

        return redirect()
            ->route('admin.customers')
            ->with('success', 'Customer deleted successfully.');
    }
}