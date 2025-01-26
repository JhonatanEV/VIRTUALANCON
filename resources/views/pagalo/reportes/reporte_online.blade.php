<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Ingresos por Pagos Online de tributos, canchas y talleres</h4>
                <p class="text-muted mb-0">Seleccione rango de fechas para consultas la información</p>
            </div>
            <div class="card-body">    
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link text-center active" data-bs-toggle="tab" href="#cu_home" role="tab" aria-selected="true"><i class="la la-home d-block"></i>Tributos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#cu_profile" role="tab" aria-selected="false"><i class="fas fa-futbol d-block"></i>Canchas</a>
                        </li>                                                
                        <li class="nav-item">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#cu_settings" role="tab" aria-selected="false"><i class="fas fa-people-carry d-block"></i>Talleres</a>
                        </li>
                    </ul>
                </div>
                
                <div class="tab-content mt-2">
                    <div class="tab-pane active" id="cu_home" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="date" class="form-control" id="FEC_INI" name="FEC_INI" >
                                                <label for="FEC_INI">Fecha desde</label>
                                                </div>
                                            </div>

                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="date" class="form-control" id="FEC_HASTA" name="FEC_HASTA" >
                                                <label for="FEC_HASTA">Fecha hasta</label>
                                                </div>
                                            </div>

                                            <div class="col-md">
                                                <button type="button" class="btn btn-danger form-control " style="height: 55px;" id="btn-consultar" >Consultar
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                        <div class="card-body bg-soft-dark">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-12 text-center">
                                                    <p class="text-dark mb-0 fw-bold">Monto Total </p><h3 class="my-1 font-22 fw-bold text-danger" id="montoTotal">S/ 0.00</h3>                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="card">
                                    
                                    <div class="card-body">
                                        <table class="table table-sm table-striped" id="tablaIngreso">
                                            <thead>
                                                <tr class="bg-soft-dark">
                                                    <th>Item</th>
                                                    <th>Fecha</th>
                                                    <!-- <th width="12%">N° Operación</th> -->
                                                    <th>Monto</th>
                                                    <th>Codigo</th>
                                                    <th>Contributyente</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane mt-2" id="cu_profile" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="date" class="form-control" id="FEC_INI_CANCHA" name="FEC_INI_CANCHA" >
                                                <label for="FEC_INI_CANCHA">Fecha desde</label>
                                                </div>
                                            </div>

                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="date" class="form-control" id="FEC_HASTA_CANCHA" name="FEC_HASTA_CANCHA" >
                                                <label for="FEC_HASTA_TALLER">Fecha hasta</label>
                                                </div>
                                            </div>

                                            <div class="col-md">
                                                <button type="button" class="btn btn-danger form-control " style="height: 55px;" id="btn-consultar-cancha" >Consultar
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                        <div class="card-body bg-soft-dark">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-12 text-center">
                                                    <p class="text-dark mb-0 fw-bold">Monto Total </p><h3 class="my-1 font-22 fw-bold text-danger" id="montoTotalCancha">S/ 0.00</h3>                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="card">
                                    
                                    <div class="card-body">
                                        <table class="table table-sm table-striped" id="tablaIngresoCancha">
                                            <thead>
                                                <tr class="bg-soft-dark">
                                                    <th>Item</th>
                                                    <th>Fecha</th>
                                                    <th width="12%">N° Operación</th>
                                                    <th>Monto</th>
                                                    <th>Documento</th>
                                                    <th>Ciudadano</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                                                
                    <div class="tab-pane mt-2" id="cu_settings" role="tabpanel">

                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="date" class="form-control" id="FEC_INI_TALLER" name="FEC_INI_TALLER" >
                                                <label for="FEC_INI_TALLER">Fecha desde</label>
                                                </div>
                                            </div>

                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="date" class="form-control" id="FEC_HASTA_TALLER" name="FEC_HASTA_TALLER" >
                                                <label for="FEC_HASTA_TALLER">Fecha hasta</label>
                                                </div>
                                            </div>

                                            <div class="col-md">
                                                <button type="button" class="btn btn-danger form-control " style="height: 55px;" id="btn-consultar-taller" >Consultar
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                        <div class="card-body bg-soft-dark">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-12 text-center">
                                                    <p class="text-dark mb-0 fw-bold">Monto Total </p><h3 class="my-1 font-22 fw-bold text-danger" id="montoTotalTaller">S/ 0.00</h3>                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="card">
                                    
                                    <div class="card-body">
                                        <table class="table table-sm table-striped" id="tablaIngresoTaller">
                                            <thead>
                                                <tr class="bg-soft-dark">
                                                    <th>Item</th>
                                                    <th>Fecha</th>
                                                    <th width="12%">N° Operación</th>
                                                    <th>Monto</th>
                                                    <th>Documento</th>
                                                    <th>Alumno</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>