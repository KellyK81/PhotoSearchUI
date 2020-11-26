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
    return view('default.index');
})->name('home');

Route::get('/login', function () {
    return view('login.index');
})->name('login');

Route::post('/login', 'App\Http\Controllers\ApiAuthController@login');
Route::get('/logout', 'App\Http\Controllers\ApiAuthController@logout');

Route::get('/search', 'App\Http\Controllers\SearchController@search')->name('search');

Route::get('/search/history', 'App\Http\Controllers\SearchController@searchHistory')->name('search_history');

Route::get('/forgot_password', function () {
    return view('login.forgot_password');
})->name('forgot_password');

Route::get('/register', function () {
    return view('login.register');
})->name('register');

