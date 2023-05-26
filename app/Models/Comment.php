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

	// Здесь сам собрал привязку-Отношения, к какому Сообщению принадлежит комментарий. Обращаюсь к этому:
	// 1) в контроллере "app/Http/Controllers/Personal/Comment/IndexController.php":
	// 2) в шаблоне списка сообщений "resources/views/personal/comment/index.blade.php"
	// 3) в шаблоне редактирования сообщения "resources/views/personal/comment/edit.blade.php"
	// Во всех этих файлах вызываю название Сообщения так:	$comment->post->title
	public function post() {	// - имеет один -
		return $this->hasOne(Post::class, 'id', 'post_id');
	}

}
