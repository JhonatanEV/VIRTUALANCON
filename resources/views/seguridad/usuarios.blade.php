

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="row">
            <div class=" col-sm-12">
                <div class="card">
                <div class="card-header bg-soft-dark">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Lista de Usuarios</h4>                   
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
                                <th>Codigo</th>
                                <th>N° Documento</th>
                                <th>Nombres</th>
                                <th>Tipos usuario</th>
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
                <div class="modal-header bg-blue">
                    <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Información del Usuario</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmUsuario">
                        <input type="hidden" id="usua_codigo" name="usua_codigo">
                        <input type="hidden" id="pers_codigo" name="pers_codigo">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 mb-2 mb-lg-0">
                                    <label class="form-label mb-0" for="pers_tipodoc">Tipo de Documento</label>
                                    <select class="form-select" id="pers_tipodoc" name="pers_tipodoc" required>
                                        <option value="">-- Seleccione --</option>
                                        <option value="1">DNI</option>
                                        <option value="2">CARNET EXT.</option>
                                        <option value="3">PASAPORTE</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label mb-0" for="pers_documento">Número de Documento</label>
                                    <input type="text" class="form-control" id="pers_documento" name="pers_documento" placeholder="Número de Documento" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-1 mb-2">
                            <label class="form-label mb-0" for="pers_nombre">Nombre de Persona</label>
                            <input type="text" class="form-control" id="pers_nombre" name="pers_nombre" placeholder="Nombres" autocomplete="off" required>                            
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 mb-2 mb-2">
                                    <label class="form-label mb-0" for="perf_codigo">Perfil de Usuario</label>
                                    <select class="form-select" id="perf_codigo" name="perf_codigo" required>
                                        <option>-- Seleccione --</option>
                                        <option value="1">ADMINISTRADOR</option>
                                        <option value="3">CONTRIBUYENTE</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-6">
                                    <label class="form-label mb-0" for="pers_contr_codigo">Codigo contribuyente</label>
                                    <input type="text" class="form-control" id="pers_contr_codigo" name="pers_contr_codigo" placeholder="Codigo contribuyente" maxlength="10">
                                </div>

                                <div class="col-lg-6 col-6 mb-3">
                                   <label class="form-label mb-0" for="pers_correo">Correo</label>
                                    <input type="text" class="form-control" id="pers_correo" name="pers_correo" placeholder="Correo" required>
                                </div>
                                <div class="col-lg-6 col-6 mb-2">
                                   <label class="form-label mb-0" for="pers_celular">Celular</label>
                                    <input type="text" class="form-control" id="pers_celular" name="pers_celular" placeholder="Celular" required>
                                </div>
                                <div class="col-lg-6 col-6 mb-2">
                                   <label class="form-label mb-0" for="usua_username">Usuario</label>
                                    <input type="text" class="form-control" id="usua_username" name="usua_username" placeholder="Usuario" required>
                                </div>
                                <div class="col-lg-6 col-6 mb-2">
                                   <label class="form-label mb-0" for="usua_password">Contraseña</label>
                                    <input type="text" class="form-control" id="usua_password" name="usua_password" placeholder="Contraseña">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col-lg-6 col-6">
                                    <label class="form-label" for="usua_estado">Estado Usuario</label>
                                    <select class="form-select" id="usua_estado" name="usua_estado" required>
                                        <option value="">-- Seleccione --</option>
                                        <option value="1">ACTIVO</option>
                                        <option value="0">INACTIVO</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-soft-primary " id="btnSave">Guardar información</button>
                        <button type="button" class="btn btn-soft-danger " id="btnClear" onclick="LimpiarDatos('frmUsuario')">Limpiar</button>
                    </form>                                                  
                </div>
                <div class="modal-footer">                                                    
                    <button type="button" class="btn btn-soft-secondary " data-bs-dismiss="modal">Cerrar ventana</button>
                </div>
            </div>
        </div>
    </div>

<!-- Data para buscar Persona -->
<datalist id="listPersona">
</datalist>

<script>

   
</script>