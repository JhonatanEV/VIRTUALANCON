

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="row">
            <div class=" col-sm-12">
                <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Lista de Roles</h4>                   
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-soft-primary px-3" onclick="AbrirModal()">+ Agregar Nuevo</button>
                        </div>                                    
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="bg-light-gradient">
                            <tr>
                                <th>#</th>
                                <th>Nombre de Rol</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Opciones</th>
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
                

<!-- MODALS -->
<div class="modal fade" id="IdModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-muni">
                    <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Información del Roles</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmModal">
                        <input type="hidden" id="PERF_CODIGO" name="PERF_CODIGO">
                 
                        <div class="row">
                            <div class="col-lg-12 col-12 mb-2 mb-lg-0">
                                <label class="form-label" for="PERF_NOMBRE">Nombre perfil :</label>
                                <input type="text" class="form-control" id="PERF_NOMBRE" name="PERF_NOMBRE"  placeholder="Nombre perfil" required>
                            </div>
                        </div>

                        <div class="row">
                                <div class="col-md-12">                            
                                    <div class="mb-3 mt-2">
                                        <label class="form-label" for="PERF_NC_NOMBRE">Descripción Perfil :</label>
                                        <textarea class="form-control" rows="3" id="PERF_NC_NOMBRE" name="PERF_NC_NOMBRE"></textarea>
                                    </div>
                                </div>
                            </div>

                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-lg-4 col-6">
                                   <label class="form-label" for="PERF_ESTADO">Estado :</label>
                                    <select class="form-select" id="PERF_ESTADO" name="PERF_ESTADO" required>
                                        <option value="">-- Seleccione --</option>
                                        <option value="1">ACTIVO</option>
                                        <option value="0">INACTIVO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-soft-primary " id="btnSave">Guardar información</button>
                        <button type="button" class="btn btn-soft-danger " id="btnClear" onclick="LimpiarDatos('frmModal')">Limpiar</button>
                    </form>                                                  
                </div>
                <div class="modal-footer">                                                    
                    <button type="button" class="btn btn-soft-secondary " data-bs-dismiss="modal">Cerrar ventana</button>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="IdModalRoles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header bg-muni">
                    <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Asignación de opciones a roles</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 border rounded-2 p-2">
                            <div class="alert alert-warning border-0 p-1" role="alert">
                                <strong>Importante!</strong> Seleccione las siguientes leyendas para visualizar sus opciones de cada uno.
                            </div>
                            <div id="dataContenedorOpcion"></div>
                        </div>
                        <div class="col-md-6 border rounded-2 p-2 ">
                            <div class="alert alert-info border-0 p-1" role="alert">
                                <strong>Información!</strong> Debe marcar con un Check, para agregar al Perfil seleccionado.
                            </div>
                            <div id="dataContenedorSubOpcion">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                                                    
                <button type="button" class="btn btn-soft-secondary " data-bs-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>
     

<script>

   
</script>