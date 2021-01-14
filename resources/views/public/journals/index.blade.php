@extends('welcome')

@section('content')
    <section class="public">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <h2 class="public__title">Журналы</h2>
                </div>
                <div class="col-md-8 text-right align-self-center">
                    @if($errors->message)
                        <p style="color: limegreen">{{$errors->message->first()}}</p>
                    @elseif($errors->error)
                        <p style="color: #e4606d">{{$errors->error->first()}}</p>
                    @endif
                </div>
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Панель</a></li>
                            <li class="breadcrumb-item active">Журналы</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-md-12 mb-2">
                    <a href="/journals/create" class="btn btn-success">Добавить</a>
                </div>

                @if($journals->count())
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Заголовок</th>
                            <th>Дата</th>
                            <th>Авторы</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($journals as $journal)
                            <tr>
                                <td>{{$journal->title}}</td>
                                <td>{{$journal->relise_date}}</td>
                                <td>
                                    @php
                                        $names = '';
                                        $authorsSelectedId = explode(',',$journal->authors);
                                        $authorsSelected = App\Author::find($authorsSelectedId);
                                        foreach ($authors as $author) {
                                            foreach ($authorsSelected as $k => $authorSelected) {
                                                if($authorSelected->id == $author->id) {
                                                    $names .= $author->full_name.', ';
                                                }
                                            }
                                        }
                                        $names = substr($names, 0 ,-2);
                                    @endphp
                                    {{$names}}
                                </td>
                                <td style="height: 2rem; width: 4rem; max-width: 4rem;">
                                    <div style="height: 100%; display: flex; align-items: center;">
                                        <a href="/journals/{{$journal->id}}/edit" title="Редактировать">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                                <td style="height: 2rem; width: 4rem; max-width: 4rem;">
                                    <div style="height: 100%; display: flex; align-items: center;">
                                        <a href="/journals/{{$journal->id}}" title="Просмотр Журнала">
                                            <i class="fa fa-camera-retro"></i>
                                        </a>
                                    </div>
                                </td>
                                <td style="height: 2rem; width: 4rem; max-width: 4rem;">
                                    <div style="height: 100%; display: flex; align-items: center;">
                                        <form action="/journals/{{$journal->id}}" id="formDelete{{$journal->id}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="#" onclick="let e = confirm('Удалить журнал?')
                                                if(e)document.getElementById('formDelete{{$journal->id}}').submit()"
                                            title="Удалить">
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
                @else 
                    <div class="col-md-12">
                        Нет журналов
                    </div>
                @endif
            </div>
            {{ $journals->links() }}
        </div>
    </section>
@endsection
