<?php

namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
	// Для запуска страницы:	http://blog.loc/admin
	public function __invoke() {
//		$users = User::all();
//		$posts = Post::all();
//		$categories = Category::all();
//		$tags = Tag::all();

		$data = [
			'usersCount' => User::all()->count(),
			'postsCount' => Post::all()->count(),
			'categoriesCount' => Category::all()->count(),
			'tagsCount' => Tag::all()->count(),
		];

		return view('admin.main.index', compact('data'));
		//return view('admin.main.index');
	}
}
