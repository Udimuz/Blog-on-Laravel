@extends('personal.layouts.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Профиль пользователя: <b>{{ $user->name }}</b></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('personal.main.index') }}">Главная</a></li>
                            <li class="breadcrumb-item active">Профиль</li>
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
                        <form action="{{ route('personal.profile.update') }}" method="POST" class="w-25">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <input name="name" type="text" class="form-control" aria-label="name" placeholder="Имя пользователя"
                                       value="{{ old('name', $user->name ?? null) }}">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input name="email" type="text" class="form-control" aria-label="email" placeholder="Email"
                                       value="{{ old('email', $user->email ?? null) }}">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input name="password" type="text" class="form-control" aria-label="password" placeholder="Пароль">
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="submit" class="btn btn-primary" value="Сохранить">
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </section>
        <!-- /.content -->

    </div>
@endsection