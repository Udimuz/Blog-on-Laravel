<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Models\Category;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request) {
		$data = $request->validated();
		//dd($data);
		Category::firstOrCreate($data);	// Такой отимизированный вариант. Поэтому, важно делать названия в базе и в формах одинаково
		// Полная работа метода выглядит следующим образом:		Делает тоже самое что это:
//		$category = Category::firstOrCreate(['title'=>$data['title']], [
//			'title'=>$data['title']
//		]);
		return redirect()->route('admin.category.index');
	}
}
