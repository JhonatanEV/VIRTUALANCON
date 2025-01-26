$(document).ready(function() {

    listarData();
})

function AbrirModal(){
    LimpiarDatos("frmModal");
    OpenModal("#IdModal");
}

function listarData(){

    $("#datatable").DataTable().destroy();

    let url = "seguridad/select-roles";
    fetchGet(url,function(response){
        var contenido = "";
        var elemento;
        var n=1;
        let data = response.data;
        for (var j = 0; j < data.length; j++) {
            elemento = data[j];
            contenido +=
           `<tr>
                <td>${n}</td>
                <td>${elemento.perf_nombre}</td>
                <td>${elemento.perf_nc_nombre}</td>
                <td><span class="badge badge-soft-${(elemento.perf_estado==1)? 'success':'danger' }">${(elemento.perf_estado==1)? 'Activo':'Inactivo' }</span></td>
                <td class="text-center">
                    <button class="btn btn-soft-info btn-sm" onclick="AsignarOpciones(${elemento.perf_codigo},1)" title="Asignar opciones"><i class="fas fa-list-ol font-16"></i></button>
                    <button class="btn btn-soft-warning btn-sm" onclick="EditarData(${elemento.perf_codigo})" title="Editar"><i class="las la-pen font-16"></i></button>
                    <button class="btn btn-soft-danger btn-sm ${(elemento.perf_estado==1) ? '':'d-none' }" onclick="EliminarData(${elemento.perf_codigo},0)" title="Desactivar"><i class="las la-trash-alt font-16"></i></button>
                    <button class="btn btn-soft-success btn-sm ${(elemento.perf_estado==1) ? 'd-none':'' }" onclick="EliminarData(${elemento.perf_codigo},1)" title="Activar"><i class="fas fa-check-circle font-16"></i></button>
                </td>
            </tr>`;
            n++;
        } 
        
        $("#dataContenedor").html(contenido);
        $("#datatable").DataTable({ordering: true});
    });

};

function EditarData(PERF_CODIGO){
    LimpiarDatos("frmModal");

    let url = "seguridad/select-roles?PERF_CODIGO="+PERF_CODIGO;
    fetchGet(url,function(data){

       setValue("PERF_CODIGO",data[0].PERF_CODIGO);
       setValue("PERF_NOMBRE",data[0].PERF_NOMBRE);
       setValue("PERF_NC_NOMBRE",data[0].PERF_NC_NOMBRE);
       setValue("PERF_ESTADO",data[0].PERF_ESTADO);
       
       OpenModal("#IdModal");
       
    });
}

function EliminarData(PERF_CODIGO,PERF_ESTADO){
     let url = "seguridad/eliminar-rol?PERF_CODIGO="+PERF_CODIGO+"&PERF_ESTADO="+PERF_ESTADO;
    fetchGet(url,function(data){
        showMessage(data.accion,data.smg,"Mensaje!");
        listarData();
    });
}


$("#frmModal").submit(function(e) {
    e.preventDefault();
    
    var parametros = $(this).serialize();
    var data = new FormData(this);
    var form = $(this);

        $.ajax({
           type: 'POST',
           headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           url: urljs+'seguridad/grabar-roles',
           data: data,
           dataType: 'json', 
           encode: true,
           cache: false,
            processData: false,
            contentType: false,
           beforeSend:function(){
            $("#btnSave").addClass("disabled");
            $("#btnSave").html('Creando...');
           },
           success: function(data){
              $("#btnSave").html('Guardar información');
              $("#btnSave").removeClass("disabled");
              $(form)[0].reset();
              showMessage(data.accion,data.smg,"Mensaje!")
              CloseModal("#IdModal");
              listarData();
           },
           error:function(){
                showMessage("error",data.sms,"Mensaje!");
                $("#btnSave").html('Guardar información');
                $("#btnSave").removeClass("disabled");
           }
        });
});

function AsignarOpciones(PERF_CODIGO,OPCI_TIPO){

    $("#dataContenedorSubOpcion").html('');

    let url = "seguridad/select-leyendas?PERF_CODIGO="+PERF_CODIGO+"&OPCI_TIPO="+OPCI_TIPO;
    fetchGet(url,function(data){
        var contenido = "";
        var elemento;
        var n=1;
        for (var j = 0; j < data.length; j++) {
            elemento = data[j];
            contenido +=
           ` <details class="mb-1" onclick="getValorTr(${elemento.OPCI_CODIGO},${PERF_CODIGO})">
                <summary class="summary-${elemento.OPCI_CODIGO}"> 
                        <input type="checkbox" ${elemento.MARCA==1 ? 'checked' :'' } onclick="grabarPermiso(${elemento.OPCI_CODIGO},${PERF_CODIGO},this.checked);"/>
                        <span>${elemento.OPCI_NOMBRE}</span>
                        <span class="badge badge-soft-${elemento.OPCI_ESTADO==1 ? 'success' :'danger' } " style="float:right;">${elemento.OPCI_ESTADO==1 ? '&#x2713;' :'&#10006;' }</span>
                </summary>
            </details>
           `;
            n++;
        } 

        $("#dataContenedorOpcion").html(contenido);
        
        
        OpenModal("#IdModalRoles");
    });
}

function getValorTr(OPCI_CODIGO,PERF_CODIGO){
   
    $('details summary').removeClass('selected');
    $('.summary-'+OPCI_CODIGO).addClass('selected');
    BuscarSubOpciones(OPCI_CODIGO,PERF_CODIGO);
}
function BuscarSubOpciones(OPCI_CODIGO,PERF_CODIGO){

    //$("#tableContenedorSubOpcion").DataTable().destroy();
    let url = "seguridad/select-sub-leyendas?OPCI_CODIGO="+OPCI_CODIGO+"&PERF_CODIGO="+PERF_CODIGO;
    fetchGetHtml(url,function(data){
        $("#dataContenedorSubOpcion").html(data);
       
    });
}

function grabarPermiso(OPCI_CODIGO,PERF_CODIGO,CHECKED){
    CHECKED = getValueChecked(CHECKED);
   
   
    let url = "seguridad/grabar-opcion-roles?OPCI_CODIGO="+OPCI_CODIGO+"&PERF_CODIGO="+PERF_CODIGO+"&CHECKED="+CHECKED;
    fetchGet(url,function(data){
        showMessage(data.accion,data.smg, "Alerta!");
    });
}
