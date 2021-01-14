@extends('welcome')

@section('content')
<section class="public">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="public__title">Авторы</h2>
            </div>
            <div class="col-md-8 text-right align-self-center">
                @if($errors->message)
                    <h4 style="color: limegreen">{{$errors->message->first()}}</h4>
                @elseif($errors->error)
                    <h4 style="color: #e4606d">{{$errors->error->first()}}</h4>
                @endif
            </div>
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Панель</a></li>
                        <li class="breadcrumb-item active">Авторы</li>
                    </ol>
                </nav>
            </div>

            <div class="col-md-12 mb-2">
                <a href="/authors/create" class="btn btn-success">Добавить</a>
            </div>

            @if($authors->count())
            <div class="col-md-12">
                <table id="myTable" class="table table-striped tablesorter-bootstrap">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Отчество</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach ($authors as $author)
                            <tr>
                                <td>{{$author->first_name}}</td>
                                <td>{{$author->last_name}}</td>
                                <td>{{$author->middle_name}}</td>
                                <td style="height: 2rem; width: 4rem; max-width: 4rem;">
                                    <div style="height: 100%; display: flex; align-items: center;">
                                        <a href="/authors/{{$author->id}}/edit" title="Редактировать">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                                <td style="height: 2rem; width: 4rem; max-width: 4rem;">
                                    <div style="height: 100%; display: flex; align-items: center;">
                                        <a href="/authors/{{$author->id}}" title="Журналы Автора">
                                            <i class="fa fa-quora"></i>
                                        </a>
                                    </div>
                                </td>
                                <td style="height: 2rem; width: 4rem; max-width: 4rem;">
                                    <div style="height: 100%; display: flex; align-items: center;">
                                        <form action="/authors/{{$author->id}}" id="formDelete{{$author->id}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="#" onclick="let e = confirm('Удалить автора?')
                                                if(e)document.getElementById('formDelete{{$author->id}}').submit()" title="Удалить">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 d-flex justify-content-center" style="margin: 1rem 0rem 1rem 0rem">
                {{$authors->links()}}
            </div>
            @else
                <div class="col-md-12">
                    Нет авторов
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
