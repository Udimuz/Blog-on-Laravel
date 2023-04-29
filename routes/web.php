<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//	return '12345';		//return view('welcome');
//});

// Корневая папка сайта:
Route::group(['namespace'=>'App\Http\Controllers\Main'], function(){
	Route::get('/', 'IndexController')->name('main.index');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
