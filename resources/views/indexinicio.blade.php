<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="{{ config('app.SISTEMA') }} - {{ config('app.MUNICIPALIDAD') }}">
        <meta name="author" content="{{ config('app.AUTOR') }}">
        <link rel="shortcut icon" href="assets/images/logo-64x64.ico">
        <title>{{ config('app.SISTEMA') }} - {{ config('app.MUNICIPALIDAD') }}</title>
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style-inicio.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <style>
            
        </style>
    </head>
    <body>
        
         <nav class="navbar navbar-expand-lg navbar-dark  shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="assets/images/logo-dark.png" alt="logo-small" height="40" class="d-inline-block">                     
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarsExample07">
                    <ul class="navbar-nav ml-auto">  
                        <li class="nav-item align-self-center">
                            <a class="nav-link" href="#Servicios">Servicios</a>
                        </li> 
                        <li class="nav-item align-self-center">
                            <a class="nav-link" href="./crear-cuenta">Crear cuenta</a>
                        </li>                                              
                        <li class="nav-item align-self-center">
                        <a class=" btn btn-sm btn-danger" href="./login" role="button"><i class="fas fa-sign-in-alt me-2"></i></i></i>Iniciar sesión</a>
                        </li>
                    </ul>                
                </div>
            </div>
        </nav>
        

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
       

    </body>
</html>