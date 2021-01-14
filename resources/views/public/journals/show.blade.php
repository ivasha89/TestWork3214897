@extends('welcome')

@section('content')
    <section class="public">
        @if(isset($journal['error']))
            <div class="container">
                <div class="public__row">
                    <h2 class="public__title">{{ $journal['error'] }}</h2>
                </div>
            </div>
        @else
            <div class="container">
                <div class="public__row">
                    <h2 class="public__title">Просмотр журнала</h2>
                    @if($errors->any())
                        <h4>{{$errors->first()}}</h4>
                    @endif
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Панель</a></li>
                            <li class="breadcrumb-item"><a href="/journals">Журналы</a></li>
                            <li class="breadcrumb-item active">Просмотр</li>
                        </ol>
                    </nav>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <img src="{{asset('storage'.$journal->image)}}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $journal->title }}</h5>
                                <p class="card-text">{{ $journal->describe }}</p>
                                <p class="card-text">
                                    <small class="text-muted float-left">Опубликован {{ $journal->relise_date }}</small>
                                    <small class="text-muted float-right">Авторы {{ $authors }}</small>
                                </p>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        @endif
    </section>
@endsection
