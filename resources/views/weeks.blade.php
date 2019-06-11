@extends('layouts.mainlayout')

@section('title', '- Semanas')

@section('content')
    <!--/ Intro Single star /-->
    <section class="intro-single">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="title-single-box">
                        <h1 class="title-single">Nuestras semanas</h1>
                        <span class="color-text-a">Ordenalas según tu preferencia</span>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href={{ url('/') }}>Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Semanas
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!--/ Intro Single End /-->

    <!--/ Property Grid Start /-->
    <section class="property-grid grid">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="grid-option">
                        <form>
                            <select class="custom-select">
                                <option selected>Sin Orden</option>
                            </select>
                        </form>
                    </div>
                </div>
                @foreach($weeks as $w)
                    <div class="col-md-4">
                        <div class="card-box-a card-shadow mt-5 mb-5">
                            <div class="img-box-a">
                                @if($w->property->image_path == null)
                                    <img src="{{'https://via.placeholder.com/683x1024?text='.$w->property->nombre}}" alt="" class="img-a img-fluid">
                                @else
                                    <img src="{{asset($w->property->image_path)}}" alt="" class="img-a img-fluid">
                                @endif
                            </div>
                            <div class="card-overlay">
                                <div class="price-box d-flex float-right">
                                    <div class="price-box d-flex float-right">
                                            <h2 class="stars-text">{{ $w->property->estrellas }}<i class="fas fa-star fa-fw star"></i></h2>
                                    </div>
                                </div>
                                <div class="card-overlay-a-content">
                                    <div class="card-header-a">
                                        <h2 class="card-title-a">
                                            <a href="{{ url('property?id=').$w->property->id }}"> {{$w->property->localidad}},
                                                <br /> {{$w->property->provincia}},
                                                <br /> {{$w->property->pais}}</a>
                                        </h2>
                                    </div>
                                    <div class="card-body-a">
                                        <div class="price-box d-flex">
                                            <span class="alert-info">Subasta en inscripción</span>
                                        </div>
                                        <a href={{ url('week?id=').$w->id }} class="link-a"> Ver semana</a>
                                        <span class="ion-ios-arrow-forward"></span>
                                    </div>
                                    <div class="card-footer-a">
                                        <ul class="card-info d-flex justify-content-around">
                                            <li>
                                                <h4 class="card-info-title">Fecha</h4>
                                                <span>{{$w->fecha}}</span>
                                            </li>
                                            <li>
                                                <h4 class="card-info-title">Precio inicial</h4>
                                                <span>${{$w->auction->precio_inicial}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <nav class="pagination-a">
                        {{ $weeks->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!--/ Property Grid Start /-->

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <div id="preloader"></div>
@endsection