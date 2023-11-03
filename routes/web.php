<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SQLConversionController;
use App\Http\Middleware\IsSubscribed;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/refund', function () {
    return view('refund');
});
Route::get('/privacy', function () {
    return view('privacy');
});


Route::get('/dashboard', function (Request $request) {
    return $request->user()->redirectToCustomerPortal();
})->middleware(['auth','customer','verified'])->name('dashboard');
// Route::get('/buy', function (Request $request) {
//     return $request->user()->checkout('136778')
//     ->withEmail($request->user()->email)
//     ->redirectTo(url('/'));
// })->middleware(['auth', 'not-subscribed', 'verified'])->name('buy');
// use Illuminate\Http\Request;
 
Route::get('/buy', function (Request $request) {
    $checkout = $request->user()->checkout('136778');

    return view('billing', ['checkout' => $checkout]);
})->middleware(['auth', 'not-subscribed', 'verified'])->name('buy');

Route::get('/resume', function (Request $request) {
    return $request->user()->checkout('141650')
    ->withEmail(Auth::user()->email)
    ->redirectTo(url('/'));
})->middleware(['auth', 'not-subscribed', 'verified'])->name('resume');

Route::get('/update-payment-info', function (Request $request) {
    $subscription = $request->user()->subscription();

    return view('billing', [
        'paymentMethodUrl' => $subscription->updatePaymentMethodUrl(),
    ]);
})->middleware(['auth', 'verified']);
 
// Route::get('/customer-portal', function (Request $request) {
    
// });
Route::middleware('auth')->group(function () {
   
    Route::post('/convert-sql', [SQLConversionController::class, 'convert'])->middleware(IsSubscribed::class)->name('convert');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
