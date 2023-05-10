<?php

namespace App\Http\Controllers\Admin\Post;

use App\Models\Post;

class IndexController extends BaseController
{
    public function __invoke() {
		$posts = Post::all();
//		$data = [
//			'postsCount' => Post::all()->count(),
//		];
		//dd($data);
		return view('admin.post.index', compact('posts'));
	}
}
