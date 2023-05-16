<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		//dump(12345678);
		//dd(auth()->check());
		//dd((int) auth()->user()->role);
		//dd(auth()->user()->name);
		/*
		Здесь учитель не доделал проверку. Проверял только это:		auth()->user()->role
		Если страницу открывал вообще неавторизованный пользователь, выдавало ошибку:	Attempt to read property "role" on null
		Я добавил "auth()->check()" - теперь проверка заработала чётко
		Потом мы в роутах добавили стандартную проверку авторизации Ларавел. Поэтому, неавториованный сюда не зайдёт, и эта проверка "auth()->check()" уже не нужна, она будет всегда true
		*/
		// Нужно подключить приведение типов (int) потому что из базы могут браться данные типа String. Хотя, у меня и без этого работало, в базе у меня тип Integer. Может, это у учителя там был тип String
		//if (auth()->check() === false  ||  (int) auth()->user()->role !== \App\Models\User::ROLE_ADMIN)
		if ((int) auth()->user()->role !== \App\Models\User::ROLE_ADMIN)
			abort(403);
			//return redirect()->route('personal.main.index');
        return $next($request);
    }
}
