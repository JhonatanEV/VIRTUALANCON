<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title><?=$page_title ?></title>
        <meta content="Plataforma Virtual de Municipalidad de Ancón" name="description" />
        <meta content="JJ. Espinoza Valera" name="author" />
        <link rel="shortcut icon" href="{{ asset('assets/images/logo-64x64.ico') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('topcss')
        <style>
            .nav-link{
                color: #9ba7ca;
            }            
        </style>
        <script type='text/javascript'> 
            var urljs = '@php echo URL('/').'/'; @endphp'
        </script>
    </head>
<body class="account-body bg-soft-dark">
        <div class="container">
            <div class="row vh-100 d-flex justify-content-center">
                <div class="col-12 align-self-center">
                    <div class="row">
                        <div class="col-lg-7 mx-auto">
                            <div class="card" style="box-shadow: 0 0 13px 0 rgba(82,63,105,.1);">
                                <div class="card-header p-0  bg-image">
                                    <div class="row">
                                        <div class="col-lg-4 border-end">
                                            <div class="text-center p-3">
                                                <img src="{{ asset('assets/images/logo-dark.png') }}" height="60" alt="logo" class="auth-logo">
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="text-center p-3">
                                                <h4 class="mt-3 mb-1 fw-bold font-18">Crear nueva cuenta</h4>   
                                                <p class="alert-info p-2 mb-0">
                                                ¡CHAT RENTAS! 🔔
                                                ¡Atención vecinos! Si necesitas información sobre tus arbitrios, cuponeras o estado de cuenta, estamos aquí para ayudarte. 💼
                                                📲 Escríbenos al WhatsApp: 
                                                <a href="https://wa.me/51912462751" target="_blank" class="text-primary">912462751</a> y recibe toda la información que necesitas de forma rápida y sencilla. ¡Estamos para servirte!
                                                </p>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                   
                                    <form action="#" method="post" id="frmCuenta">
                                    
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="pers_tipodoc" class="fw-bold">Tipo de documento</label>
                                                <select class="form-select" id="pers_tipodoc" name="pers_tipodoc" required="">
                                                    <option value="1" selected>D.N.I</option>
                                                    <option value="2">RUC</option>
                                                    <option value="3">CARNET EXTRANJERIA</option>
                                                    
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="pers_documento" class="fw-bold">Número de documento</label>
                                                <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="pers_documento" name="pers_documento" placeholder="Ingrese número de documento" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required="" onkeyup="validadatos(this.value);" maxlength="8">
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary waves-effect waves-light" type="button" id="btn-validar-doc"><i class="fas fa-check-circle"></i> Validar</button>
                                                </div>
                                                </div>
                                                <div id="div_validadni" style="display: none; font-size:14px;"> </div>
                                            </div>
                                        </div> 
                                        <div class="group mb-2">
                                            <label for="pers_nombre" class="fw-bold">Nombres</label>
                                            <input type="text" class="form-control" id="pers_nombre" name="pers_nombre" pl="Nombre/Razón social" readonly="">        
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label for="pers_direccion" class="fw-bold">Dirección fiscal</label>
                                                <input type="text" class="form-control" id="pers_direccion" name="pers_direccion" pl="Dirección fiscal" readonly="">     
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label for="pers_correo" class="fw-bold">Correo electrónico</label>
                                                <input type="email" class="form-control" id="pers_correo" name="pers_correo" pl="mail@example.com" required> 
                                            </div>
                                            <div class="col-md-6">
                                                <label for="pers_celular" class="fw-bold">Número celular</label>
                                                <input type="text" class="form-control" id="pers_celular" name="pers_celular" pl="999999999" maxlength="9" minlength="9" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required="">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label for="password" class="fw-bold">Crear una contraseña</label>
                                                <input type="password" class="form-control" id="password" name="usua_password" placeholder="Ingrese nueva contraseña" minlength="6" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="conf_password" class="fw-bold">Confirmar la contraseña</label>
                                                <input type="password" class="form-control" id="conf_password" pl="Confirme la contraseña" minlength="6" onkeydown="valida_clave();" onkeyup="valida_clave();" required>  
                                                <span id="smserror1" class="mb-0"></span> 
                                            </div>
                                            <span id="smserror" class="mb-0"></span>
                                        </div>
                                        <hr class="mb-1">
                                        <div class="row rounded-3">
                                            <div class="col-md-6 align-self-xl-center">
                                                    <label for="numdoc" class="fw-bold">Codigo del Contribuyente</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ejempl. 0045811" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="10">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-secondary waves-effect waves-light" type="button" id="btn-validar-contribuyente"><i class="fas fa-check-circle"></i> Validar</button>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="col-md-6 align-self-xl-center">
                                                <label for="contribuyente" class="fw-bold">Contribuyente</label>
                                                <input type="text" class="form-control" id="contribuyente" name="contribuyente" readonly required> 
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="alert alert-warning border-0" role="alert">
                                                    <strong>Atención,</strong> el codigo de contribuyente debe estar asociado a su documento de identidad.
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mt-2 text-center">
                                            <button class="btn btn-blue btn-block waves-effect waves-light btn-lg" type="submit" id="btn-create-user" ><i class="fas fa-angle-right"></i> Registrar cuenta</button>
                                    
                                        </div>
                                    </form>

                                    <p class="text-muted mb-0 mt-3"><a href="./login" class="text-primary ms-2">Iniciar sesión</a></p>
                                </div>
                                <div class="card-body bg-light-alt text-center">
                                    <!-- <script>document.write(new Date().getFullYear())</script> -->
                                Copyright <a href="https://www.linkedin.com/in/juctan/" target="_blank">©</a> - {{ config('app.SISTEMA') }}                                         
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        @include('jscripts')
        
        <script src="{{ asset('assets/js/js_crear-cuenta.js?v=') }}@php echo rand(1,9999); @endphp"></script>
</body>
</html>