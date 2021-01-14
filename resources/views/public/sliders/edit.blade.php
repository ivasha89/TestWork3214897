@extends('layouts/publicAdmin')

@section('content')
<section class="publicMain">
    <div class="container">
        <div class="publicMain__row">
            @if($slider)
                <h2 class="publicMain__title">Редактирование Слайдера</h2>
            @else
                <h2 class="publicMain__title">Добавление Слайдера</h2>
            @endif
                @if($errors->any())
                    <h4>{{$errors->first()}}</h4>
                @endif
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/editor">Админка</a></li>
                    <li class="breadcrumb-item"><a href="/editor/sliders">Слайдеры</a></li>
                    @if($slider)
                        <li class="breadcrumb-item active">Редактирование</li>
                    @else
                        <li class="breadcrumb-item active">Добавление</li>
                    @endif
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">

                @if($slider)
                    <form action="/editor/sliders/{{$slider->id}}" method="post" enctype="multipart/form-data">
                        @method('put')
                @else
                    <form action="/editor/sliders" method="post" enctype="multipart/form-data">
                @endif
                        @csrf
                        <div class="form-group">
                            <label for="nameChange">Заголовок</label>
                            <textarea class="form-control" id="CKEditorText0" name="title" required>
                                @if($slider){{$slider->title}}@endif
                            </textarea>
                        </div>

                        <div class="publicMain__wrapper">
                            <div class="publicMain__col">
                                <div class="form-group">
                                    <label for="button_name">Название кнопки</label>
                                    <input type="text" class="form-control" id="button_name" name="button_name"
                                            value="@if($slider){{$slider->button_name}}@endif" required>
                                </div>
                            </div>
                            <div class="publicMain__col">
                                <div class="form-group">
                                    <label for="link">Ссылка</label>
                                    <input type="text" class="form-control" id="link" name="link"
                                            value="@if($slider){{$slider->link}}@endif" required>
                                </div>
                            </div>
                        </div>

                        <span>Баннер</span>
                        <div class="custom-file">
                                <input type="file" class="custom-file-input" id="banner" name="banner">
                                <label class="custom-file-label" for="banner">Выберите файл...</label>
                        </div>
                            @if($slider)
                                <img src="{{ asset('storage'.$slider->banner) }}" alt="">
                            @endif
                        <button type="submit" class="btn btn-primary mb-3" style="margin-top: 1rem">Сохранить</button>
                    </form>
            </div>
        </div>
    </div>
</section>
@endsection
