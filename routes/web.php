<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\SocialAnalysis\DisplayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return view('auth/login');
});

Route::get('login', [LoginController::class, 'index'])->name('login');

Route::group([
    'prefix' => 'auth',
], function () {
    // Redirect to provider auth page
    Route::get('{provider}', [SocialAuthController::class, 'redirectToProvider'])
    ->whereIn('provider', ['twitter']);
    // Provider callback
    Route::get('{provide}/callback', [SocialAuthController::class, 'handleProviderCallback']);
});

Route::middleware(['auth'])->group(function () {
    // Display the tweets, most posting user and most domains
    Route::get('display', [DisplayController::class, 'display'])->name('display');
    // Fetch new data from Twitter and update it to DB
    Route::get('refresh', [DisplayController::class, 'refresh'])->name('refresh');
});