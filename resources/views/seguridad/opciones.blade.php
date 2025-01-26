
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="row">
            <div class=" col-sm-12">
                <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Lista de Opciones del Sistema</h4>                   
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
                                <th>Sub Opcion</th>
                                <th>Icono</th>
                                <th>Ruta</th>
                                <th>Nombre Opción</th>
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
                    <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Información del Opciones</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmModal">
                        <input type="hidden" id="OPCI_CODIGO" name="OPCI_CODIGO">

                        <div class="form-group mb-1">
                            <div class="form-group mb-1">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="OPCI_TIPO">Tipo opción :</label>
                                        <select class="form-select" id="OPCI_TIPO" name="OPCI_TIPO" onchange="validaTipoOpcion(this.value);">
                                            <option value="">-- Seleccione --</option>
                                            <option value="1">Menu Categoria</option>
                                            <option value="2">Leyenda</option>
                                            <option value="3">Menu</option>
                                            <option value="4">Sub Menu</option>
                                            <option value="5">Objeto</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label" for="OPCI_SUB_CODIGO">Dentro de opción :</label>
                                        <select class="form-select" id="OPCI_SUB_CODIGO" name="OPCI_SUB_CODIGO">
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-1">
                            <div class="row">
                                <div class="col-lg-6 col-6 mb-2 mb-lg-0">
                                    <label class="form-label" for="OPCI_NOMBRE">Nombre opción :</label>
                                    <input type="text" class="form-control" id="OPCI_NOMBRE" name="OPCI_NOMBRE"  placeholder="Nombre opción" required>
                                </div>
                                <div class="col-lg-6 col-6">
                                    <label class="form-label" for="OPCI_SUB_NOMBRE">Sub nombre :</label>
                                    <input type="text" class="form-control" id="OPCI_SUB_NOMBRE" name="OPCI_SUB_NOMBRE" placeholder="Sub nombre">
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 col-6 mb-2 mb-lg-0">
                                    <label class="form-label" for="OPCI_ICON">Icono :</label>
                                    <input type="text" class="form-control" id="OPCI_ICON" name="OPCI_ICON" placeholder="Icono de menu" >
                                </div>
                                <div class="col-lg-6 col-6">
                                    <label class="form-label" for="OPCI_HREF">Ruta :</label>
                                    <input type="text" class="form-control" id="OPCI_HREF" name="OPCI_HREF" placeholder="Ruta de la opción" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="form-label" for="OPCI_ICON_NOTIFICA">Icon Notificación :</label>
                                    <input type="text" class="form-control" id="OPCI_ICON_NOTIFICA" name="OPCI_ICON_NOTIFICA" placeholder="Icon Notificación">
                                </div>
                                <div class="col-lg-4">
                                   <label class="form-label" for="OPCI_ORDER">N° Orden a mostrar :</label>
                                    <input type="number" class="form-control" id="OPCI_ORDER" name="OPCI_ORDER" placeholder="N° Orden">
                                </div>
                                <div class="col-lg-4">
                                   <label class="form-label" for="USUA_PASSWORD">Estado :</label>
                                    <select class="form-select" id="OPCI_ESTADO" name="OPCI_ESTADO" required>
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

<script>

   
</script>