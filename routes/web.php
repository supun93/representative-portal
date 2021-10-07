<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/login/student', 'Auth\LoginController@studentLogin');
Auth::routes();
Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/dashboard', 'FetchController@dashboard');
    Route::get('/home', 'FetchController@dashboard')->name('home');
    Route::get('/', 'FetchController@dashboard')->name('dashbord');
    Route::get('/activity/log', 'FetchController@activityLog')->name('activity.list');
    Route::get('/profile', 'FetchController@profile')->name('profile');
    
    Route::prefix('datatable')->group(function() {
        Route::post('activity-log', 'FetchController@activityLogLoad')->name('activity-log-list.load');
    });
});
