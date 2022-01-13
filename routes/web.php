<?php

use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\RideController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Driver\PagesController as DriverPagesController;
use App\Http\Controllers\Driver\ProfileController;
use App\Http\Controllers\Driver\RideController as DriverRideController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => 'admin'
], function(){
    Route::get('/', [PagesController::class,'home'])->name('home');
    Route::resource('users', UserController::class);
    Route::resource('rides', RideController::class)->only(['index']);
});

Route::group([
    'prefix' => 'driver',
    'as' => 'driver.',
    'middleware' => 'driver'
], function(){
    Route::get('/', [DriverPagesController::class,'home'])->name('home');
    Route::resource('rides', DriverRideController::class);
    Route::post('rides/{id}/cancel', [DriverRideController::class,'cancel'])->name('rides.cancel');
    Route::post('rides/{id}/accept', [DriverRideController::class,'accept'])->name('rides.accept');
    Route::put('/profile', ProfileController::class)->name('profile');
    Route::view('/profile', 'driver.pages.profile.index')->name('profile');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
