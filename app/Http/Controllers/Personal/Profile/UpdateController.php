<?php

namespace App\Http\Controllers\Personal\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personal\Profile\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
	public function __invoke(UpdateRequest $request)
	{
		$user = auth()->user();
		$data = $request->validated();
		if (isset($data['password'])) {
			$data['password'] = Hash::make($data['password']);	// Переназначаем данные, зашифровав полученные данные
		} else
			$data['password'] = $user->password;	// Если пароль не меняли, сохраняем пароль прежний

		$user->update($data);
		// return view('personal.profile.index', compact('user'));	// С таким способом будет оставаться обновление данных в браузере. Если нажать F5, будет спрашивать: Подтвердите повторную отправку формы
		// Перекидывание на другую страницу:
		return redirect()->route('personal.profile.index');
	}
}
