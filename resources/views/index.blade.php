<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>{{ $page_title }} - {{ config('app.SISTEMA') }}</title>
        <meta content="" name="description" />
        <meta content="Juctan J. Espinoza Valera" name="author" />
        <link rel="shortcut icon" href="{{ asset('assets/images/logo-64x64.ico') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @include('topcss')
    </head>

    <body data-layout="horizontal" class="dark-topbar">
        

        <div class="page-wrapper">
            @include('header')
            <!-- Page Content-->
            <div class="page-content">
               
                    <div class="row banner-muni">
                        <div class="col-sm-12">
                            <div class="page-title-box">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="page-title font-22 fw-bold text-center m-2">{{ !empty($titulo_principal)?$titulo_principal:'Plataforma Virtual' }}</h4>
                                        <ol class="breadcrumb fw-bold text-center">
                                            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ !empty($breadcrumbone)?$breadcrumbone:$page_directory }}</a></li>
                                            <li class="breadcrumb-item active">{{ !empty($breadcrumb)?$breadcrumb:$page_directory }}</li>
                                        </ol>
                                    </div>
                                   
                                </div>                                                         
                            </div>
                        </div>
                    </div>
                    <br>
                    @include($page_directory . '.' . $page_name)

                    <div id="pagecontent"></div>
                </div>

                @include('footer')
        </div>
        @include('jscripts')

</body>

</html>
