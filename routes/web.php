<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//	return '12345';		//return view('welcome');
//});

// Корневая папка сайта:
Route::group(['namespace'=>'App\Http\Controllers\Main'], function(){
	Route::get('/', 'IndexController')->name('main.index');
});

// Админ-часть сайта:
// prefix добавит везде к ссылке впереди адрес "/admin/". Это чтобы не создавать такие роуты '/admin/post', '/admin/add', а сократить
Route::group(['namespace'=>'App\Http\Controllers\Admin', 'prefix'=>'admin'], function() {
	Route::group(['namespace'=>'Main'], function(){
		// Для запуска страницы по адресу "/admin/":
		Route::get('/', 'IndexController')->name('admin.main.index');
		// Это автоматически перекидывает в Вид:	'resources/views/admin/main/index.blade.php'
		// потому что так указано в контроллере IndexController
	});
	// Категории - с добавлением prefix:
	Route::group(['namespace'=>'Category', 'prefix'=>'categories'], function(){
		// Для запуска страницы по адресу "/admin/categories":
		Route::get('/', 'IndexController')->name('admin.category.index');
		Route::get('/create', 'CreateController')->name('admin.category.create');
		Route::post('/', 'StoreController')->name('admin.category.store');
		Route::get('/{category}', 'ShowController')->name('admin.category.show');
	});
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
