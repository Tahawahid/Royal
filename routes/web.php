<?php

use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// Main page - Quote form with detailed intro
Route::get('/', function () {
    return view('quote');
})->name('quote');

Route::post('/', QuoteController::class)
    ->middleware('throttle:10,1')
    ->name('quote.store');

// Reservations
Route::view('/reservations', 'reservations')->name('reservations');

Route::post('/reservations', ReservationController::class)
    ->middleware('throttle:10,1')
    ->name('reservations.store');
