<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request) {
		$data = $request->validated();
		$data['password'] = Hash::make($data['password']);	// Переназначаем данные, зашифровав полученные данные
		//dd($data);
		// Здесь нужно указать признак, по которому будем делать firstOrCreate(). Здесь у нас этот признак 'email' - п.ч. у нас Email-адрес в таблице у пользователей уникальный, даже можно посмотреть это по ключу
		$user = User::firstOrCreate(['email' => $data['email']], $data);	// Проверять наличие по email-адресу, так как он в базе уникальный (ключ users_email_unique)
		return redirect()->route('admin.user.index');
	}
}
