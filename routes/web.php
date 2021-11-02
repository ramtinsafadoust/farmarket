<?php

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

Auth::routes(["verify"=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth','verified']);


Route::get('/auth/google','App\Http\Controllers\Auth\GoogleAuthController@redirect')->name('auth.google');
Route::get('/auth/google/callback','App\Http\Controllers\Auth\GoogleAuthController@callback');

Route::get('/auth/token','App\Http\Controllers\Auth\AuthTokenController@getToken')->name('2fa.token');
Route::post('/auth/token','App\Http\Controllers\Auth\AuthTokenController@postToken');


Route::get('/secret', function () {
    return 'Hello World';
})->middleware('auth','password.confirm');


Route::middleware('auth')->group(function () {
    Route::get('profile' ,'\App\Http\Controllers\ProfileController@index')->name('profile');
    Route::get('profile/twofactor','\App\Http\Controllers\ProfileController@manageTwoFactor')->name('profile.2fa.manage');
    Route::post('profile/twofactor','\App\Http\Controllers\ProfileController@postmanageTwoFactor')->name('post.profile.2fa.manage');


    Route::get('profile/twofactor/phone','\App\Http\Controllers\ProfileController@getPhoneVerify')->name('profile.2fa.phone');
    Route::post('profile/twofactor/phone','\App\Http\Controllers\ProfileController@postPhoneVerify');



});

