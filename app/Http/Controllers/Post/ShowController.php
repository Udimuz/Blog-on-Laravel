<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;

class ShowController extends Controller
{
    public function __invoke(Post $post) {
		$date = Carbon::parse($post->created_at);
		// Схожие посты, правильная выборка, чтобы не попался тот же пост, где мы сейчас находимся, исключить его:
		$relatedPosts = Post::where('category_id', $post->category_id)
			->where('id', '!=', $post->id)	// за исключением тукущего поста
			->get()->take(3);
		return view('post.show', compact('post', 'date', 'relatedPosts'));
	}
}
