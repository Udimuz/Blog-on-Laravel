<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

	protected $table = 'comments';
	protected $guarded = false;

	//	Один ко многим:		Выбрать пользователя, который отправил комментарий
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	// Геттеры:		метод вызывается потом так:	$comment->DateAsCarbon, $comment->DateAsCarbon->diffForHumans()
	public function getDateAsCarbonAttribute()
	{
		//return $this->created_at;
		return Carbon::parse($this->created_at);	// К модели этого комментария здесь можно добраться через $this, потому что мы итак внутри находимся, он уже вложен
	}
}
