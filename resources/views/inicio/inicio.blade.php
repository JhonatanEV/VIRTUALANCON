<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="{{ config('app.SISTEMA') }} - {{ config('app.MUNICIPALIDAD') }}">
        <meta name="author" content="{{ config('app.AUTOR') }}">
        <link rel="shortcut icon" href="{{ asset('assets/images/logo-64x64.ico') }}">
        <title>{{ config('app.SISTEMA') }} - {{ config('app.MUNICIPALIDAD') }}</title>
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style-inicio.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <style>
            
        </style>
    </head>
    <body>
        
         <nav class="navbar navbar-expand-lg navbar-dark  shadow-sm bg-blue">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="{{asset('assets/images/logo-dark.png')}}" alt="logo-small" height="40" class="d-inline-block">                     
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarsExample07">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item align-self-center">
                            <a class="nav-link" href="./crear-cuenta">Crear cuenta</a>
                        </li>                                              
                        <li class="nav-item align-self-center">
                        <a class=" btn btn-sm btn-secondary" href="./login" role="button"><i class="fas fa-sign-in-alt me-2"></i>Iniciar sesión</a>
                        </li>
                    </ul>                
                </div>
            </div>
        </nav>
        <section class="section bg-home pb-0"> 
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 mx-auto align-self-center">
                        <div class="home-text">
                            <h5 class="text-white bg-blue font-weight-bold">Municipalidad en Línea</h5>
                            <h1 class="">Plataforma Virtual de Servicios - Municipalidad Distrital de Ancón</h1>
                            <p>
                                Bienvenido a la Plataforma Virtual de Servicios de la Municipalidad Distrital de Ancón.
                                Mediante la Plataforma Virtual, la Municipalidad Distrital de Ancón pone a disposición de los ciudadanos y vecinos, servicios en línea para una atención personalizada, como el Pago de Tributos en Línea, Mesa de Partes en línea, donde pueden ingresar a realizar la gestión las 24 horas del día y los 7 días de la semana.<br>
                                Estamos trabajando para aperturar más servicios en línea en beneficio de todos los vecinos
                                <br><br>
                            </p>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="fw-bold mb-1 text-primary">MUY IMPORTANTE:</p>
                                    <p>Para acceder a los servicios en línea es necesario que se registre, creando su cuenta de usuario, para lo cual debe ingresar a <a href="./crear-cuenta" class="fw-bold">CREAR CUENTA</a> y proceder con el registro respectivo.
                                    </p>
                                    <div>
                                        <a href="./login"  class="btn btn-blue"><i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión</a>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-lg-4 mx-auto">

                        <a href="https://eco.muniancon.gob.pe/inicio" target="_blank">
                            <div class="card mb-3 app">
                                <div class="row g-0">
                                    <div class="col-md-3 bg-light-alt align-self-center text-center">
                                        <img src="{{ asset('assets/images/apps/pagar.png') }}" alt="..." class="bg-light-alt" height="60">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h4 class="card-title fw-bold mb-0">Pagos Online de Tributos</h4>
                                            <p class="card-text mb-0 text-danger">Próximamente</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="./tramites/mis-tramites">
                            <div class="card mb-3 app">
                                <div class="row g-0">
                                    <div class="col-md-3 bg-light-alt align-self-center text-center">
                                        <img src="{{ asset('assets/images/apps/cuponera.png') }}" alt="..." class="bg-light-alt" height="60">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h4 class="card-title fw-bold mb-0">Cuponera Virtual 2025</h4>
                                            <p class="card-text mb-0 text-muted">Ver mi cuponera</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="./buzon/sugerencia">
                            <div class="card mb-3 app">
                                <div class="row g-0">
                                    <div class="col-md-3 bg-light-alt align-self-center text-center">
                                        <img src="{{ asset('assets/images/apps/actualizardatos.png') }}" alt="..." class="bg-light-alt" height="60">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h4 class="card-title fw-bold mb-0">Actualización de datos</h4>
                                            <p class="card-text mb-0 text-muted">Ir a actualizar</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>                
            </div>
        </section>
            
        <section class="py-3 bg-light">
            <div class="container">                
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <p class="copyright text-dark mb-0">Desarrollado por OGGED © <script>
                            document.write(new Date().getFullYear())
                        </script> {{ config('app.MUNICIPALIDAD') }}.</p>
                    </div>
                </div>
            </div>
        </section>


        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
       

    </body>
</html>