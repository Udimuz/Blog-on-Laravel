<?php

namespace App\Http\Controllers\Personal\Main;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostUserLike;
use App\Models\Tag;
use App\Models\User;

class IndexController extends Controller
{
    public function __invoke() {
		//$user = auth()->user();

		$data = [
			'postLikesCount' => 12,	//PostUserLike::all()->count(),
			'commentsCount' => 34,	//auth()->user()->comments->count(),
		];

		return view('personal.main.index', compact('data'));
	}
}
