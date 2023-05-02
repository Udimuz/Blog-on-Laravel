<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
	// Для запуска страницы:	http://blog.loc/admin/categories
	public function __invoke() {
		return view('admin.categories.index');
	}
}
