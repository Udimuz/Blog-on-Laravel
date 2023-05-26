<?php

namespace App\Http\Controllers\Personal\Comment;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class IndexController extends Controller
{
	// http://blog.loc/personal/comments
    public function __invoke() {
		//return "Comments";
		//$comments = auth()->user()->comments;
//		$comments = Comment::where('user_id', auth()->user()->id)->get();
//		$comments = Comment::where('user_id', auth()->user()->id)->with('post')->get();

		// собрал способ с привязкой Сообщений:
		$comments = auth()->user()->comments()->with('post')->get();
		return view('personal.comment.index', compact('comments'));
	}
}
