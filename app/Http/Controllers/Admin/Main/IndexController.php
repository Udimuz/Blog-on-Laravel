<?php

namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
	// Для запуска страницы:	http://blog.loc/admin
	public function __invoke() {
		// return 888888888;
		return view('admin.main.index');
	}
}
