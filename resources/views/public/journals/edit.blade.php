@extends('welcome')

@section('content')
    <section class="public">
        <div class="container">
            <div class="public__row">
                @if($journal)
                    <h2 class="public__title">Редактирование журнала</h2>
                @else
                    <h2 class="public__title">Добавление журнала</h2>
                @endif
                    @if($errors->any())
                        <h4>{{$errors->first()}}</h4>
                    @endif
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Панель</a></li>
                        <li class="breadcrumb-item"><a href="/journals">Журналы</a></li>
                        @if($journal)
                            <li class="breadcrumb-item active">Редактирование</li>
                        @else
                            <li class="breadcrumb-item active">Добавление</li>
                        @endif
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-12">

                @if($journal)
                    <form action="/journals/{{$journal->id}}" method="post" enctype="multipart/form-data">
                        @method('put')
                @else
                    <form action="/journals" method="post" enctype="multipart/form-data">
                @endif
                    @csrf
                            <div class="form-group">
                                <label for="nameChange">Заголовок</label>
                                <input type="text" class="form-control" id="nameChange" name="title"
                                    value="@if($journal){{$journal->title}}@endif" required>
                            </div>

                            <div class="form-group">
                                <label for="content">Короткое описание</label>
                                <textarea class="form-control" id="describe" name="describe"
                                            rows="8" required>@if($journal){{$journal->describe}}@endif</textarea>
                            </div>

                            <div class="form-group">
                                <label for="relise_date">Дата выпуска журнала</label>
                                <input type='date' class="form-control" id="relise_date" name="relise_date" value="@if($journal){{$journal->relise_date}}@endif" required>
                            </div>

                            <div class="form-group">
                                <label for="type">Авторы</label>
                                <div id="type">
                                    @foreach($authors as $key => $author)
                                        @if($author)
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="{{$key}}" value="{{$author['id']}}" name="authors[]" @if ($author['ind']) checked @endif>
                                                <label class="custom-control-label" for="{{$key}}">{{$author['name']}}</label>
                                            </div>
                                        @else
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="{{$key}}" value="{{$author['id']}}" name="authors[]">
                                                <label class="custom-control-label" for="{{$key}}">{{$author['name']}}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <span>Изображение</span>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Выберите файл...</label>
                            </div>
                            
                            <div class="col-md-8 pl-0" style="margin-top: 1rem">
                                @if($journal)
                                    <img width="500px" src="{{ asset('storage'.$journal->image) }}" alt="">
                                @endif
                            </div>

                        <button type="submit" class="btn btn-primary mb-3" style="margin-top: 1rem">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
