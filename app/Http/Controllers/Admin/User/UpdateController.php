<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
	public function __invoke(UpdateRequest $request, User $user)
	{
		$data = $request->validated();
		if (isset($data['password'])) {
			$data['password'] = Hash::make($data['password']);	// Переназначаем данные, зашифровав полученные данные
		} else
			$data['password'] = $user->password;

		$user->update($data);
		// Здесь было не совсем правильно, такое запускать после обновления данных: Если человек менял у себя роль на "Читатель", ему по-прежнему открывалась страница Админки, а это неправильно
		// return view('admin.user.show', compact('user'));
		// Сам поставил перекидывание пользователя на другую страницу:
		return redirect()->route('admin.user.show', $user->id);	// 'admin.user.index'
	}
}
