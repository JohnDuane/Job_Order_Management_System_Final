<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display all services.
     */
    public function index(): View
    {
        $services = Service::orderBy('service_name')->get();

        return view('admin.services', [
            'services' => $services,
        ]);
    }


    /**
     * Show the add service form.
     */
    public function create(): View
    {
        return view('admin.users.addservices');
    }


    /**
 * Store a new service.
 */
public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
        ],

        'description' => [
            'nullable',
            'string',
        ],

        'price' => [
            'required',
            'numeric',
            'min:0',
        ],
    ]);

    try {

        Service::create([
            'service_name' => $validated['name'],
            'job_desc' => $validated['description'] ?? null,
            'price' => $validated['price'],
        ]);

    } catch (QueryException $e) {

        return back()
            ->withInput()
            ->with('error', 'The price is too large or invalid for the service price field.');
    }

    return redirect()
        ->route('admin.services')
        ->with('success', 'Service added successfully.');
}


/**
 * Update an existing service.
 */
public function update(Request $request, Service $service): RedirectResponse
{
    $validated = $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
        ],

        'description' => [
            'nullable',
            'string',
        ],

        'price' => [
            'required',
            'numeric',
            'min:0',
        ],
    ]);

    try {

        $service->update([
            'service_name' => $validated['name'],
            'job_desc' => $validated['description'] ?? null,
            'price' => $validated['price'],
        ]);

    } catch (QueryException $e) {

        return back()
            ->withInput()
            ->with('error', 'The price is too large or invalid for the service price field.');
    }

    return redirect()
        ->route('admin.services')
        ->with('success', 'Service updated successfully.');
}


    /**
     * Delete a service.
     */
    public function destroy(Service $service): RedirectResponse
    {
        try {
            $service->delete();
        } catch (QueryException $e) {
            return redirect()->route('admin.services')->with('error', 'Service cannot be deleted because it is already used by a job order.');
        }

        return redirect()
            ->route('admin.services')
            ->with('success', 'Service deleted successfully.');
    }
}