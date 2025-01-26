<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="utf-8" />
        <title>{{$page_title}} {{ config('app.SISTEMA') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{ config('app.MUNICIPALIDAD') }}" name="description" />
        <meta content="JJ. Espinoza Valera" name="author" />

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="assets/images/logo-64x64.ico">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/css/style-login.css') }}">
        <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->

        <script type='text/javascript'> 
            var urljs = "";
        </script>
    </head> 
   <style>
   
    .shape {
        position: absolute;
        bottom: 0;
        right: 0;
        left: 0;
        z-index: 1;
        pointer-events: none;
    }
    @media (max-width: 768px) {
        .auth-bg {
            display: none!important;
        }
    }
    </style>
    <body class="">
    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-12">
                <div class="card-body p-0">
                    <div class="row d-flex align-items-center">
                        
                        <div class="col-md-7 col-xl-9 col-lg-8  p-0 vh-100 d-flex justify-content-center auth-bg">
                            <div class="accountbg d-flex align-items-center"> 
                                <div class="account-title text-center text-white">
                                
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <h2 class="mt-3 text-white">Bienvenido a la <span class="text-white">{{ config('app.SISTEMA') }}</span> </h2>
                                            <h1 class="text-white fw-bold">Empecemos</h1>
                                            <a href="./" class="btn btn-lg btn-light" ><i class="fas fa-home me-2"></i>Regresar</a><br>
                                            
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-5 col-xl-3 col-lg-4">
                            <div class="card mb-0 border-0">
                                <div class="card-body p-0">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="mensaje" style="display: none;">
                                        <i class="mdi mdi-block-helper mr-2"></i>
                                        Ups!, verifiqué sus datos de acceso!
                                    </div>

                                    <div class="text-center p-3">
                                        <a href="#" class="logo logo-admin">
                                            <img src="assets/images/logo-dark.png" height="80" alt="logo" class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 font-20 fw-bold">{{ config('app.SISTEMA') }}</h4>  
                                        <div class="border w-25 mx-auto border-blue"></div> 
                                        <p class="text-muted  mb-0">Inicia sesión para continuar.</p>  
                                    </div>
                                </div>
                                <div class="card-body pt-0">                                    
                                    <form class="my-4" method="post" name="form1" id="form1">            
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="username">Usuario (Codigo)</label>
                                            <input type="number" class="form-control" id="username" name="username" placeholder="Ingrese usuario" autocomplete="off" required="">                               
                                        </div>
                                        
                                        <div class="mb-3">
                                            
                                            <label class="form-label">Contraseña</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese contraseña" aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-off-outline icon-pass"></i></button>
                                            </div>
                                            <div class="text-end">
                                                <a href="recuperar-acceso" class="text-muted fw-bold">¿Olvidaste tu contraseña?</a>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <button class="btn btn-blue waves-effect waves-light" type="submit" id="btn-login">Iniciar sesión<i class="fas fa-sign-in-alt ms-1"></i></button>
                                                </div>
                                            </div>
                                        </div> 
                                    </form>
                                    <div class="mt-2 text-center">
                                            <p>No tengo una cuenta ? <a href="crear-cuenta" class="fw-medium text-primary"> Regístrate ahora </a> </p>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>      

        <style>
            .auth-bg{
                background: radial-gradient(circle at 39% 47%, rgba(107, 107, 107, .08) 0, rgba(107, 107, 107, .08) 33.333%, rgba(72, 72, 72, .08) 33.333%, rgba(72, 72, 72, .08) 66.666%, rgba(36, 36, 36, .08) 66.666%, rgba(36, 36, 36, .08) 99.999%), radial-gradient(circle at 53% 74%, rgba(182, 182, 182, .08) 0, rgba(182, 182, 182, .08) 33.333%, rgba(202, 202, 202, .08) 33.333%, rgba(202, 202, 202, .08) 66.666%, rgba(221, 221, 221, .08) 66.666%, rgba(221, 221, 221, .08) 99.999%), radial-gradient(circle at 14% 98%, rgba(184, 184, 184, .08) 0, rgba(184, 184, 184, .08) 33.333%, rgba(96, 96, 96, .08) 33.333%, rgba(96, 96, 96, .08) 66.666%, rgba(7, 7, 7, .08) 66.666%, rgba(7, 7, 7, .08) 99.999%), linear-gradient(45deg, #0086f4, #0184e7);
            }
        </style>
    
        <script src="{{ asset('assets/js/jquery.min.js')}} "></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js')}} "></script>
        <script src="{{ asset('assets/js/metismenu.min.js')}} "></script>
        <script src="{{ asset('assets/js/waves.js')}} "></script>
        <script src="{{ asset('assets/js/feather.min.js')}} "></script>
        <script src="{{ asset('assets/js/simplebar.min.js')}} "></script>
        <script src="{{ asset('assets/plugins/toastr/build/toastr.min.js')}} "></script>
        <script src="{{ asset('assets/js/js_general.js')}} "></script>
        

        <script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>
        <script src="{{ asset('assets/js/auth-2-carousel.init.js')}}"></script>
     
        <script type="text/javascript">

            // $("#btn-login").attr("disabled",true);
            //  $('#btn-login').css('cursor','default');
            //  var correctCaptcha = function(response) {

            //     if (response.length==0) {
            //         $("#btn-login").attr("disabled",true);
            //         $('#btn-login').css('cursor','default');
            //     }else{
            //         $("#btn-login").attr("disabled",false);
            //         $("#btn-login").removeClass("btn-secondary");
            //         $("#btn-login").addClass("btn-primary");
            //         $('#btn-login').css('cursor','pointer');
            //     }
            //  };

            $("#password-addon").click(function(){
                var tipo = document.getElementById("password");
                  if(tipo.type == "password"){
                      tipo.type = "text";
                      $('.icon-pass').removeClass('mdi-eye-off-outline').addClass('mdi-eye-outline');
                  }else{
                      tipo.type = "password";
                      $('.icon-pass').removeClass('mdi-eye-outline').addClass('mdi-eye-off-outline');
                  }
            });

            // $("#btn-login").click(function(){
            //     login();
            // });
            // $("#password").keypress(function(e) {
            //    if(e.which == 13) {
            //       login();
            //    }
            // });

            $("#form1").submit(function(e) {
                    e.preventDefault();
                    
                    var parametros = $(this).serialize();
                    var data = new FormData(this);
                    var form = $(this);
                    validar("#username");
                    validar("#password");

                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route("valida-user") }}',
                        data: data,
                        dataType: 'json', 
                        encode: true,
                        cache: false,
                        processData: false,
                        contentType: false,
                        beforeSend:function(){
                            $("#btn-login").html('Validando...');
                        },
                        success: function(response){
                            $("#btn-login").html('Iniciar Sesión');
                            if (response.accion=='success') {
                                $("#btn-login").html('Ingresando...');
                                if(response.url!=null && response.url!=''){
                                    window.location.href=response.url;
                                }else{
                                    window.location.href='{{ route('main') }}';
                                }  
                            }else{
                                $("input").removeClass('is-valid');
                                $("input").addClass('is-invalid');
                                $("#mensaje").show(); //showMessage('error','Usuario no encontrado, intente nuevamente!','Alerta');
                               // grecaptcha.reset();
                                $("#btn-login").attr("disabled",false);
                                // $('#btn-login').css('cursor','default');
                            }
                        },
                        error:function(){
                            showMessage('error','Ocurrio un problema!','Alerta');
                            $("#btn-login").html('Iniciar Sesión');
                        }
                        });

            })
           
            function validar(id){
                if ($(id).val()=='') {
                    $(id).addClass("is-invalid");
                    $(id).focus();
                    return false;
                }else{
                    $(id).removeClass("is-invalid");
                    $(id).addClass("is-valid");
                }
            }

        </script>

    </body>

</html>

