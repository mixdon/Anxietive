<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PricelistController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::get('/pricelist', [PricelistController::class, 'index'])->name('pricelist');

Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::get('/booking/schedule/{studio}', [BookingController::class, 'schedule'])->name('booking.schedule');
Route::get('/booking/form', [BookingController::class, 'form'])->name('booking.form');
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');