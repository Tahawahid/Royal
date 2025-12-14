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
Route::get('/reservations', function () {
    dd('Route reached'); // Debug point 1

    $timeOptions = [];
    for ($hour = 0; $hour < 24; $hour++) {
        foreach ([0, 30] as $minute) {
            $timeOptions[] = sprintf('%02d:%02d', $hour, $minute);
        }
    }
    return view('reservations', compact('timeOptions'));
})->name('reservations');

Route::post('/reservations', ReservationController::class)
    ->middleware('throttle:10,1')
    ->name('reservations.store');
