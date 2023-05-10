<?php

namespace App\Helpers;

use App\Models\Post;

class Dima
{
	public static function postsCount()
	{
		return Post::all()->count();
	}
}