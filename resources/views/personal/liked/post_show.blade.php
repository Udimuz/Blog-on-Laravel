@extends('personal.layouts.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex align-items-center">
                        <h1 class="m-0 mr-3">Сообщения: <b>{{ $post->title }}</b></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('personal.main.index') }}">Главная</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('personal.liked.index') }}">Понравившиеся посты</a></li>
                            <li class="breadcrumb-item active">{{ $post->title }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Stat box -->
                <div class="card-body table-responsive p-0 w-50">
                    <table class="table table-hover text-nowrap">
                        <tbody>
                            <tr>
                                <td>ID:</td>
                                <td>{{ $post->id }}</td>
                            </tr>
                            <tr>
                                <td>Название:</td>
                                <td>{{ $post->title }}</td>
                            </tr>
                            <tr>
                                <td>Категория:</td>
                                <td>{{ $post->category->title }}</td>
                            </tr>
                            <tr>
                                <td>Описание:</td>
                                <td>{!! $post->content !!}</td>
                            </tr>
                            <tr>
                                <td>Изображение</td>
                                <td>
                                    @empty($post->main_image)
                                    @else
                                       <img src="{{ url('storage/'.$post->main_image) }}" alt="{{ $post->main_image }}" class="w-100">
                                    @endempty
                                </td>
                            </tr>
                            <tr>
                                <td>Теги:</td>
                                <td>
                                    {{ implode(", ", $post->tags->pluck('title')->toArray()) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- / Stat box -->
            </div>
        </section>
        <!-- /.content -->

    </div>
@endsection