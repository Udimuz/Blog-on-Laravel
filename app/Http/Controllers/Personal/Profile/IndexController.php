<?php

namespace App\Http\Controllers\Personal\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
	// Для запуска страницы:	http://blog.loc/personal/profile
	public function __invoke() {
		$user = auth()->user();
		return view('personal.profile.index', compact('user'));
	}
}
