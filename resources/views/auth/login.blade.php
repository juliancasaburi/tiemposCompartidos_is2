@extends('layouts.login')

@section('title', '- Iniciar Sesión')

@section('content')
    <section class="login">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-3 font-weight-normal">Iniciar Sesión</h1>
                        <p>No tienes una cuenta?<p>
                            <a href={{ url('register') }}>Registrate!</a>
                    </div>
                    <form class="form-signin" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-label-group">
                            <input type="email" name="email" id="inputEmail" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required="true" autofocus="">
                            <label for="email">Email</label>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                            @enderror
                        </div>

                        <div class="form-label-group">
                            <input type="password" name="password" id="inputPassword" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" required="true">
                            <label for="inputPassword">Contraseña</label>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>

                        <div class="form-label-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="form-label-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>
                        <div class="form-label-group">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Olvidaste tu contraseña?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                @if(isset($p))
                    <div class="col-md-4">
                        <h1 class="h3 mb-3 font-weight-normal">Propiedad aleatoria</h1>
                        <div class="card-box-a card-shadow mt-5 mb-5">
                            @include('partials/propertyItem', ['weeks' => $weeks])
                        </div>
                    </div>
                @endif
                @if(isset($w))
                    <div class="col-md-4">
                        <h1 class="h3 mb-3 font-weight-normal">Subasta aleatoria</h1>
                        <div class="card-box-a card-shadow mt-5 mb-5">
                            @include('partials/weekItem')
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
