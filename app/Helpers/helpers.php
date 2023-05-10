<?php

use App\Models\Post;

if (! function_exists('postsTotalCount')) {
	function postsTotalCount(): int {
		return Post::all()->count();
	}
}
