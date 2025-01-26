@php
#dd($dbTipoContacto);
@endphp
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-lg-4">
                <div class="alert alert-light mb-0 border-bottom border-2 border-danger" role="alert">
                    <p>Estimado(a): <b>{{Session::get('SESS_NOMBRE_COMPLETO')}}</b><br> <br>Te recordamos la importancia de mantener actualizados tus datos de contacto en nuestros registros. Asegurarte de proporcionarnos tu número de celular, correo electrónico y teléfono actualizados nos permitirá comunicarnos contigo de manera efectiva y brindarte un mejor servicio.<br>
                    La información actualizada nos ayuda a:
                        <ol>
                            <li>Notificarte sobre eventos, noticias y cambios importantes en tu municipalidad.</li>
                            <li>Informarte sobre programas, servicios y beneficios disponibles para los ciudadanos</li>
                            <li>Contactarte en caso de emergencias o situaciones urgentes</li>
                            <li>Garantizar que recibas la información más reciente y relevante de tu interés</li>
                        </ol>
                       <br>Recuerda que tus datos personales son tratados con total confidencialidad y cumplimos con las leyes de protección de datos vigentes.</p>
                    <p class="mb-1">¡Gracias por tu colaboración!</p>
                    <!-- <p class="mb-0 fw-bold"> Pasos para guardar</p>
                        <ul>
                            <li>Presione en <button type="button" class="btn btn-outline-danger btn-sm text-center" ><i class="fas fa-plus me-1"></i>Agregar</button> para agregar un conctacto.</li>
                            
                        </ul> -->
                    
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                <div class="card-header bg-muni pb-0">
                    <h4 class="card-title text-white">Mis Datos Principales </h4>                    
                    </p>
                </div>
                <div class="card-body ">
                    
                    <form method="post" id="fmr-actualizar-datos">
                        <div class="row g-2">
                            <div class="col-md-8">
                                <div class="form-floating mb-3">
                                    <div class="col-md">
                                        <div class="form-floating">
                                        <input type="text" class="form-control" id="txtNomContri" name="txtNomContri" readonly="" value="{{Session::get('SESS_NOMBRE_COMPLETO')}}">
                                        <label for="txtNomContri">Nombres y Apellidos</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <div class="col-md">
                                        <div class="form-floating">
                                        <input type="text" class="form-control" id="txtCodigo" name="txtCodigo" readonly="" value="{{Session::get('SESS_CODIGO')}}">
                                        <label for="txtCodigo">Codigo</label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="row g-2">
                            <div class="col-md-8">
                                <div class="form-floating mb-3">
                                    <div class="col-md">
                                        <div class="form-floating">
                                        <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" readonly="" value="{{Session::get('SESS_PERS_DIRECCION')}}">
                                        <label for="txtDireccion">Dirección fiscal</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <div class="col-md">
                                        <div class="form-floating">
                                        <input type="text" class="form-control" id="txtNum_doc" name="txtNum_doc" readonly="" value="{{Session::get('SESS_PERS_DOCUMENTO')}}">
                                        <label for="txtNum_doc">DNI/RUC</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                                <div class="col-md-5">
                                    <div class="">
                                    <select class="form-select" id="cmbtipo-datos1" aria-label="Floating label select example">
                                        @foreach($dbTipoContacto as $dato1)
                                            @if(like_match('%TELE%',$dato1->TIPO_D_NOMBRE)==TRUE)
                                                <option value="{{$dato1->TIPO_D_CODIGO}}">{{$dato1->TIPO_D_NOMBRE}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="">
                                    <input type="text" class="form-control" id="txtvalor1" placeholder="Teléfono"  value="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger text-center" id="btn-add-datos1" ><i class="fas fa-plus me-1"></i>Agregar</button>
                                </div>
                        </div>

                        <div class="row mb-2">
                                <div class="col-md-5">
                                    <div class="">
                                    <select class="form-select" id="cmbtipo-datos2" aria-label="Floating label select example">
                                        @foreach($dbTipoContacto as $dato1)
                                            @if(like_match('%CEL%',$dato1->TIPO_D_NOMBRE)==TRUE)
                                                <option value="{{$dato1->TIPO_D_CODIGO}}">{{$dato1->TIPO_D_NOMBRE}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="">
                                    <input type="text" class="form-control" id="txtvalor2" placeholder="Celular" maxlength="9" value="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger text-center" id="btn-add-datos2" ><i class="fas fa-plus me-1"></i>Agregar</button>
                                </div>
                        </div>

                        <div class="row mb-2">
                                <div class="col-md-5">
                                    <div class="">
                                    <select class="form-select" id="cmbtipo-datos3" aria-label="Floating label select example">
                                        @foreach($dbTipoContacto as $dato1)
                                            @if(like_match('%EMAI%',$dato1->TIPO_D_NOMBRE)==TRUE)
                                                <option value="{{$dato1->TIPO_D_CODIGO}}">{{$dato1->TIPO_D_NOMBRE}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="">
                                    <input type="email" class="form-control" id="txtvalor3" placeholder="Correo"  value="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger text-center" id="btn-add-datos3" ><i class="fas fa-plus me-1"></i>Agregar</button>
                                </div>
                        </div>
                        <br>
                        
                        <div class="datos-div">
                        </div>
                        <div class="card-header bg-muni pb-0">
                            <h4 class="card-title text-white">Mis Datos Actualizados </h4>                    
                            <p></p>
                        </div>
                        <!-- <span class="fw-bold text-decoration-underline">Actualizar Mis Datos</span> -->
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 table-centered table-striped" id="table-datos-actualizar">
                                <!-- <thead class="bg-dark-50 text-center">
                                <tr>
                                    <th class="text-white">Pertenece</th>
                                    <th class="text-white">Valor</th>
                                    <th class="text-white text-right">Acción</th>
                                </tr>
                                </thead> -->
                                <tbody id="dataContenedor">
                                <tr>
                                    
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- <br>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-outline-dark px-4 waves-effect waves-light" id="btn-actualizar-datos"><i class="mdi mdi-send me-2"></i> Actualizar mis datos</button>
                            </div>
                        </div> -->

                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>