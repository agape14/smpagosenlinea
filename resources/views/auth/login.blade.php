@extends('layouts.mazer-blank')

@section('content')
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ route('welcome') }}"><img src="{{ asset('logo.png') }} " style="width: 220px; height: 100px;" alt="Logo"></a>
                    </div>
                    
                    <h1 class="auth-title">Pagos en Línea</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="alert alert-light">
                        <p>
                            Estimado contribuyente:
                            Para acceder a nuestra platafotma de pagos debe identificarse con su código de contribuyente y clave de acceso, los cuales se encuentran impresos en la Hoja de Liquidación Predial (HLP) de su cuponera.
                        </p>
                        <p>
                            Consultas al 263-6098 / 263-3254 / 208-5830 anexos: 3330, 3331, 3350 O al correo: sgrecaudacion@munisanmiguel.gob.pe
                        </p>
                    </div>
                  

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input name="codigo" type="text" class="form-control form-control-xl"
                                placeholder="Código de contribuyente">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('codigo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input name="clave" type="password" class="form-control form-control-xl"
                                placeholder="Contraseña">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('clave')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">INICIAR SESIÓN</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"
                    style="background: url('{{ asset('login.jpg') }}') no-repeat; background-size: cover;">                    
                </div>
            </div>
        </div>
    </div>

    <style type="text/css">
        

        .mb-5 {
            margin-bottom:1rem!important;
        }

        #auth #auth-left .auth-title {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }
    </style>
@endsection