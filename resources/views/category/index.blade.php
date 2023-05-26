@extends('layouts.main')

@section('content')
<main class="blog">
    <div class="container">
        <h1 class="edica-page-title">Категории</h1>
        <ul>
        @foreach($categories as $category)
            <li><a href="{{ route('category.post.index', $category->id) }}">{{ $category->title. ($category->posts_count>0 ? " (".$category->posts_count.")" : "") }}</a></li>
        @endforeach
        </ul>
    </div>
</main>
@endsection