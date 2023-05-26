<?php

namespace App\Helpers;

use App\Models\Post;

class Dima
{
	public static function postsCount()
	{
		return Post::all()->count();
	}

	public static function userInfo() {
		$user = auth()->user();
//		return !empty($user) ? $user->id." - ".$user->name.
//			(((int) auth()->user()->role === User::ROLE_ADMIN) ? " (Admin)" : " (Reader)")
		//Auth::user()->id." - ".Auth::user()->name." - ".\App\Models\User::getRoles()[auth()->user()->role]." (".Auth::user()->email.")"
		return !empty($user) ?
			$user->id." - ".$user->name." - ".\App\Models\User::getRoles()[$user->role]." (".$user->email.")"
			: "-|-";
	}
}