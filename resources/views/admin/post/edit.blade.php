@extends('admin.layouts.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Редактирование сообщения: <b>{{ $post->title }}</b></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.main.index') }}">Главная</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.post.index') }}">Сообщения</a></li>
                            <li class="breadcrumb-item active">Редактирование сообщения</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-12 py-3">
                        <form action="{{ route('admin.post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-group w-25">
                                <input name="title" type="text" class="form-control" aria-label="name" placeholder="Название сообщения"
                                value="{{ old('title', $post->title ?? null) }}">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="summernote">Описание:</label>
                                <textarea id="summernote" name="content">{{ old('content', $post->content ?? null) }}</textarea>
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group w-50">
                                <label for="exampleInputFile">Добавить превью изображения</label>
                                @empty($post->main_image)
                                @else
                                    <div class="mb-2">
                                        <img src="{{ url('storage/'.$post->preview_image) }}" alt="{{ $post->preview_image }}" class="w-25">
                                    </div>
                                @endempty
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="preview_image">
                                        <label class="custom-file-label">Выберите изображение</label>
                                    </div>
                                    <div class="input-group-append"><span class="input-group-text">Загрузка</span></div>
                                </div>
                                @error('preview_image')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group w-50">
                                <label for="exampleInputFile">Добавить главное изображение</label>
                                @empty($post->main_image)
                                @else
                                <div class="mb-2">
                                    <img src="{{ url('storage/'.$post->main_image) }}" alt="{{ $post->main_image }}" class="w-25">
                                </div>
                                @endempty
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="main_image">
                                        <label class="custom-file-label">Выберите изображение</label>
                                    </div>
                                    <div class="input-group-append"><span class="input-group-text">Загрузка</span></div>
                                </div>
                                @error('main_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group w-50">
                                <label for="category_id">Выберите категорию</label>
                                <select name="category_id" class="form-control" id="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                {{ $category->id == old('category_id', $post->category_id ?? null) ? ' selected': '' }}
                                        >{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group w-50">
                                <label for="tag_ids">Теги</label>
                                <select name="tag_ids[]" class="select2 form-control" data-placeholder="Выберите теги" multiple="multiple" id="tag_ids">
                                    @foreach($tags as $tag)
                                        <option {{ is_array(old('tag_ids', $post->tags->pluck('id')->toArray() ?? null))
                                                    && in_array($tag->id, old('tag_ids', $post->tags->pluck('id')->toArray() ?? null)) ? ' selected'
                                                    : '' }} value="{{ $tag->id }}">{{ $tag->title }}</option>
                                    @endforeach
                                </select>
                                @error('tag_ids')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Обновить">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </section>
        <!-- /.content -->

    </div>
@endsection