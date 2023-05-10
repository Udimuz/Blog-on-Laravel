<?php

namespace App\Service;

use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostService
{
	public function store($data) {
		try {
			Db::beginTransaction();
			$previewImage = $data['preview_image'];
			$mainImage = $data['main_image'];
			$preview_image_name = "pr_".time().".".$previewImage->getClientOriginalExtension();
			$main_image_name = "rez_".time().".".$mainImage->getClientOriginalExtension();
			//$previewImagePath = Storage::put('/images', $previewImage);

			// Данные после обработки, снова помещаются в массив $data, чтобы проще это добавлять в базу, одним обращением firstOrCreate($data)
			//$data['preview_image'] = Storage::putFileAs('images', $previewImage, $preview_image_name);
			//$data['main_image'] = Storage::putFileAs('images', $mainImage, $main_image_name);
			$data['preview_image'] = Storage::disk('public')->putFileAs('images', $previewImage, $preview_image_name);
			$data['main_image'] = Storage::disk('public')->putFileAs('images', $mainImage, $main_image_name);

			//$data['preview_image'] = Storage::put('/images/'.$preview_image_name, $previewImage);
			//$data['preview_image'] = Storage::disk('public')->putFileAs('images', $previewImage, $preview_image_name);
			//$data['preview_image'] = $request->file('preview_image')->store('images', 'public');
			//$data['preview_image'] = $request->file('preview_image')->store('images');
			//$data['preview_image'] = $request->file('preview_image')->storeAs('images', $preview_image_name);
			//$data['preview_image'] = $previewImage->move('images', $preview_image_name);
			//$data['preview_image'] = $request->file('preview_image')->move('images', $preview_image_name);
			//dd($data['preview_image']);

			// Теги - сбор:
			if (isset($data['tag_ids'])) {
				$tagIds = $data['tag_ids'];
				unset($data['tag_ids']);    // После сбора, нужно уничтожить эти данные в массиве $data чтобы не было конфликта (при добавлении в таблицу post)
			} else $tagIds = [];

			// Сохранение данных в таблице "post":
			$post = Post::firstOrCreate($data);

			// Теги - прикрепление. С помощью отношений в модели Post, сохранит связи Тегов в таблицу post_tags:
			if (!empty($tagIds))
				$post->tags()->attach($tagIds);
			Db::commit();
		} catch (Exception $exception) {
			Db::rollBack();
			//abort(404);	// Прекратить выполнение
			abort(500);	// В работе сервисов лучше выдавать ошибку 500, говорящую что это нарушение на стороне сервера, во время работы. А ошибка 404 - это Страница не найдена
		}
	}

	public function store1($data) {
		try {
			Db::beginTransaction();
			if (isset($data['tag_ids'])) {
				$tagIds = $data['tag_ids'];
				unset($data['tag_ids']);
			} else $tagIds = [];
			$data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
			$data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);
			$post = Post::firstOrCreate($data);
			if (!empty($tagIds))	//if (isset($data['tag_ids']))
				$post->tags()->attach($tagIds);
			Db::commit();
		} catch (\Exception $exception) {
			Db::rollBack();
			abort(500);	// В работе сервисов лучше выдавать ошибку 500, говорящую что это нарушение на стороне сервера, во время работы. А ошибка 404 - это Страница не найдена
		}
	}

	public function update($data, $post) {
		try {
			Db::beginTransaction();
			// Если я не выбирал картинку для изменения, вылетала ошибка. Потому что не приходили параметры $data['main_image', 'preview_image']. Сам поставил такие проверки:
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
			Db::commit();
		} catch (Exception $exception) {
			Db::rollBack();
			abort(500);	// В работе сервисов лучше выдавать ошибку 500, говорящую что это нарушение на стороне сервера, во время работы. А ошибка 404 - это Страница не найдена
		}
		return $post;
	}

	public function update1($data, $post) {
		try {
			Db::beginTransaction();
			if (isset($data['tag_ids'])) {
				$tagIds = $data['tag_ids'];
				unset($data['tag_ids']);
			} else $tagIds = [];

			// Если я не выбирал картинку для изменения, у меня вылетала ошибка. Потому что не приходили параметры $data['main_image', 'preview_image']. Сам поставил такие проверки:
			if (isset($data['main_image']))
				$data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);
			if (isset($data['preview_image']))
				$data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
			// Данные после обработки, снова помещаются в массив $data, чтобы проще это добавлять в базу, одним обращением update($data)

			$post->update($data);

			//if (isset($tagIds) && !empty($tagIds)) {	//if (isset($data['tag_ids']))
			// Здесь, вместо "attach()" используем метод "sync()", который удаляет абсолютно все привязки у поста с тегами, и добавляет только те, которые мы указали в $tagIds
			$post->tags()->sync($tagIds);
			Db::commit();
		} catch (\Exception $exception) {
			Db::rollBack();
			abort(500);	// Прекратить выполнение
		}
		return $post;
	}

}