<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class DeleteController extends BaseController
{
	public function __invoke(Post $post) {
		if (!empty($post->preview_image))
			Storage::disk('public')->delete($post->preview_image);
		if (!empty($post->main_image))
			Storage::disk('public')->delete($post->main_image);
		$post->tags()->detach();	// Удалит связанные записи о Тегах прикреплённых к этому Сообщению, из таблицы "post_tags"
		$post->delete();
		return redirect()->route('admin.post.index');
	}
}
