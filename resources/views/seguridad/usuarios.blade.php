

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
                <div class="modal-header bg-muni">
                    <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Información del Usuario</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmUsuario">
                        <input type="hidden" id="USUA_CODIGO" name="USUA_CODIGO">
                        <input type="hidden" id="PERS_CODIGO" name="PERS_CODIGO">

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Información!</strong> Antes de crear un usuario deberá de crear la persona en la opción <strong><a href="/seguridad/personas" title="Crear nuevo persona">Administrar/personas</a></strong>.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                        </div>

                        <div class="form-group mb-1">
                            <label class="form-label" for="PERS_NOMBRE">Buscar: Nombre de Persona</label>
                            <input type="text" list="listPersona" class="form-control" id="PERS_NOMBRE" name="PERS_NOMBRE" placeholder="Nombres" autocomplete="off" required>                            
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4 mb-2 mb-lg-0">
                                    <label class="form-label" for="PERF_CODIGO">Perfil de Usuario</label>
                                    <select class="form-select" id="PERF_CODIGO" name="PERF_CODIGO" required>
                                        <option>-- Seleccione --</option>

                                    </select>
                                </div>
                                <div class="col-lg-4 col-6">
                                   <label class="form-label" for="USUA_USERNAME">Usuario</label>
                                    <input type="text" class="form-control" id="USUA_USERNAME" name="USUA_USERNAME" placeholder="Usuario" required>
                                </div>
                                <div class="col-lg-4 col-6">
                                   <label class="form-label" for="USUA_PASSWORD">Contraseña</label>
                                    <input type="text" class="form-control" id="USUA_PASSWORD" name="USUA_PASSWORD" placeholder="Contraseña" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row mb-4">
                                <div class="col-lg-4 col-6">
                                    <label class="form-label" for="pro-end-date">Estado Usuario</label>
                                    <select class="form-select" id="USUA_ESTADO" name="USUA_ESTADO" required>
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