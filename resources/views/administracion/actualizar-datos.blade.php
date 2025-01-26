@php
    $dbTipoContactos = json_decode($dbTipoContactos);
    $dbContactos = json_decode($dbContactos);

@endphp
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-dark ">
                <h4 class="card-title text-white">Actualizar mis datos</h4>
                <p class="text-muted mb-0 text-white">Estimado(a) {{ Session::get('SESS_NOMBRES') }}, <code class="highlighter-rouge text-white"> es vital tener actualiado tus datos.</code> 
                </p>
            </div><!--end card-header-->
            <div class="card-body border border-dark">

                <form method="post" id="fmr-actualizar-datos">
                <div class="row g-2">
                    <div class="col-md-8">
                        <div class="form-floating mb-3">
                            <div class="col-md">
                                <div class="form-floating">
                                <input type="text" class="form-control" id="txtNomContri" name="txtNomContri" readonly="" value="{{ Session::get('SESS_NOMBRE_COMPLETO') }}">
                                <label for="txtNomContri">Contribuyente</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <div class="col-md">
                                <div class="form-floating">
                                <input type="text" class="form-control" id="txtCodigo" name="txtCodigo" readonly="" value="{{ Session::get('SESS_CODIGO') }}">
                                <label for="txtCodigo">Codigo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-8">
                        <div class="form-floating mb-3">
                            <div class="col-md">
                                <div class="form-floating">
                                <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" readonly="" value="">
                                <label for="txtDireccion">Dirección fiscal</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 


                        #unset($params);
                        #$params = $codigo;
                        #$data_doc = $this->Crud_aplicativo->s_s_V_RELA_DOCU($params);
                        #$row_doc = $data_doc->row();

                     ?>

                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <div class="col-md">
                                <div class="form-floating">
                                <input type="text" class="form-control" id="txtNum_doc" name="txtNum_doc" readonly="" value="">
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
                              
                                     @foreach ($dbTipoContactos as $select)
                                        @if(like_match('%TELE%',$select->TIPO_D_NOMBRE)==TRUE)
                                        
                                        <option value="{{ $select->TIPO_D_CODIGO }}">{{ $select->TIPO_D_NOMBRE }}</option>
                                  
                                        @endif
                                    @endforeach

                            </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="">
                            <input type="number" class="form-control" id="txtvalor1"  value="">
                            </div>
                        </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-success text-center" id="btn-add-datos1" ><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="row mb-2">
                        <div class="col-md-5">
                            <div class="">
                            <select class="form-select" id="cmbtipo-datos2" aria-label="Floating label select example">
                               
                                    @foreach ($dbTipoContactos as $select)
                                        @if(like_match('%CEL%',$select->TIPO_D_NOMBRE)==TRUE)
                                  
                                        <option value="{{ $select->TIPO_D_CODIGO }}">{{ $select->TIPO_D_NOMBRE }}</option>
                                  
                                        @endif
                                    @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="">
                            <input type="number" class="form-control" id="txtvalor2"  value="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-success text-center" id="btn-add-datos2" ><i class="fas fa-plus"></i></button>
                        </div>
                </div>



                <div class="row mb-2">
                        <div class="col-md-5">
                            <div class="">
                            <select class="form-select" id="cmbtipo-datos3" aria-label="Floating label select example">
                                 @foreach ($dbTipoContactos as $select)
                                        @if(like_match('%EMAI%',$select->TIPO_D_NOMBRE)==TRUE)
                                  
                                        <option value="{{ $select->TIPO_D_CODIGO }}">{{ $select->TIPO_D_NOMBRE }}</option>
                                  
                                        @endif
                                @endforeach
                                   
                            </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="">
                            <input type="text" class="form-control" id="txtvalor3"  value="">
                            </div>
                        </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-success text-center" id="btn-add-datos3" ><i class="fas fa-plus"></i></button>
                    </div>
                </div>

                <br>

                    <div class="datos-div">
                        @foreach ($dbContactos as $datos)
                                <input type="hidden" class="form-control id-delete-{{ $datos->TIPO_D_CODIGO }}" id-tipo-datos=" {{ $datos->TIPO_D_CODIGO }}" name="datos_pers[]" value="{{ $datos->TIPO_D_CODIGO }}*{{ $datos->CONTC_DATOS }}">
                        @endforeach
                    </div>

                <div class="table-responsive">
                    <table class="table table-bordered mb-0 table-centered" id="table-datos-actualizar">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Pertenece</th>
                            <th>Valor</th>
                            <th class="text-right">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
        
                           @php

                            $i=1;
                            $color='';
                             foreach ($dbContactos as $datos):
                                $tp_dc = $datos->TIPO_D_CODIGO;
                                if($tp_dc==8 || $tp_dc==1 || $tp_dc==14):
                                    $color = 'success';
                                elseif($tp_dc==15):
                                    $color = 'info';
                                else:
                                    $color = 'dark';
                                endif;

                           @endphp
                          
                        <tr>
                            <td style="background-color: #f1f5fa;">*</td>
                            <td style="background-color: #f1f5fa;"><span class=" badge-soft-{{$color}}" style="font-size: 0.9rem!important;">{{$datos->TIPO_D_NOMBRE}}</span></td>
                            <td style="background-color: #f1f5fa;">{{$datos->CONTC_DATOS}}</td>
                            <td style="background-color: #f1f5fa;" class="text-center">                                                       
                                <!-- <a href="#"><i class="las la-pen text-secondary font-16"></i></a> -->
                                <button type="button" class="btn btn-sm" onclick="deleteRow(this,{{$datos->TIPO_D_CODIGO}});"><i class="las la-trash-alt text-danger font-16"></i></button>
                            </td>
                        </tr>


                       @php
                            $i++;

                            endforeach;
                        @endphp
                        
                        </tbody>
                    </table><!--end /table-->
                </div>

                <br>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <button type="button" class="btn btn-danger px-4 waves-effect waves-light" id="btn-actualizar-datos" onclick="actualizar_datos();"><i class="mdi mdi-send me-2"></i> Actualizar mis datos</button>
                    </div>
                </div>

                </form>



            </div>
        </div><!--end card-->
    </div><!--end col-->


</div><!--end row-->

<style>
    table tbody tr td{
        font-size: 0.9rem;
    }
</style>