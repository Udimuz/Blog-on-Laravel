<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostUserLike extends Model
{
    use HasFactory;
	protected $table = 'post_user_likes';
	protected $guarded = false;
	public $timestamps = false;	// Если выбирать "Не создавать колонки с датами в таблице", нужно в модель добавить это свойство. Иначе, выйдет ошибка
}
