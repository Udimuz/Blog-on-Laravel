<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

	// Делаем привязку к таблице:	Хотя Ларавел сам создаём у себя такую привязку.
	// Но так указать ещё, будет лучше, чтобы ориентироваться. А в некоторых компаниях это требование.
	protected $table = 'categories';
	// Это правило нужно, чтобы изменять данные в таблице:
	protected $guarded = false;
	protected $withCount = ['posts'];	// Также прикрепим Отношения (Категорий с Сообщениями) которые должны быть посчитаны (что метод posts() ниже в этом коде). Сколько сообщений в каждой категории

	// Отношения с Сообщениями:
	public function posts()
	{
		return $this->hasMany(Post::class, 'category_id', 'id');
	}
}
