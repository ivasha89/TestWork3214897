@extends('welcome')

@section('content')
<section class="public">
    <div class="container">
        <div class="public__row">
            @if($author)
                <h2 class="public__title">Редактирование Автора</h2>
            @else
                <h2 class="public__title">Добавление Автора</h2>
            @endif
            @if($errors->any())
                <h4>{{$errors->first()}}</h4>
            @endif
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Панель</a></li>
                    <li class="breadcrumb-item"><a href="/authors">Авторы</a></li>
                    @if($author)
                        <li class="breadcrumb-item active">Редактирование</li>
                    @else
                        <li class="breadcrumb-item active">Добавление</li>
                    @endif
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">

                @if($author)
                    <form action="/authors/{{$author->id}}" method="post" enctype="multipart/form-data">
                        @method('put')
                @else
                    <form action="/authors" method="post" enctype="multipart/form-data">
                @endif
                        @csrf
                        <div class="form-group">
                            <label for="first_name">Имя</label>
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                value="@if($author){{$author->first_name}}@endif" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Фамилия</label>
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="@if($author){{$author->last_name}}@endif" required>
                        </div>

                        <div class="form-group">
                            <label for="middle_name">Отчество</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name"
                                    value="@if($author){{$author->middle_name}}@endif" required>
                        </div>

                        <button type="submit" class="btn btn-primary mb-3" style="margin-top: 1rem">Сохранить</button>
                    </form>
            </div>
        </div>
    </div>
</section>
@endsection
