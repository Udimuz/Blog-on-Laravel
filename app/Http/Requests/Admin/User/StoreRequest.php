<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'role' => 'required|integer',
        ];
    }

	// Для каждого атрибута (проверки) можно придумать свои правила-уведомления: Что мы хотим донести до пользователя, необходимые технические требования
	public function messages()
	{
		return [
			'name.required' => 'Необходимо дать имя',
			'name.string' => 'Имя должно быть строкой',
			'email.required' => 'Это поле необходимо для заполнения',
			'email.string' => 'Почта должна быть строкой',
			'email.email' => 'Ваша почта должна соответствовать формату name@some.domain.com',
			'email.unique' => 'Пользователь с таким Email уже существует',

			'password.required' => 'Это поле необходимо для заполнения',
			'password.string' => 'Пароль должен быть строкой',
		];
	}
}
