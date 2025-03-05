<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

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
    });

    // Garage Owner Routes
    Route::middleware('role:Garage Owner')->group(function () {
        Route::get('/garage-owner-dashboard', [DashboardController::class, 'garageOwner'])->name('dashboard.garage-owner');
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
