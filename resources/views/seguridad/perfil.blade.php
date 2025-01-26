@php
    $dataUser = json_decode($dataUser);
    $dataPers = json_decode($dataPers);

    //dd($dataUser);
@endphp

<input type="hidden" id="PERS_CODIGO" name="PERS_CODIGO" value="{{ $dataPers[0]->PERS_CODIGO }}">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="met-profile">
                    <div class="row">
                        <div class="col-lg-12 align-self-center mb-3 mb-lg-0">
                            <div class="met-profile-main">
                                <div class="met-profile-main-pic">
                                    <img src="{{ asset('img_datos/' . Session::get('SESS_PERS_DOCUMENTO') . '.png') }}" alt="" height="110" >
                                    <span class="met-profile_main-pic-change">
                                        <i class="fas fa-camera"></i>
                                    </span>
                                </div>
                                <div class="met-profile_user-detail">
                                    <h5 class="met-user-name">{{ Session::get('SESS_NOMBRE_COMPLETO') }}</h5>                                                        
                                    <p class="mb-0 met-user-name-post">{{ Session::get('SESS_PERF_NOMBRE') }}</p>                                                        
                                </div>
                            </div>                                                
                        </div>
                   

                    </div><!--end row-->
                </div><!--end f_profile-->                                                                                
            </div><!--end card-body--> 
        </div><!--end card-->
    </div><!--end col-->
</div>

<div class="row">                        
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <table>
                    <tr>
                        <td>Nombres:</td>
                        <td>{{ $dataUser[0]->PERS_NOMBRE }}</td>
                    </tr>
                    <tr>
                        <td>Paterno:</td>
                        <td>{{ $dataUser[0]->PERS_APATERNO }}</td>
                    </tr>
                    <tr>
                        <td>Materno:</td>
                        <td>{{ $dataUser[0]->PERS_AMATERNO }}</td>
                    </tr>
                    <tr>
                        <td>Sexo</td>
                        <td>
                            <select name="" id="" class="form-select form-select-sm disabled">
                                <option value="M" {{ ($dataPers[0]->PERS_SEXO=='M')?'selected':'' }}>Masculino</option>
                                <option value="F" {{ ($dataPers[0]->PERS_SEXO=='F')?'selected':'' }}>Femenino</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Fecha Nacimiento:</td>
                        <td><input type="date" class="form-control form-control-sm" id="PERS_FECNACI" placeholder="Fecha nacimiento" value="{{ $dataPers[0]->PERS_FECNACI }}" readonly></td>
                    </tr>
                    <tr>
                        <td>Dirección</td>
                        <td>{{ $dataPers[0]->PERS_DIRECCION }}</td>
                    </tr>
                </table>
            </div><!--end card-body-->
        </div><!--end card-->
    </div>
</div>
