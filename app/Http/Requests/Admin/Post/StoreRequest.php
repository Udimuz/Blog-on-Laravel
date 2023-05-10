<?php

namespace App\Http\Requests\Admin\Post;

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
    public function rules() {
		// ! 04.01.2023 заметил, если в параметр включить значение 'string' то оно тоже становится обязательным для заполнения. Словно поставлено "required". Мучался полчаса, не мог понять, почему меня обратно на прошлую страницу перекидывает.
		// ! 05.05.2023 заметил: Если в этом поле визуального редактора, который в <textarea> что-то добавить а потом даже всё стереть
		//  - тогда в параметре "content" всё равно передаётся некоторый HTML-код, например "<p><br></p>" сообщение уже не пустое, даже если так выглядит
		return [
			'title' => 'string',	// 'required|string'
			'content' => 'string',
			'main_image' => 'required|file',
			'preview_image' => 'required|file',
			'category_id' => 'required|integer|exists:categories,id',
			'tag_ids' => 'nullable|array',
			'tag_ids.*' => 'nullable|integer|exists:tags,id',
		];
    }

	// Для каждого атрибута (проверки) можно придумать свои правила-уведомления: Что мы хотим донести до пользователя, необходимые технические требования
	public function messages() {
		return [
			'title.string' => 'Данные должны соответствовать строчному типу',
			'content.string' => 'Данные должны соответствовать строчному типу',
			'main_image.required' => 'Это поле необходимо для заполнения',
			'main_image.file' => 'Необходимо выбрать файл',
			'preview_image.required' => 'Это поле необходимо для заполнения',
			'preview_image.file' => 'Необходимо выбрать файл',
			'category_id.integer' => 'ID категории должно быть числом',
			'category_id.exists' => 'ID категории должно быть в базе данных',
			'tag_ids.array' => 'Необходимо отправить массив данных',
		];
	}
}
