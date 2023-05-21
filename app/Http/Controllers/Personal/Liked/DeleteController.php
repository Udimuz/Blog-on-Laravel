<?php

namespace App\Http\Controllers\Personal\Liked;

use App\Http\Controllers\Controller;
use App\Models\Post;

class DeleteController extends Controller
{
    public function __invoke(Post $post) {
		// Отсоединит сообщение от пользователя: Это не удаление сообщения, не путать
		auth()->user()->likedPosts()->detach($post->id);

		// Далее делаем перенаправление на страницу списка:
		return redirect()->route('personal.liked.index');

		// Хотя наверно здесь можно было сразу шаблон той страницы вызывать.
		// Но тогда при обновлении страницы по F5 будет заново туда отправляться запрос (команда Удаления), не лучшее решение наверно
		//$posts = auth()->user()->likedPosts;
		//return view('personal.liked.index', compact('posts'));
	}
}
