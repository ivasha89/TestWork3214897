@extends('layouts/publicAdmin')

@section('content')
<section class="publicMain">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-2">
                <h2 class="publicMain__title">Слайдеры</h2>
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
                        <li class="breadcrumb-item"><a href="/editor">Админка</a></li>
                        <li class="breadcrumb-item active">Слайдеры</li>
                    </ol>
                </nav>
            </div>

            <div class="col-md-12 mb-2">
                <a href="/editor/sliders/create" class="btn btn-success">Добавить</a>
                <div class="float-right">
                    <span class="badge badge-danger">{{$unpublished}}</span>
                    Опубликовано
                    <span class="badge badge-success">{{$published}}</span>
                </div>
            </div>
            @foreach($sliders as $slider)
            <div class="col-xl-5">
                    
                        <div class="card">
                            <div class="slider-image">
                                <img src="{{ asset('storage'.$slider->banner) }}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <div class="card-title d-flex flex-row">
                                    <div class="mr-auto">
                                        <h5 class="text-left">{!!$slider->title!!}</h5>
                                    </div>
                                    <div class="float-right">
                                        <form action="/editor/sliders/publish/{{$slider->id}}" id="formPublish{{$slider->id}}" method="post">
                                            @csrf
                                            <div class="custom-control custom-switch ml-4">
                                                <input
                                                    name="published"
                                                    type="checkbox"
                                                    class="custom-control-input"
                                                    id="customSwitch{{$slider->id}}"
                                                    @if($slider->published) {{'checked'}} @endif
                                                    onclick="document.getElementById('formPublish{{$slider->id}}').submit();"
                                                >
                                                <label class="custom-control-label" for="customSwitch{{$slider->id}}"></label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ $slider->link }}" class="btn btn-info">{{ $slider->button_name }}</a>
                                    </div>
                                    <a href="sliders/{{ $slider->id }}/edit" role="button" class="col-md-6">
                                        <i class="fa fa-pencil float-right"></i>
                                    </a>
                                </div>
                                <div class="row">
                                    <p class="col-md-6 card-text"><small class="text-muted">{{ $slider->created_at }}</small></p>
                                    <form class="col-md-6" action="/editor/sliders/{{$slider->id}}" id="formDelete{{$slider->id}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <a type="submit" onclick="document.getElementById('formDelete{{$slider->id}}').submit()">
                                            <i class="fa fa-trash float-right"></i>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    
            </div>
            @endforeach
            <div class="col-md-12 d-flex justify-content-center" style="margin: 1rem 0rem 1rem 0rem">
                {{$sliders->links()}}
            </div>
        </div>
    </div>
</section>
@endsection
