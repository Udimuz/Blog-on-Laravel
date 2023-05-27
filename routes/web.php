<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//	return '12345';		//return view('welcome');
//});

// Корневая папка сайта:
Route::group(['namespace'=>'App\Http\Controllers\Main'], function(){
	Route::get('/', 'IndexController')->name('main.index');
});

// Сообщения:
Route::group(['namespace'=>'App\Http\Controllers\Post', 'prefix'=>'posts'], function(){
	Route::get('/', 'IndexController')->name('post.index');
	Route::get('/{post}', 'ShowController')->name('post.show');

	// Такой вариант сборки (приём) называется "нестед роут", вложенный роут (вложенные ссылки)
	// Для запуска страницы по адресу "/post/10/comments":
	Route::group(['namespace'=>'Comment', 'prefix'=>'{post}/comments'], function() {
		Route::post('/', 'StoreController')->name('post.comment.store');
	});

	// Ещё один вложенный роутинг, для Лайков:
	Route::group(['namespace'=>'Like', 'prefix'=>'{post}/likes'], function() {
		Route::post('/', 'StoreController')->name('post.like.store');
	});

});

// Категории:
Route::group(['namespace'=>'App\Http\Controllers\Category', 'prefix'=>'categories'], function(){
	// Для запуска страницы по адресу "/categories/":
	Route::get('/', 'IndexController')->name('category.index');

	// Для запуска страницы по адресу "/categories/3":
	Route::group(['namespace'=>'Post', 'prefix'=>'{category}'], function() {
		Route::get('/', 'IndexController')->name('category.post.index');
	});
});

// Админ-часть сайта:
// prefix добавит везде к ссылке впереди адрес "/admin/". Это чтобы не создавать такие роуты '/admin/post', '/admin/add', а сократить
Route::group(['namespace'=>'App\Http\Controllers\Admin', 'prefix'=>'admin', 'middleware'=>['auth','verified','admin_mdl']], function() {
//	Route::group(['namespace'=>'Main'], function(){
//		Route::get('/', 'IndexController')->name('admin.main.index');
//	});
	// Для запуска страницы по адресу "/admin/":
	Route::get('/', 'Main\IndexController')->name('admin.main.index');	// Это автоматически перекидывает в Вид:	'resources/views/admin/main/index.blade.php' потому что так указано в контроллере IndexController
	// Категории - с добавлением prefix:
	Route::group(['namespace'=>'Category', 'prefix'=>'categories'], function(){
		// Для запуска страницы по адресу "/admin/categories":
		Route::get('/', 'IndexController')->name('admin.category.index');
		Route::get('/create', 'CreateController')->name('admin.category.create');
		Route::post('/', 'StoreController')->name('admin.category.store');
		Route::get('/{category}', 'ShowController')->name('admin.category.show');
		Route::get('/{category}/edit', 'EditController')->name('admin.category.edit');
		Route::patch('/{category}', 'UpdateController')->name('admin.category.update');
		Route::delete('/{category}', 'DeleteController')->name('admin.category.delete');
	});
	// Теги:	по аналогии с Категориями
	Route::group(['namespace'=>'Tag', 'prefix'=>'tags'], function(){
		// Для запуска страницы по адресу "/admin/tags/":
		Route::get('/', 'IndexController')->name('admin.tag.index');
		Route::get('/create', 'CreateController')->name('admin.tag.create');
		Route::post('/', 'StoreController')->name('admin.tag.store');
		Route::get('/{tag}', 'ShowController')->name('admin.tag.show');
		Route::get('/{tag}/edit', 'EditController')->name('admin.tag.edit');
		Route::patch('/{tag}', 'UpdateController')->name('admin.tag.update');
		Route::delete('/{tag}', 'DeleteController')->name('admin.tag.delete');
	});
	// Сообщения:
	Route::group(['namespace'=>'Post', 'prefix'=>'posts'], function(){
		// Для запуска страницы по адресу "/admin/posts":
		Route::get('/', 'IndexController')->name('admin.post.index');
		Route::get('/create', 'CreateController')->name('admin.post.create');
		// Здесь делали перенаправление на '/', но я решил указать '/store' чтобы точнее видеть. А то со страницей создания путал
		Route::post('/store', 'StoreController')->name('admin.post.store');
		Route::get('/{post}', 'ShowController')->name('admin.post.show');
		Route::get('/{post}/edit', 'EditController')->name('admin.post.edit');
		Route::patch('/{post}', 'UpdateController')->name('admin.post.update');
		Route::delete('/{post}', 'DeleteController')->name('admin.post.delete');
	});
	// Пользователи:
	Route::group(['namespace'=>'User', 'prefix'=>'users'], function(){
		// Для запуска страницы по адресу "/admin/users/":
		Route::get('/', 'IndexController')->name('admin.user.index');
		Route::get('/create', 'CreateController')->name('admin.user.create');
		Route::post('/', 'StoreController')->name('admin.user.store');
		Route::get('/{user}', 'ShowController')->name('admin.user.show');
		Route::get('/{user}/edit', 'EditController')->name('admin.user.edit');
		Route::patch('/{user}', 'UpdateController')->name('admin.user.update');
		Route::delete('/{user}', 'DeleteController')->name('admin.user.delete');
	});
});

// Кабинет пользователя:
Route::group(['namespace'=>'App\Http\Controllers\Personal', 'prefix'=>'personal', 'middleware'=>['auth','verified']], function() {
	// Для запуска страницы по адресу "/personal/main":
//	Route::group(['namespace'=>'Main', 'prefix'=>'main'], function(){
//		Route::get('/', 'IndexController')->name('personal.main.index');
//	});
	// Для запуска страницы по адресу "/personal":	Переделал в такое, чтобы меню слева лучше подсвечивало
	Route::get('/', 'Main\IndexController')->name('personal.main.index');

	// Для страницы по адресу "/personal/liked":
	Route::group(['namespace'=>'Liked', 'prefix'=>'liked'], function(){
		Route::get('/', 'IndexController')->name('personal.liked.index');
		Route::delete('/{post}', 'DeleteController')->name('personal.liked.delete');
		// Страница одного Сообщения "/personal/liked/4":
		Route::get('/{post}', [App\Http\Controllers\Personal\Main\IndexController::class,'postShow'])->name('personal.post.show');
	});
	// Для страницы по адресу "/personal/comments":
	Route::group(['namespace'=>'Comment', 'prefix'=>'comments'], function(){
		Route::get('/', 'IndexController')->name('personal.comment.index');
		Route::get('/{comment}/edit', 'EditController')->name('personal.comment.edit');
		Route::patch('/{comment}', 'UpdateController')->name('personal.comment.update');
		Route::delete('/{comment}', 'DeleteController')->name('personal.comment.delete');
	});
	// Профиль:		/personal/profile
	Route::group(['namespace'=>'Profile', 'prefix'=>'profile'], function(){
		Route::get('/', 'IndexController')->name('personal.profile.index');
		Route::patch('/', 'UpdateController')->name('personal.profile.update');
	});
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
