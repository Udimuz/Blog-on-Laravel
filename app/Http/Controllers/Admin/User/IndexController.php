<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
	// Для запуска страницы:	http://blog.loc/admin/users
	public function __invoke() {
		$users = User::all();
		$roles = User::getRoles();
		return view('admin.user.index', compact('users','roles'));
	}
}
