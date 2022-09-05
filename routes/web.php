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

Route::get('login', [LoginController::class, 'index']);

Route::group([
    'prefix' => 'auth',
], function () {
    Route::get('{provider}', [SocialAuthController::class, 'redirectToProvider'])
    ->whereIn('provider', ['twitter']);
    
    Route::get('{provide}/callback', [SocialAuthController::class, 'handleProviderCallback']);
});

Route::get('display', [DisplayController::class, 'display'])->name('display');
Route::get('refresh', [DisplayController::class, 'refresh'])->name('refresh');