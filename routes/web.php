<?php

use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\RideController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Driver\Auth\RegisterController;
use App\Http\Controllers\Driver\PagesController as DriverPagesController;
use App\Http\Controllers\Driver\ProfileController;
use App\Http\Controllers\Driver\RideController as DriverRideController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\PagesController as UserPagesController;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([
    'as' =>'user.',
    'middleware'=>'auth'
], function(){

    Route::get('/ride', function () {
        return view('users.pages.home');
    });
    Route::get('/drivers', [UserPagesController::class,'nearByDrivers'])->name('drivers');
    Route::resource('bookings', BookingController::class)->only(['index','show','store']);
    Route::post('bookings/{id}',[ BookingController::class, 'cancelRide'])->name('bookings.cancel');
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



Route::get('/driver/register', [RegisterController::class,'show'])->name('driver.register');
Route::post('/driver/register', [RegisterController::class,'register'])->name('driver.register');
Route::get('/about', [AboutController::class, 'about']);


