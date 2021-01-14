@extends('welcome')

@section('content')
    <section class="public">
        <div class="container">
            <h2 class="public__title">Материалы</h2>
            <ul class="panel public__list">
                <li class="public__item">
                    <a href="/journals"><div class="icon"><i class="fa fa-newspaper-o"></i></div> Журналы</a>
                </li>
                <li class="public__item">
                    <a href="/authors"><div class="icon"><i class="fa fa-credit-card"></i></div> Авторы</a>
                </li>
            </ul>
        </div>
    </section>
@endsection
