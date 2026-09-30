<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\JobOrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'supervisor' => redirect()->route('supervisor.dashboard'),
        'mechanic' => redirect()->route('mechanic.dashboard'),
        default => abort(403),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [JobOrderController::class, 'dashboard'])->name('dashboard');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/staff', [UserController::class, 'index'])->name('staff');
    Route::put('/staff/{user}', [UserController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{user}', [UserController::class, 'destroy'])->name('staff.destroy');

    Route::get('/users/addcustomer', [CustomerController::class, 'create'])->name('users.addcustomer');
    Route::post('/users/addcustomer', [CustomerController::class, 'store'])->name('users.addcustomer.store');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::get('/users/addvehicles', [VehicleController::class, 'create'])->name('users.addvehicles');
    Route::post('/users/addvehicles', [VehicleController::class, 'store'])->name('users.addvehicles.store');
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles');
    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::get('/users/addservices', [ServiceController::class, 'create'])->name('users.addservices');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    Route::get('/job-orders', [JobOrderController::class, 'adminIndex'])->name('job-orders');
});

Route::middleware(['auth', 'verified', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', [JobOrderController::class, 'dashboard'])->name('dashboard');
    Route::get('/pending-approvals', [JobOrderController::class, 'pendingApprovals'])->name('pending-approvals');
    Route::get('/AJO', [JobOrderController::class, 'supervisorAll'])->name('AJO');
    Route::get('/assign-mechanic', [JobOrderController::class, 'assignmentPage'])->name('assign-mechanic');
    Route::post('/job-orders/{jobOrder}/approve', [JobOrderController::class, 'approve'])->name('job-orders.approve');
    Route::post('/job-orders/{jobOrder}/reject', [JobOrderController::class, 'reject'])->name('job-orders.reject');
    Route::post('/job-orders/{jobOrder}/assign', [JobOrderController::class, 'assign'])->name('job-orders.assign');
    Route::get('/approval-history', [JobOrderController::class, 'approvalHistory'])->name('approval-history');
});

Route::middleware(['auth', 'verified', 'role:mechanic'])->prefix('mechanic')->name('mechanic.')->group(function () {
    Route::get('/dashboard', [JobOrderController::class, 'dashboard'])->name('dashboard');
    Route::get('/MJO', [JobOrderController::class, 'mechanicOrders'])->name('MJO');
    Route::get('/CJO', [JobOrderController::class, 'create'])->name('CJO');
    Route::post('/job-orders', [JobOrderController::class, 'store'])->name('job-orders.store');
    Route::get('/job-orders/{jobOrder}/edit', [JobOrderController::class, 'edit'])->name('job-orders.edit');
    Route::put('/job-orders/{jobOrder}', [JobOrderController::class, 'update'])->name('job-orders.update');
    Route::post('/job-orders/{jobOrder}/start', [JobOrderController::class, 'start'])->name('job-orders.start');
    Route::post('/job-orders/{jobOrder}/complete', [JobOrderController::class, 'complete'])->name('job-orders.complete');
    Route::get('/needs-revision', [JobOrderController::class, 'needsRevision'])->name('needs-revision');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
