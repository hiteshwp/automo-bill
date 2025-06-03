<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\GarageOwnerController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckGarageSubscription;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// 🛠 Route for role-based dashboard redirection
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');

    // Super Admin Routes
    Route::middleware('role:Super Admin')->group(function () {
        Route::get('/admin-dashboard', [DashboardController::class, 'superAdmin'])->name('dashboard.super-admin');

         // 🚀 Garage Owner Management (Super Admin Only)
         Route::group(['prefix' => 'garage-owners'], function () {
            Route::get('list', [GarageOwnerController::class, 'index'])->name('admin.garage-owners.index');
            Route::post('data', [GarageOwnerController::class, 'getData'])->name('admin.garage-owners.data'); // DataTable route
            Route::post('store', [GarageOwnerController::class, 'store'])->name('admin.garage-owners.store');
            Route::post('view', [GarageOwnerController::class, 'view']);
            Route::post('editview', [GarageOwnerController::class, 'editview']);
            Route::post('update', [GarageOwnerController::class, 'update']);
            Route::delete('remove-details/{id}', [GarageOwnerController::class, 'removedetails'])->name('owner.removedetails');
            Route::get('{id}/clients', [GarageOwnerController::class, 'clientListPage'])->name('admin.garage.clients.page');
            Route::get('{id}/clients/data', [GarageOwnerController::class, 'getClientData'])->name('admin.garage.clients.data');
            Route::get('client-details/{id}', [GarageOwnerController::class, 'clientdetails'])->name('admin.client.clientdetails');
        });

         // 🚀 Admin Management (Super Admin Only)
         Route::group(['prefix' => 'admin'], function () {
            Route::get('list', [AdminController::class, 'index'])->name('admin.index');
            Route::post('data', [AdminController::class, 'getData'])->name('admin.data'); // DataTable route
            Route::post('store', [AdminController::class, 'store'])->name('admin.store');
            Route::post('view', [AdminController::class, 'view']);
            Route::post('editview', [AdminController::class, 'editview']);
            Route::post('update', [AdminController::class, 'update']);
            Route::delete('remove-details/{id}', [AdminController::class, 'removedetails'])->name('admin.removedetails');
        });
    });

    // Garage Owner Routes
    //Route::middleware(['role:Garage Owner', CheckGarageSubscription::class])->group(function () {
    Route::middleware('role:Garage Owner')->group(function () {
        Route::get('/garage-owner-dashboard', [DashboardController::class, 'garageOwner'])->name('dashboard.garage-owner');

        // 🚀 Client Management (Garage Owner Only)
        Route::group(['prefix' => 'clients'], function () {
            Route::get('list', [ClientsController::class, 'index'])->name('garage-owner.clients.index');
            Route::post('data', [ClientsController::class, 'getClientsData'])->name('garage-owner.clients.data'); // DataTable route
            Route::get('detail/{id}', [ClientsController::class, 'clientdetail'])->name('garage-owner.client.details');
            Route::post('store', [ClientsController::class, 'store'])->name('client.store');
            Route::post('view', [ClientsController::class, 'view']);
            Route::post('update', [ClientsController::class, 'update']);
            Route::delete('remove-details/{id}', [ClientsController::class, 'removedetails'])->name('client.removedetails');

            Route::get('{id}/vehicles', [VehiclesController::class, 'index'])->name('garage-owner.clients.vehicles.page');
            Route::post('vehicles/data', [VehiclesController::class, 'getClientsVehicleData'])->name('garage-owner.clients.vehicles.data');
            Route::post('vehicles/store', [VehiclesController::class, 'store'])->name('garage-owner.clients.vehicles.store');
            Route::post('vehicles/view', [VehiclesController::class, 'view']);
            Route::post('vehicles/update', [VehiclesController::class, 'update']);
            Route::delete('vehicles/remove-details/{id}', [VehiclesController::class, 'removedetails'])->name('garage-owner.clients.vehicles.removedetails');
        });

        // 🚀 Vehicle Management (Garage Owner Only)
        // Route::group(['prefix' => 'vehicles'], function () {
        //     Route::get('list', [ClientsController::class, 'index'])->name('garage-owner.vehicle.index');
        //     Route::post('data', [ClientsController::class, 'getVehiclesData'])->name('garage-owner.vehicle.data'); // DataTable route
        //     Route::get('detail/{id}', [ClientsController::class, 'vehicledetail'])->name('garage-owner.vehicle.details');
        //     Route::post('store', [ClientsController::class, 'store'])->name('client.store');
        //     Route::post('view', [ClientsController::class, 'view']);
        //     Route::post('update', [ClientsController::class, 'update']);
        //     Route::delete('remove-details/{id}', [ClientsController::class, 'removedetails'])->name('garage-owner.vehicle.removedetails');
        // });

        Route::group(['prefix' => 'plans'], function () {
            Route::get('list', [PlansController::class, 'index'])->name('plans.index');
        });
    });

    // User Routes
    Route::middleware('role:User')->group(function () {
        Route::get('/user-dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard.user');
    });
});

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// AJAX Routes for Location Selection
Route::get('/get-states/{country}', [LocationController::class, 'getStates']);
Route::get('/get-cities/{state}', [LocationController::class, 'getCities']);

// Auth Routes
require __DIR__.'/auth.php';
