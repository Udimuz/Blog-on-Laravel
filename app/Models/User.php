<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

	const ROLE_ADMIN = 0;
	const ROLE_VISITOR = 1;		//	ROLE_READER

	public static function getRoles()
	{
		return [
			self::ROLE_ADMIN => 'Админ',
			self::ROLE_VISITOR => 'Читатель',
		];
		// Аналог этого:
//		return [
//			0 => 'Админ',
//			1 => 'Читатель',
//		];
	}

	//	Отношения: многие-ко-многим
	public function likedPosts()
	{
		return $this->belongsToMany(Post::class, 'post_user_likes', 'user_id', 'post_id');
	}

	//	Отношения: один-ко-многим
	public function comments()
	{
		//return $this->hasMany(Comment::class, 'user_id', 'id');
	}

	public function post() {
		// - имеет один -
		return $this->hasOne(Post::class, 'id', 'post_id');
	}

	protected $fillable = [
        'name',
        'email',
        'password',
		'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
