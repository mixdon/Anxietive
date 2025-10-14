<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PricelistController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\BookingAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerAdminController;
use App\Http\Controllers\DashboardController;

// PUBLIC ROUTES
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::get('/pricelist', [PricelistController::class, 'index'])->name('pricelist');
Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::get('/booking/schedule/{id}', [BookingController::class, 'schedule'])->name('booking.schedule');

// BOOKING FORM
Route::get('/booking/form', [BookingController::class, 'form'])->name('booking.form');
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/check-availability/{studio}/{date}', [BookingController::class, 'checkAvailability'])
    ->name('booking.checkAvailability');

// CUSTOMER AUTH
Route::controller(CustomerAuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('customer.login');
    Route::post('/login', 'login')->name('customer.login.post');
    Route::get('/register', 'showRegisterForm')->name('customer.register');
    Route::post('/register', 'register')->name('customer.register.post');
    Route::post('/logout', 'logout')->name('customer.logout');
});

// CUSTOMER PANEL
Route::middleware('auth.customer')->prefix('customer')->name('customer.')->group(function () {
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [CustomerController::class, 'updateProfile'])->name('profile.update');
    Route::get('/bookings', [CustomerController::class, 'bookings'])->name('bookings');
});

// ADMIN AUTH
Route::prefix('admin')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('admin.login.post');
    Route::post('/logout', 'logout')->name('logout');
});

// ADMIN PANEL
Route::prefix('admin')->name('admin.')->middleware('auth.admin')->group(function () {

    // dashboard (sesuai controller index method)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // package
    Route::controller(PackageController::class)->group(function () {
        Route::get('/data-package', 'index')->name('data-package');
        Route::get('/data-package/create', 'create')->name('data-package.create');
        Route::post('/data-package', 'store')->name('data-package.store');
        Route::get('/data-package/{id}/edit', 'edit')->name('data-package.edit');
        Route::put('/data-package/{id}', 'update')->name('data-package.update');
        Route::delete('/data-package/{id}', 'destroy')->name('data-package.destroy');
    });

    // office
    Route::controller(OfficeController::class)->group(function () {
        Route::get('/data-office', 'index')->name('data-office.index');
        Route::post('/data-office/store', 'store')->name('data-office.store');
        Route::put('/data-office/update/{id}', 'update')->name('data-office.update');
        Route::delete('/data-office/destroy/{id}', 'destroy')->name('data-office.destroy');
    });

    // admin
    Route::controller(UserController::class)->group(function () {
        Route::get('/data-admin', 'index')->name('data-admin');
        Route::post('/data-admin', 'store')->name('data-admin.store');
        Route::put('/data-admin/{id}', 'update')->name('data-admin.update');
        Route::delete('/data-admin/{id}', 'destroy')->name('data-admin.destroy');
    });

    // customer
    Route::controller(CustomerAdminController::class)->group(function () {
        Route::get('/data-customer', 'index')->name('data-customer');
        Route::post('/data-customer', 'store')->name('data-customer.store');
        Route::put('/data-customer/{id}', 'update')->name('data-customer.update');
        Route::delete('/data-customer/{id}', 'destroy')->name('data-customer.destroy');
    });

    // bookings
    Route::controller(BookingAdminController::class)->group(function () {
        Route::get('/bookings', 'index')->name('bookings.index');
        Route::post('/bookings/{id}/status', 'updateStatus')->name('bookings.updateStatus');
    });
});
