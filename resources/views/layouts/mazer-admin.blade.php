<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>

    <link rel="stylesheet" href="{{ asset('mazer2.0/assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer2.0/assets/css/main/app-dark.css') }}">
    <link rel="shortcut icon" href="{{ asset('mazer2.0/assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('mazer2.0/assets/images/logo/favicon.png') }}" type="image/png">

    <link rel="stylesheet" href="{{ asset('mazer2.0/assets/css/shared/iconly.css') }}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css"
        integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
</head>

<body>    
    <div id="app">
        <div id="sidebar" class="active">
            @include('layouts.mazer-admin.sidebar')
        </div>
        <div id="main">
            <!-- Ícono de carga global -->
            @include('components.loading')

            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>@yield('heading')</h3>
            </div>

            <div class="page-content">
                @yield('content')
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">                    
                    <div class="float-end">
                        <p>Desarrollado con <span class="text-danger"><i class="bi bi-heart"></i></span> por la <a
                                href="#">Municipalidad de San Miguel</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>        
        //if (typeof window.monthlyData !== 'undefined' && Array.isArray(window.monthlyData)) {
            window.monthlyData = @json($monthlyData);
        //} 
    </script>
    <script src="{{ asset('mazer2.0/assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('mazer2.0/assets/js/app.js') }}"></script>

    <!-- Need: Apexcharts -->
    <script src="{{ asset('mazer2.0/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('mazer2.0/assets/js/pages/dashboard.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let loading = document.getElementById('loading');

            // Mostrar el ícono de carga cuando se empieza a cargar data asíncrona
            loading.style.display = 'flex';

            // Suponiendo que estás usando fetch:
            Promise.all([
                //fetch('/api/data1').then(response => response.json()),
                //fetch('/api/data2').then(response => response.json())
            ]).then(results => {
                // Procesar los datos aquí...

                // Una vez que los datos se hayan cargado completamente:
                loading.style.display = 'none';
            }).catch(error => {
                console.error('Error al cargar los datos:', error);
                // Manejar errores si es necesario...
                loading.style.display = 'none';
            });
        });

    </script>

</body>

</html>
