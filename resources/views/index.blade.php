@extends('layouts.mainlayout')

@section('content')
    @if($properties->count() == 3)
        <!--/ Carousel Start /-->
        <div class="intro intro-carousel">
            <div id="carousel" class="owl-carousel owl-theme">
                @foreach($properties as $p)
                    <div class="carousel-item-a intro-item bg-image" style="background-image: url({{asset($p->image_path)}})">
                        <div class="overlay overlay-a"></div>
                        <div class="intro-content display-table">
                            <div class="table-cell">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="intro-body">
                                                <p class="intro-title-top">{{$p->pais}}
                                                    <br> {{$p->provincia}} <br> {{$p->localidad}}</p>
                                                <h1 class="intro-title mb-4">
                                                    <span class="color-b">{{$p->numero}} </span> {{$p->calle}}</h1>
                                                <p class="intro-subtitle intro-price">
                                                    <a href="{{ url('property?id=').$p->id }}"><span class="price-a">Ver más</span></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!--/ Carousel end /-->
    @endif

    <!--/ Property grid Start /-->
    <section class="section-property section-t8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap d-flex justify-content-between">
                        <div class="title-box">
                            <h2 class="title-a wow fadeInUp">Últimas propiedades agregadas</h2>
                        </div>
                        <div class="title-link wow fadeInLeft" data-wow-delay="1.5s" data-wow-duration="2s">
                            <a href={{ url('properties') }}>Ver todas
                                <span class="ion-ios-arrow-forward"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @if(!$properties->isEmpty())
                <div id="property-carousel" class="owl-carousel owl-theme">
                    @foreach($properties as $p)
                        <div class="carousel-item-b wow fadeInUp" data-wow-duration="2s">
                            <div class="card-box-a border-property card-shadow">
                                @include('partials/propertyItem', ['weeks' => $weeks[$loop->index]])
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h5 class="text-muted">Actualmente no tenemos propiedades</h5>
            @endif
        </div>
    </section>
    <!--/ Property grid End /-->

    <!--/ Pricing Start /-->
    <section class="pricing py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap d-flex justify-content-between">
                        <div class="title-box">
                            <h2 class="title-a color-w wow fadeInUp shadowed">Nuestros precios</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <!-- Basic Tier -->
                <div class="col-sm-8 col-lg-4">
                    <div class="card mb-5 mb-lg-0 shadowed wow slideInUp" data-wow-delay="0.5s" data-wow-duration="1.5s">
                        <div class="card-body">
                            <h5 class="card-title text-muted text-uppercase text-center">Subscripción Normal</h5>
                            <h6 class="card-price text-center">${{$normalUserSubscriptionPrice}}<br><span class="period">/mes</span></h6>
                            <hr>
                            <ul class="fa-ul">
                                <li><span class="fa-li"><i class="fas fa-check"></i></span>Subastas</li>
                                <li><span class="fa-li"><i class="fas fa-check"></i></span>HotSales</li>
                                <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Reserva Premium</li>
                            </ul>
                            @guest
                                <a href="{{(url('register'))}}" class="btn btn-block btn-primary text-uppercase">Registrate</a>
                            @endguest
                            @auth
                                <a href="#" class="btn btn-block btn-primary text-uppercase" disabled>Ya eres Usuario</a>
                            @endauth
                        </div>
                    </div>
                </div>
                <!-- Premium Tier -->
                <div class="col-sm-8 col-lg-4">
                    <div class="card mb-5 mb-lg-0 shadowed wow slideInUp" data-wow-delay="0.7s" data-wow-duration="1.5s">
                        <div class="card-body">
                            <h5 class="card-title text-muted text-uppercase text-center">Plus Premium</h5>
                            <h6 class="card-price text-center">${{($premiumPlusPrice)}}<br><span class="period">adicionales /mes</span></h6>
                            <hr>
                            <ul class="fa-ul">
                                <li><span class="fa-li"><i class="fas fa-check"></i></span>Subastas</li>
                                <li><span class="fa-li"><i class="fas fa-check"></i></span>HotSales</li>
                                <li><span class="fa-li"><i class="fas fa-check"></i></span>Reserva Premium</li>
                            </ul>
                            @if(Auth::user() && !Auth::user()->premium)
                                <a href="{{(url('profile'))}}" class="btn btn-block btn-primary text-uppercase">Solicitar</a>
                            @elseif(Auth::user())
                                <a href="#" class="btn btn-block btn-primary text-uppercase" disabled>Ya eres Premium</a>
                            @else
                                <a href="{{(url('register'))}}" class="btn btn-block btn-primary text-uppercase">Registrate</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Pricing End /-->

    <!--/ Services Start /-->
    <section class="section-services section-t8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap d-flex justify-content-between">
                        <div class="title-box">
                            <h2 class="title-a wow fadeInUp">Nuestros servicios</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card-box-c foo">
                        <div class="card-header-c d-flex wow slideInDown">
                            <div class="card-box-ico">
                                <span class="fas fa-gavel"></span>
                            </div>
                            <div class="card-title-c align-self-center">
                                <h2 class="title-c">SUBASTA</h2>
                            </div>
                        </div>
                        <div class="card-body-c">
                            <p class="content-c">
                                Podrás obtener reservas
                                <br>
                                de una semana entera
                                <br>
                                para una propiedad
                                <br>
                                al participar en subastas
                            </p>
                        </div>
                        <div class="card-footer-c">
                            <a href="{{ url('faq') }}" class="link-c link-icon wow fadeInLeft" data-wow-duration="2s">Ver más
                                <span class="ion-ios-arrow-forward"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-box-c foo">
                        <div class="card-header-c d-flex wow slideInUp">
                            <div class="card-box-ico">
                                <span class="fas fa-fire"></span>
                            </div>
                            <div class="card-title-c align-self-center">
                                <h2 class="title-c">HOTSALE</h2>
                            </div>
                        </div>
                        <div class="card-body-c">
                            <p class="content-c">
                                Tenemos promociones eventuales
                                <br>
                                Para que consigas una reserva
                                <br>
                                Pagando
                                <br>
                                El precio mínimo
                            </p>
                        </div>
                        <div class="card-footer-c">
                            <a href="{{ url('faq') }}" class="link-c link-icon wow fadeInLeft" data-wow-duration="2s">Ver más
                                <span class="ion-ios-arrow-forward"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-box-c foo wow">
                        <div class="card-header-c d-flex wow slideInDown">
                            <div class="card-box-ico">
                                <span class="fas fa-ticket-alt"></span>
                            </div>
                            <div class="card-title-c align-self-center">
                                <h2 class="title-c">PREMIUM</h2>
                            </div>
                        </div>
                        <div class="card-body-c">
                            <p class="content-c">
                                Pagando un plus
                                <br>
                                a tu suscripción mensual
                                <br>
                                podrás adjudicarte
                                <br>
                                una semana sin pujar
                            </p>
                        </div>
                        <div class="card-footer-c">
                            <a href="{{ url('faq') }}" class="link-c link-icon wow fadeInLeft" data-wow-duration="2s">Ver más
                                <span class="ion-ios-arrow-forward"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Services End /-->

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
@endsection