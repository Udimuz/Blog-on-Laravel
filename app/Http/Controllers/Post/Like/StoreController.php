<?php

namespace App\Http\Controllers\Post\Like;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;

class StoreController extends Controller
{
    public function __invoke(Post $post) {
		auth()->user()->likedPosts()->toggle($post->id);
		//return redirect()->route('post.index');
		// Это даже лучше работает:	позволяет запомнить страницу, где была нажата кнопка Лайк, и вернуться на неё
		return redirect()->back();
		// Потому что кнопка Лайк может нажиматься и на странице списка Сообщений и на странице одного сообщения
	}
}
