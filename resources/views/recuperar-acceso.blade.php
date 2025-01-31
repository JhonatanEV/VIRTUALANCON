<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title><?=$page_title ?></title>
        <meta content="Plataforma Virtual de Municipalidad de Ancón" name="description" />
        <meta content="JJ. Espinoza Valera" name="author" />
        <link rel="shortcut icon" href="assets/images/logo-64x64.ico">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script type='text/javascript'> 
            var urljs = '@php echo URL('/').'/'; @endphp'
        </script>
        @include('topcss')

        <style>
            .bg-image{
                background: url(assets/images/Slider-04-002.png);
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }
            .auth-full-bg {
                background-color: rgb(220 10 25);
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
            }
        </style>    
    </head>
    <body class="account-body bg-soft-dark">


        <div class="container">
            <div class="row vh-100 d-flex justify-content-center">
                <div class="col-12 align-self-center">
                    <div class="row">
                        <div class="col-lg-5 mx-auto">
                            <div class="card" style="box-shadow: 0 0 13px 0 rgba(82,63,105,.1);">
                                <div class="card-body p-0 ">
                                    <div class="text-center p-3">
                                        <a href="#" class="logo logo-admin">
                                            <img src="{{ asset('assets/images/muni.png') }}" height="50" alt="logo" class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-muted font-18">Restablecer contraseña para la Plataforma Virtual</h4>   
                                        <p class="text-muted  mb-0">¡Ingrese su correo electrónico y se le enviarán las instrucciones!</p>  
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form class="form-horizontal auth-form" action="solicitar-clave" method="post" id="frmRecuperar">

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="txtcodigo">Usuario(DNI/RUC)</label>
                                            <div class="input-group">                                                                                         
                                                <input type="text" class="form-control" id="txtcodigo" name="txtcodigo" placeholder="0000000" maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
                                               

                                            </div>                                    
                                        </div>


                                        <div class="form-group mb-2">
                                            <label class="form-label" for="username">Correo electrónico registrado</label>
                                            <div class="input-group">                                                                                         
                                                <input type="email" class="form-control" id="useremail" name="useremail" placeholder="email@gmail.com" required>
                                            </div>                                    
                                        </div>
                
                                        <div class="form-group mb-0 row">
                                            <div class="col-12 mt-2">
                                                <button class="btn bg-blue text-white w-100 waves-effect waves-light font-16" type="submit" id="btn-solicitar">Solicitar <i class="fas fa-sign-in-alt ms-1"></i></button>
                                            </div><!--end col--> 
                                        </div> <!--end form-group-->                           
                                    </form><!--end form-->
                                    <p class="text-muted mb-0 mt-3"><a href="./login" class="text-blue ms-2">Iniciar sesión</a></p>
                                </div>
                                <div class="card-body bg-light-alt text-center">
                                    <span class="text-muted d-none d-sm-inline-block">Municipalidad de Ancón © <script>
                                        document.write(new Date().getFullYear())
                                    </script></span>                                            
                                </div>
                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @include('jscripts')
        <style>
            .form-control::placeholder {
                color:#a4abcf47;
            }
        </style>
        <script>

                $("#frmRecuperar").submit(function(e) {
                        e.preventDefault();
                        var form = $(this);

                        let codigo = $("#txtcodigo").val();
                        let correo = $("#useremail").val();

                        if (codigo.length<=0 && correo.length<=0) {
                            $(".alert-error").removeClass('d-none');
                            return false;
                        }else{
                            let data = new FormData(this);
                            envioAjaxdata("login/recuperar-clave",data,function(res){
                                if(res.status){
                                    var buttons = $('<div>')
                                        .append(
                                            createButton('Aceptar','btn-blue', function() {
                                                Swal.close();
                                                window.location.href = 'login';
                                            })
                                        ).get(0);
                                        showMessageAlertHtml(res.mensaje,'success',buttons);

                                    }else{
                                        showMessageAlert("Mensaje",res.mensaje,'info');
                                    }
                            });
                           
                        }
                    });

        </script>
</body>

</html>