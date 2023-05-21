<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

	protected $table = 'posts';
	// Это правило нужно, чтобы изменять данные в таблице:
	protected $guarded = false;

	// Здесь может возникнуть путаница. Для вызова этого метода требуется обращаться "$post->tags()" со скобками.
	// Если обращаться без скобок "$post->tags" - это уже будет обращение к переменной tags, если такая подключена к этому объекту:
	// view('admin.post.edit', compact('post','categories', 'tags'));

	// Многие ко многим:
	public function tags() {
		return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id'); //Связываем foreign - значит "кто", related - значит "с кем имеет отношение"
	}

	//	Один ко многим:
	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id', 'id');
	}

	// Пользователи которые нажимали Лайк:
	public function likedUsers()
	{
		return $this->belongsToMany(User::class, 'post_user_likes', 'post_id', 'user_id');
	}

}
