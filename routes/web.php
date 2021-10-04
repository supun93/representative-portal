<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/login/student', 'Auth\LoginController@studentLogin');
Auth::routes();
Route::group(['middleware' => 'auth:web'], function () {
    //Route::get('/', 'HomeController@home')->name('home');
    Route::get('/', 'FetchController@dashboard')->name('home');
    
});
