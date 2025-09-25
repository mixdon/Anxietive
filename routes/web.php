<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PricelistController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::get('/pricelist', [PricelistController::class, 'index'])->name('pricelist');
Route::view('/booking', 'booking')->name('booking');