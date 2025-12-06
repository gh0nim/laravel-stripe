<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


// stripe routes
 Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

Route::get('/payment', [PaymentController::class, 'index'])->name('payment.form');
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
Route::get('/success', function () {
    return 'Payment Successful!';
})->name('payment.success');
Route::get('/cancel', function () {
    return 'Payment Canceled!';
})->name('payment.cancel');

require __DIR__.'/auth.php';
