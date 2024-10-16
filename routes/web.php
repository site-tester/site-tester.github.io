<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\NotificationController;

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

Route::get('/test', function () {
    return view('main.confirmation_page');
});

Route::get('/', [Controller::class, 'landing'])->name('landing');
// Route::get('/terms-and-conditions', [Controller::class, 'terms'])->name('terms');

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {
    Route::get('/home', [Controller::class, 'landing'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('donor.dashboard');
    Route::get('/profile', [HomeController::class, 'viewProfile'])->name('profile');
    Route::get('/donate-now', [HomeController::class, 'viewDonateNow'])->name('donate-now');
    Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');
    Route::get('/my-donation', [DonationController::class, 'myDonation'])->name('my.donation');
    Route::get('/donation/view/{id}', [DonationController::class, 'show'])->name('donation.modal');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notif.markAsRead');
});

Route::get('{page}/{subs?}', ['uses' => '\App\Http\Controllers\PageController@index'])
    ->where(['page' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*']);
