<?php

namespace App\Http\Controllers\Post\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;

class StoreController extends Controller
{
    public function __invoke(Post $post, StoreRequest $request) {
		$data = $request->validated();
		// Нужно собрать дополнительные данные, связанные с комментарием:
		$data['user_id'] = auth()->user()->id;	// Кем отправлен
		$data['post_id'] = $post->id;	// К какому посту относится
		// Параметр $data['message'] нужный в таблице получается во входящих данных, обработанных через StoreRequest
		Comment::create($data);
		return redirect()->route('post.show', $post->id);
	}
}
