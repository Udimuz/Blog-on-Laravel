<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Mail\User\PasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request) {
		$data = $request->validated();
		// Создание случайного пароля из 6 символов длиной:
		//$password = Str::random(6);
		// Улучшил систему: Создавать случайный пароль если его не указывали вручную:
		$password = $data['password'] ?? Str::random(6);
		// Это тоже самое что:
		//$password = isset($data['password']) ? $data['password'] : Str::random(6);
		//dump($data['password']);
		//dd($password);
		// Переназначаем данные, зашифровав полученные данные:
		$data['password'] = Hash::make($password);
		//$data['password'] = Hash::make($data['password']);
		//dd($data);
		// Здесь нужно указать признак, по которому будем делать firstOrCreate(). Здесь у нас этот признак 'email' - п.ч. у нас Email-адрес в таблице у пользователей уникальный, даже можно посмотреть это по ключу
		$user = User::firstOrCreate(['email' => $data['email']], $data);	// Проверять наличие по email-адресу, так как он в базе уникальный (ключ users_email_unique)

		// с помощью методов фасада Mail отправляем новый объект класса PasswordMail передав в его конструктор сгенерированный пароль
		Mail::to($data['email'])->send(new PasswordMail($data['name'], $password));

		return redirect()->route('admin.user.index');
	}
}
