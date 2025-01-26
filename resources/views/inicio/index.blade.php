<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title><?=$page_title ?></title>
        <meta content="{{ config('app.SISTEMA') }} - {{ config('app.MUNICIPALIDAD') }}" name="description" />
        <meta content="JJ. Espinoza Valera" name="author" />
        <link rel="shortcut icon" href="{{ asset('assets/images/logo-64x64.ico') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('topcss')
        <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/jquery-ui.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}" />
        <style>
            .app:hover{
                background-color: #ff00001a;
                transform: scale(1) translateZ(0);
                box-shadow: 0 15px 24px rgba(0,0,0,0.11);
                border: 1px solid #f5325c;
            }
            .app:hover .card-body strong{
                color: red;
            }
            .app:hover img{
                filter: drop-shadow(2px 4px 0px red);
            }
        </style>
        <script type='text/javascript'> 
            var urljs = '@php echo URL('/').'/'; @endphp'
        </script>
    </head>
    <body data-layout="horizontal" class="dark-topbar">

        <div class="topbar">  
            
            <div class="brand">
                <a href="#" class="logo">
                    <span>
                        <img src="{{ asset('assets/images/logo-white.png') }}" alt="logo-small" class="logo-sm" style="height: 70%;">
                    </span>
                </a>
            </div>
            
            
            <nav class="navbar-custom">    
                <ul class="list-unstyled topbar-nav float-end mb-0"> 
                    <li class="btn-login">
                        <div class="nav-link">
                            <a class=" btn btn-sm btn-danger" href="./login" role="button"><i class="fas fa-sign-in-alt me-2"></i></i></i>Iniciar sesión</a>
                        </div>                                
                    </li>

                    <li class="menu-item">
                        <a class="navbar-toggle nav-link" id="mobileToggle">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                    </li> 
                </ul>
                <div class="navbar-custom-menu">
                    <div id="navigation">
                        
                        <ul class="navigation-menu">
                            <li class="has-submenu">
                                <a href="#">
                                    <span><i data-feather="home" class="align-self-center hori-menu-icon"></i>Inicio</span>
                                </a>
                            </li>
    
                            <li class="has-submenu">
                                <a href="#">                                
                                    <span><i data-feather="grid" class="align-self-center hori-menu-icon"></i>Estado de cuenta <i class="mdi mdi-chevron-down"></i></span>
                                    
                                </a>
                                <ul class="submenu">
                                    <li><a href="#"><i class="ti ti-minus"></i>Estado de cuenta General</a></li>
                                    <li><a href="#"><i class="ti ti-minus"></i>Multas Tributarias</a></li>
                                    <li><a href="#"><i class="ti ti-minus"></i>Multas Administrativas</a></li>
                                    <li><a href="#"><i class="ti ti-minus"></i>Expedientes Coactivos</a></li>
                                    <li><a href="#"><i class="ti ti-minus"></i>Valores Tributarios</a></li>
                                    <li><a href="#"><i class="ti ti-minus"></i>Contratos Fraccionados</a></li>  
                                </ul>
                            </li>
                            
                            <li class="has-submenu">
                                <a href="#">
                                    <span><i data-feather="file-plus" class="align-self-center hori-menu-icon"></i>Mi espacio</span>
                                </a>
                                <ul class="submenu">
                                    <li><a href="#"><i class="ti ti-minus"></i>Actualizar mis datos</a></li>
                                    <li><a href="#"><i class="ti ti-minus"></i>Casilla Eléctronica</a></li>
                                    <li><a href="#"><i class="ti ti-minus"></i>Pagos de Tasas</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu">
                                <a href="#">
                                    <span><i data-feather="layers" class="align-self-center hori-menu-icon"></i>Pago Tributario</span>
                                </a>                               
                            </li>
                            <li class="has-submenu">
                                <a href="#">
                                    <span><i data-feather="layers" class="align-self-center hori-menu-icon"></i>Cuponera Virtual</span>
                                </a>                               
                            </li>
                            <li class="has-submenu">
                                <a href="#">
                                    <span><i data-feather="layers" class="align-self-center hori-menu-icon"></i>Mis Tramites</span>
                                </a>                               
                            </li>
                        </ul>
                    </div> 
                </div>
            </nav>
        </div>
        
        <div class="page-wrapper">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-sm-10">
                            <div class="page-title-box">
                                <div class="row">
                                    <div class="col">
                                        <h1 class="font-22 fw-bold mb-0 m-0 lh-1">{{ config('app.SISTEMA') }}</h1>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="javascript:void(0);">Inicio</a></li>
                                            <li class="breadcrumb-item active">Aplicaciones</li>
                                        </ol>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0 mb-2">
                        </div>
                    </div>
                    
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col text-center">
                                                        <strong>Casilla<br>Electrónica</strong><br>
                                                        <img src="{{ asset('assets/images/apps/email.png') }}" alt="" class="thumb-xl">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                                <div class="row d-flex justify-content-center">                                                
                                                    <div class="col text-center">
                                                        <strong>Mis<br>Tramites</strong><br>
                                                        <img src="{{ asset('assets/images/apps/tramites.png') }}" alt="" class="thumb-xl">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="card app bg-soft-secondary">
                                        <div class="card-body">
                                            <a href="./">
                                                <div class="row d-flex justify-content-center">                                                
                                                    <div class="col text-center">
                                                        <strong>Actualizar<br>Mis Datos</strong><br>
                                                        <img src="{{ asset('assets/images/apps/actualizar.png') }}" alt="" class="thumb-xl">
                                                    </div> 
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Multas<br>Tributaria</strong><br>
                                                    <img src="{{ asset('assets/images/apps/multa-tributaria.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Multas<br>Administrativa</strong><br>
                                                    <img src="{{ asset('assets/images/apps/multa-administrativa.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Valores<br>Tributarios</strong><br>
                                                    <img src="{{ asset('assets/images/apps/valores.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Pago<br>Tributario</strong><br>
                                                    <img src="{{ asset('assets/images/apps/pago-tributario.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Pago<br>Tasas</strong><br>
                                                    <img src="{{ asset('assets/images/apps/tasas.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="card app bg-soft-secondary">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Cuponera<br>Virtual</strong><br>
                                                    <img src="{{ asset('assets/images/apps/cuponera.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Contratos<br>Fraccionamientos</strong><br>
                                                    <img src="{{ asset('assets/images/apps/contrato.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Expedientes<br>Coactivos</strong><br>
                                                    <img src="{{ asset('assets/images/apps/expediente.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Estado<br>de Cuenta</strong><br>
                                                    <img src="{{ asset('assets/images/apps/pagar.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row justify-content-center">
                        <div class="col-lg-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col text-center">
                                                        <strong>Casilla<br>Eléctronica</strong><br>
                                                        <img src="{{ asset('assets/images/apps/email.png') }}" alt="" class="thumb-xl">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                                <div class="row d-flex justify-content-center">                                                
                                                    <div class="col text-center">
                                                        <strong>Mis<br>Tramistes</strong><br>
                                                        <img src="{{ asset('assets/images/apps/tramites.png') }}" alt="" class="thumb-xl">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Pago<br>Tributario</strong><br>
                                                    <img src="{{ asset('assets/images/apps/pago-tributario.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Pago<br>Tasas</strong><br>
                                                    <img src="{{ asset('assets/images/apps/tasas.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="row border-start border-3">
                                <div class="col-lg-12">
                                    <div class="card app bg-soft-secondary">
                                        <div class="card-body">
                                            <a href="./">
                                                <div class="row d-flex justify-content-center">                                                
                                                    <div class="col text-center">
                                                        <strong>Actualizar<br>Mis Datos</strong><br>
                                                        <img src="{{ asset('assets/images/apps/actualizar.png') }}" alt="" class="thumb-xl">
                                                    </div> 
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card app bg-soft-secondary">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Cuponera<br>Virtual</strong><br>
                                                    <img src="{{ asset('assets/images/apps/cuponera.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row border-start border-3">
                                <div class="col-lg-4">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Multas<br>Tributaria</strong><br>
                                                    <img src="{{ asset('assets/images/apps/multa-tributaria.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Multas<br>Administrativa</strong><br>
                                                    <img src="{{ asset('assets/images/apps/multa-administrativa.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Valores<br>Tributarios</strong><br>
                                                    <img src="{{ asset('assets/images/apps/valores.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Contratos<br>Fraccionamientos</strong><br>
                                                    <img src="{{ asset('assets/images/apps/contrato.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Expedientes<br>Coactivos</strong><br>
                                                    <img src="{{ asset('assets/images/apps/expediente.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <div class="card app">
                                        <div class="card-body">
                                            <a href="./">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col text-center">
                                                    <strong>Estado<br>de Cuenta</strong><br>
                                                    <img src="{{ asset('assets/images/apps/pagar.png') }}" alt="" class="thumb-xl">
                                                </div> 
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            @include('footer')
        </div>
        @include('jscripts')
        <script src="{{ asset('assets/plugins/datepicker/jquery-ui.js') }}"></script>
        <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/notify/notify.min.js') }}"></script>
        <script src="{{ asset('assets/js/js_inicio-citas.js') }}"></script>
</body>

</html>