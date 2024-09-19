<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DonationController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [Controller::class, 'landing'])->name('landing');
Route::get('/terms-and-conditions', [Controller::class, 'terms'])->name('terms');

// Route::group(['prefix' => 'admin'], function () {
//     Voyager::routes();
// });

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile',[HomeController::class, 'viewProfile'])->name('profile');
    Route::get('/donate-now',[HomeController::class, 'viewDonateNow'])->name('donate-now');
    Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');
});

Route::get('{page}/{subs?}', ['uses' => '\App\Http\Controllers\PageController@index'])
    ->where(['page' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*']);
