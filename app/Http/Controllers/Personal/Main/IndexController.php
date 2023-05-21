<?php

namespace App\Http\Controllers\Personal\Main;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostUserLike;
use App\Models\Tag;
use App\Models\User;
use JetBrains\PhpStorm\NoReturn;

class IndexController extends Controller
{
    public function __invoke() {
		//$user = auth()->user();

		$data = [
			'postLikesCount' => PostUserLike::all()->count(),
			'commentsCount' => 34,	//auth()->user()->comments->count(),
		];

		return view('personal.main.index', compact('data'));
	}

	public function postShow(Post $post): \Illuminate\View\View
	{
		return view('personal.liked.post_show', compact('post'));
	}
}
