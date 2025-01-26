
<div class="row mb-2 justify-content-center">
    <div class="col-md-2">
        <label for="FECHA_NOTIFICACION">Fecha notificación:</label>
        <input id="FECHA_NOTIFICACION" name="FECHA_NOTIFICACION" type="date" class="form-control" required="">
        
    </div>

    <div class="col-md-2">
        <label for="">&nbsp;</label>
        <button type="button" class="btn btn-dark form-control" id="btn-consultar" onclick="listarData()">CONSULTAR</button>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="row">
            <div class=" col-sm-12">
                <div class="card">
                    <div class="card-header p-1">
                        
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h4 class="card-title">Notificaciones enviadas</h4>                   
                            </div>                                   
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="tab-content">
                            <div class="tab-pane active p-1" id="cu_home" role="tabpanel">
                                <table id="datatable" class="table table-striped dt-responsive nowrap table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead class="bg-dark">
                                    <tr>
                                        <th class="text-white">Item</th>
                                        <th class="text-white">Destino</th>
                                        <th class="text-white">Fecha Envio</th>
                                        <th class="text-white">Contenido</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody id="dataContenedor">
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

<div class="modal fade" id="IdModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-muni">
                    <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Notificación enviado</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="htmlBandeja">
                                                             
                </div>
                <div class="modal-footer">                                                    
                    <button type="button" class="btn btn-soft-secondary " data-bs-dismiss="modal">Cerrar ventana</button>
                </div>
            </div>
        </div>
    </div>
