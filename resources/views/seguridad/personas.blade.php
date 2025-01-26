

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="row">
            <div class=" col-sm-12">
                <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Lista de Personas del Sistema</h4>                   
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
                                <th>N° Documento</th>
                                <th>Nombres</th>
                                <th>Fec. Nacimiento</th>
                                <th>Ocupación</th>
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
                    <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Información de Persona</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmModal">
                        <input type="hidden" id="PERS_CODIGO" name="PERS_CODIGO">

                        <div class="form-group mb-1">
                            <div class="row">
                            <div class="col-lg-6">
                                <label class="form-label" for="PERS_TIPODOC">TIPO DOC :</label>
                                    <select name="PERS_TIPODOC" id="PERS_TIPODOC" class="form-select">
                                        <option value="">-- Seleccione --</option>
                                        <option value="1">DNI</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                <label class="form-label" for="PERS_DOCUMENTO">N° Documento :</label>
                                <input type="text" maxlength="8" class="form-control" id="PERS_DOCUMENTO" name="PERS_DOCUMENTO"  placeholder="N° Documento" required>
                                </div>
                            </div>  
                        </div>

                        <div class="form-group mb-1">
                            <label class="form-label" for="PERS_NOMBRE">Nombres :</label>
                            <input type="text" class="form-control" id="PERS_NOMBRE" name="PERS_NOMBRE" aria-describedby="emailHelp" placeholder="Nombres" required>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 col-6 mb-2 mb-lg-0">
                                    <label class="form-label" for="PERS_APATERNO">Apellido Paterno</label>
                                    <input type="text" class="form-control" id="PERS_APATERNO" name="PERS_APATERNO" placeholder="Apellido Paterno" required>
                                </div>
                                <div class="col-lg-6 col-6">
                                    <label class="form-label" for="PERS_AMATERNO">Apellido Materno</label>
                                    <input type="text" class="form-control" id="PERS_AMATERNO" name="PERS_AMATERNO" placeholder="Apellido Materno" required>
                                </div>
                            </div>
                        </div>
                   
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 mb-2 mb-lg-0 required">
                                    <label class="form-label mt-2" for="PERS_SEXO">Sexo :</label>
                                    <select class="form-select" id="PERS_SEXO" name="PERS_SEXO" required>
                                        <option value="">--Seleccione--</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                        
                                    </select>
                                </div>
                                <div class="col-lg-6 ">
                                    <label class="form-label mt-2" for="PERS_FECNACI">Fecha Nacimento :</label>
                                    <input type="date" class="form-control" id="PERS_FECNACI" name="PERS_FECNACI">
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-group ">

                            <div class="row ">
                                <div class="col-lg-6">
                                    <label class="form-label mt-2" for="PERS_DIRECCION">Dirección actual :</label>
                                    <textarea class="form-control" rows="1" id="PERS_DIRECCION" name="PERS_DIRECCION" placeholder="Dirección.."></textarea>
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label class="form-label mt-2" for="PERS_OCUPACION">Ocupación :</label>
                                    <input type="text" class="form-control" id="PERS_OCUPACION" name="PERS_OCUPACION" placeholder="Ocupación">
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


<div class="modal fade" id="IdModalContacto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-muni">
                <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Contactos</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Tipo</td>
                            <td>Datos</td>
                        </tr>
                    </thead>
                    <tbody id="dataContacto">

                    </tbody>
                </table>                                                
            </div>
            <div class="modal-footer">                                                    
                <button type="button" class="btn btn-soft-secondary " data-bs-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>

<script>

   
</script>