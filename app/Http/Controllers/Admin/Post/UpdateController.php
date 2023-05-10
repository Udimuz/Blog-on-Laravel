<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\UpdateRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class UpdateController extends BaseController
{
	public function __invoke(UpdateRequest $request, Post $post) {
		$data = $request->validated();
		$post = $this->service->update($data, $post);
		return view('admin.post.show', compact('post'));
	}

	public function __invoke_lesson(UpdateRequest $request, Post $post) {
		try {
			$data = $request->validated();

			// Если я не выбирал картинку для изменения, у меня вылетала ошибка. Потому что не приходили параметры $data['main_image', 'preview_image']. Сам поставил такие проверки:
			if (isset($data['preview_image'])) {
				if (!empty($post->preview_image))
					Storage::disk('public')->delete($post->preview_image);
				$previewImage = $data['preview_image'];
				$preview_image_name = "pr_".time().".".$previewImage->getClientOriginalExtension();
				$data['preview_image'] = Storage::disk('public')->putFileAs('images', $previewImage, $preview_image_name);
			}
			if (isset($data['main_image'])) {
				if (!empty($post->main_image))
					Storage::disk('public')->delete($post->main_image);
				$mainImage = $data['main_image'];
				$main_image_name = "rez_".time().".".$mainImage->getClientOriginalExtension();
				$data['main_image'] = Storage::disk('public')->putFileAs('images', $mainImage, $main_image_name);
			}
			// Данные после обработки, снова помещаются в массив $data, чтобы проще это добавлять в базу, одним обращением update($data)

			// Теги - сбор:
			if (isset($data['tag_ids'])) {
				$tagIds = $data['tag_ids'];
				unset($data['tag_ids']);    // После сбора, нужно уничтожить эти данные в массиве $data чтобы не было конфликта (при добавлении в таблицу post)
			} else $tagIds = [];

			// Обновление данных в таблице "post":
			$post->update($data);

			// Теги. С помощью отношений в модели Post, сохранит связи Тегов в таблицу post_tags:
			// Нужно чтобы все старые Теги удалялись. И добавлялись Теги которые приходят.	attach здесь уже не подойдёт
			// При обновлении данных используется другая функция - sync()
			$post->tags()->sync($tagIds);		// sync() по сути дела, он все моменты что существовали до этого удаляет, и прибавляет только те что приходят
		} catch (\Exception $exception) {
			abort(404);	// Прекратить выполнение
		}
		return view('admin.post.show', compact('post'));
	}

	public function __invoke_prev(UpdateRequest $request, Post $post) {
		try {
			$data = $request->validated();
			//dd($data);

			$tagIds = $data['tag_ids'];
			unset($data['tag_ids']);

			// Если я не выбирал картинку для изменения, у меня вылетала ошибка. Потому что не приходили параметры $data['main_image', 'preview_image']. Сам поставил такие проверки:
			if (isset($data['main_image']))
				$data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);
			if (isset($data['preview_image']))
				$data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
			// Данные после обработки, снова помещаются в массив $data, чтобы проще это добавлять в базу, одним обращением update($data)

			$post->update($data);

			// Здесь, вместо "attach()" используем метод "sync()", который удаляет абсолютно все привязки у поста с тегами, и добавляет только те, которые мы указали в $tagIds
			$post->tags()->sync($tagIds);
		} catch (\Exception $exception) {
			abort(404);	// Прекратить выполнение
		}

		return view('admin.post.show', compact('post'));
	}
}
