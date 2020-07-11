<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// auth
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'Backend\Auth',
], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('user', 'AuthController@user');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('logout', 'AuthController@logout');
    // auth email verify
    Route::get('/email/resend', 'EmailVerificationController@resend')->name('verification.resend');
    Route::get('/email/verify/{id}/{hash}', 'EmailVerificationController@verify')->name('verification.verify');

    Route::post('logout', 'AuthController@logout');
});

Route::group([
    'middleware' => 'api',
    'namespace' => 'Backend',
], function () {

    Route::post('user/detail', 'UserDetailController@update');
    Route::post('user/setting', 'UserDetailController@setting');
});
