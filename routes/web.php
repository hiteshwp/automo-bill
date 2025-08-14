<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\GarageOwnerController;
use App\Http\Controllers\RepairOrderController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\SearchClientController;
use App\Http\Controllers\SearchVehicleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
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
            Route::post('client/editview', [GarageOwnerController::class, 'clienteditview']);
            Route::post('client/update', [GarageOwnerController::class, 'clientupdate']);
            Route::delete('client/remove-details/{id}', [GarageOwnerController::class, 'clientremovedetails'])->name('garageowner.client.removedetails');
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

        // Search Client Management
        Route::group(['prefix' => 'search'], function () {
            Route::get('clients', [SearchClientController::class, 'searchClient'])->name('admin.searchclient.list');
            Route::post('search/client/data', [SearchClientController::class, 'getSearchClientData'])->name('admin.searchclient.data');
            Route::get('vehicles', [SearchVehicleController::class, 'searchVehicle'])->name('admin.searchVehicle.list');
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

        // 🚀 Supplier Management (Garage Owner Only)
        Route::group(['prefix' => 'supplier'], function () {
            Route::get('list', [SupplierController::class, 'index'])->name('garage-owner.suppliers.list');
            Route::post('data', [SupplierController::class, 'getSupplierData'])->name('garage-owner.suppliers.data'); // DataTable route
            Route::post('store', [SupplierController::class, 'store'])->name('garage-owner.suppliers.admin.store');
            Route::post('view', [SupplierController::class, 'supplierView']);
            Route::post('editview', [SupplierController::class, 'editview']);
            Route::post('update', [SupplierController::class, 'update']);
            Route::delete('remove-details/{id}', [SupplierController::class, 'removedetails'])->name('garage-owner.suppliers.removedetails');
        });

        // 🚀 Products Management (Garage Owner Only)
        Route::group(['prefix' => 'product'], function () {
            Route::get('list', [ProductController::class, 'index'])->name('garage-owner.product.list');
            Route::post('data', [ProductController::class, 'getProductData'])->name('garage-owner.product.data'); // DataTable route
            Route::post('store', [ProductController::class, 'store'])->name('garage-owner.product.admin.store');
            Route::post('editview', [ProductController::class, 'editview']);
            Route::post('update', [ProductController::class, 'update']);
            Route::delete('remove-details/{id}', [ProductController::class, 'removedetails'])->name('garage-owner.product.removedetails');
        });

        // 🚀 Purchase Management (Garage Owner Only)
        Route::group(['prefix' => 'purchase'], function () {
            Route::get('list', [PurchaseController::class, 'index'])->name('garage-owner.purchase.list');
            Route::post('data', [PurchaseController::class, 'getPurchaseData'])->name('garage-owner.purchase.data'); // DataTable route
            Route::post('getsupplierdetail', [PurchaseController::class, 'getsupplierdetail']);
            Route::post('getproductdetail', [PurchaseController::class, 'getproductdetail']);
            Route::post('store', [PurchaseController::class, 'store'])->name('garage-owner.purchase.admin.store');
            Route::post('getviewpurchasedetails', [PurchaseController::class, 'getViewPurchaseDetails']);
            Route::post('editview', [PurchaseController::class, 'editview']);
            Route::post('update', [PurchaseController::class, 'update']);
            Route::delete('remove-details/{id}', [PurchaseController::class, 'removedetails'])->name('garage-owner.purchase.removedetails');
        });

        // 🚀 Stock Management (Garage Owner Only)
        Route::group(['prefix' => 'stock'], function () {
            Route::get('list', [StockController::class, 'index'])->name('garage-owner.stock.list');
            Route::post('data', [StockController::class, 'getStockData'])->name('garage-owner.stock.data'); // DataTable route
        });

        // 🚀 Booking Management (Garage Owner Only)
        Route::group(['prefix' => 'booking'], function () {
            Route::get('list', [BookingController::class, 'index'])->name('garage-owner.booking.list');
            Route::post('data', [BookingController::class, 'getBookingData'])->name('garage-owner.booking.data'); // DataTable route
            Route::post('getuserdetail', [BookingController::class, 'getUserDetail']);
            Route::post('store', [BookingController::class, 'store'])->name('garage-owner.booking.store');
            Route::post('getviewbookingdetails', [BookingController::class, 'getViewBookingDetails']);
            Route::post('update', [BookingController::class, 'update']);
            Route::delete('remove-details/{id}', [BookingController::class, 'removedetails'])->name('garage-owner.booking.removedetails');
            Route::delete('convert-normal-booking/{id}', [BookingController::class, 'convertdetails'])->name('garage-owner.booking.convertdetails');
        });

        // 🚀 Estimate Management (Garage Owner Only)
        Route::group(['prefix' => 'estimate'], function () {
            Route::get('new/booking/{id}', action: [EstimateController::class, 'index'])->name('garage-owner.estimate.new');
            Route::post('store', [EstimateController::class, 'store'])->name('garage-owner.estimate.store');
            Route::get('list', [EstimateController::class, 'list'])->name('garage-owner.estimate.list');
            Route::post('data', [EstimateController::class, 'getEstimateData'])->name('garage-owner.estimate.data'); // DataTable route
            Route::get('{id}/edit/', action: [EstimateController::class, 'edit'])->name('garage-owner.estimate.edit');
        });

        // 🚀 Repair Order Management (Garage Owner Only)
        Route::group(['prefix' => 'repair-order'], function () {
            Route::get('new/estimate/{id}', action: [RepairOrderController::class, 'index'])->name('garage-owner.repair-order.new');
            Route::post('store', [RepairOrderController::class, 'store'])->name('garage-owner.repair-order.store');
            Route::get('list', [RepairOrderController::class, 'list'])->name('garage-owner.repair-order.list');
            Route::post('data', [RepairOrderController::class, 'getRepairOrderData'])->name('garage-owner.repair-order.data'); // DataTable route
            Route::get('{id}/edit/', action: [RepairOrderController::class, 'edit'])->name('garage-owner.repair-order.edit');
        });

        // 🚀 Invoice Management (Garage Owner Only)
        Route::group(['prefix' => 'invoice'], function () {
            Route::get('new/repair-order/{id}', action: [InvoiceController::class, 'index'])->name('garage-owner.invoice.new');
            Route::post('store', [InvoiceController::class, 'store'])->name('garage-owner.invoice.store');
            Route::get('list', [InvoiceController::class, 'list'])->name('garage-owner.invoice.list');
            Route::post('data', [InvoiceController::class, 'getInvoiceData'])->name('garage-owner.invoice.data'); // DataTable route
            Route::post('getviewinvoicedetails', [InvoiceController::class, 'getViewInvoiceDetails']);
            Route::get('{id}/edit/', action: [InvoiceController::class, 'edit'])->name('garage-owner.invoice.edit');
        });

        Route::group(['prefix' => 'profile'], function () {
            Route::get('/view', [DashboardController::class, 'garageOwnerProfile'])->name('garage-owner.profile');
            Route::post('/update-profile-image', [DashboardController::class, 'updateGarageOwnerImage'])->name('garage-owner.profile.updateImage');
            Route::post('/update', [DashboardController::class, 'updateGarageOwnerProfile'])->name('garage-owner.profile.update');
            Route::post('/change-password', [DashboardController::class, 'updateGarageOwnerPassword'])->name('garage-owner.profile.change-password');
        });

         Route::group(['prefix' => 'settings'], function () {
            Route::get('/view', [SettingController::class, 'index'])->name('garage-owner.setting');
            Route::post('/update-financial-settings', [SettingController::class, 'updateFinancialSettings'])->name('garage-owner.settings.financial-setting');
            Route::post('/update-company-settings', [SettingController::class, 'updateCompanySettings'])->name('garage-owner.settings.company-setting');
        });

        Route::get('/send-welcome', [DashboardController::class, 'sendWelcomeEmail']);

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
