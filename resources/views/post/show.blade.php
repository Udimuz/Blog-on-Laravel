@extends('layouts.main')

@section('content')
    <main class="blog-post">
        <div class="container">
            <h1 class="edica-page-title">{{ $post->title }}</h1>
            <p class="edica-blog-post-meta">• {{ $date->translatedFormat('F')." ".$date->day.", ".$date->year." • ".$date->format('H:i')." • Комментариев: ".$post->comments->count() }}</p>
            <section class="blog-post-featured-img">
                <img src="{{ asset('storage/'.$post->main_image) }}" alt="featured image" class="w-100">
            </section>
            <section class="post-content">
                <div class="row">
                    <div class="col-lg-9 mx-auto">
                        {!! $post->content !!}
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="col-lg-9 mx-auto">
                    <section class="py-3">
                        @auth()
                            <form action="{{ route('post.like.store', $post->id) }}" method="post">
                                @csrf
                                <span>{{ $post->liked_users_count }}</span>
                                <button type="submit" class="border-0 bg-transparent"><i class="fa{{ auth()->user()->likedPosts->contains($post->id) ? 's' : 'r' }} fa-heart"></i></button>
                            </form>
                        @else
                            <div><span>{{ $post->liked_users_count }}</span> <i class="far fa-heart"></i></div>
                        @endauth
                    </section>
                    @if($relatedPosts->count() > 0)
                    <section class="related-posts">
                        <h2 class="section-title mb-4">Схожие сообщения (related posts)</h2>
                        <div class="row">
                            @foreach($relatedPosts as $inpost)
                            <div class="col-md-4">
                                <img src="{{ asset('storage/'.$inpost->main_image) }}" alt="related post" class="post-thumbnail">
                                <p class="post-category">{{ $inpost->category->title }}</p>
                                <a href="{{ route('post.show', $inpost->id) }}"><h5 class="post-title">{{ $inpost->title }}</h5></a>
                            </div>
                            @endforeach
                        </div>
                    </section>
                    @endif
                    <section class="mb-5">
                        <h2 class="section-title mb-4">Комментарии ({{ $post->comments->count() }})</h2>
                        @foreach($post->comments as $comment)
                        <div class="comment-text mb-3">
                            <span class="username">
                                <div><b>{{ $comment->user->name }}:</b></div>
                                <span class="text-muted float-right">{{ $comment->DateAsCarbon->diffForHumans() }}</span>
                            </span>
                            {{ $comment->message }}
                        </div>
                        @endforeach
                    </section>
                    @auth()
                    <section class="comment-section">
                        <h2 class="section-title mb-5">Оставить комментарий</h2>
                        <form action="{{ route('post.comment.store', $post->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="comment" class="sr-only">Комментарий</label>
                                    <textarea name="message" id="comment" class="form-control" placeholder="Напишите комментарий" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <input type="submit" value="Добавить" class="btn btn-warning">
                                </div>
                            </div>
                        </form>
                    </section>
                    @endauth
                </div>
            </div>
        </div>
    </main>
@endsection