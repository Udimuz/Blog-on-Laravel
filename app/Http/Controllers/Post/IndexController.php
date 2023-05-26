<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke() {
		// После добавления в метод Post свойства "$withCount = ['likedUsers']" запускать "withCount()" нет необходимости:
		//$posts = Post::withCount('likedUsers')->paginate(6);
		//$posts = Post::paginate(6);
		// Пойдём дальше, соберём кол-во комментарием к каждому Сообщению:
		// Можно было это добавить прямо в методе Post, но тогда это будет запускать Sql-запрос при каждом вызове Сообщений, а я этого не хочу
		$posts = Post::withCount('comments')->paginate(6);
		//$posts = Post::with('category')->paginate(6);
		$randomPosts = Post::get()->random(4);
		//$likedPosts = Post::withCount('likedUsers')->orderBy('liked_users_count', 'DESC')->get()->take(4);
		$likedPosts = Post::orderBy('liked_users_count', 'DESC')->get()->take(4);
		return view('post.index', compact('posts', 'randomPosts', 'likedPosts'));
	}
}
