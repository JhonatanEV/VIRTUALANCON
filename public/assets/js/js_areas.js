$(document).ready(function() {

    listarData();
    LlenarComboGerencia();
})

function AbrirModal(){
    LimpiarDatos("frmModal");
    OpenModal("#IdModal");
}

function listarData(){

    $("#datatable").DataTable().destroy();

    let url = "areas/select-areas";
    fetchGet(url,function(data){
        var contenido = "";
        var elemento;

        for (var j = 0; j < data.length; j++) {
            elemento = data[j];
            contenido +=
           `<tr>
                <td>${elemento.AREA_CODIGO}</td>
                <td class="text-center">
                    <button class="btn btn-soft-warning btn-sm" onclick="EditarData(${elemento.AREA_CODIGO})" title="Editar"><i class="las la-pen font-16"></i></button>
                    <button class="btn btn-soft-danger btn-sm ${(elemento.AREA_ESTADO==1) ? '':'d-none' }" onclick="EliminarData(${elemento.AREA_CODIGO},0)" title="Desactivar"><i class="las la-trash-alt font-16"></i></button>
                    <button class="btn btn-soft-success btn-sm ${(elemento.AREA_ESTADO==1) ? 'd-none':'' }" onclick="EliminarData(${elemento.AREA_CODIGO},1)" title="Activar"><i class="fas fa-check-circle font-16"></i></button>
                </td>
                <td>${elemento.AREA_NOMBRE}</td>
                <td>${elemento.AREA_ABREV}</td>
                <td><span class="badge badge-soft-${(elemento.AREA_ESTADO==1)? 'success':'danger' }">${(elemento.AREA_ESTADO==1)? 'Activo':'Inactivo'}</span></td>
            </tr>`;
        } 
        
        $("#dataContenedor").html(contenido);
        $("#datatable").DataTable({ordering: true});
    });

    buscarEnTabla("#TextFiltrar","#table");
    $("#btnListar").prop('disabled',false); 
};

function EditarData(AREA_CODIGO){
    LimpiarDatos("frmModal");

    let url = "areas/select-areas?AREA_CODIGO="+AREA_CODIGO;
    fetchGet(url,function(data){
        console.log(data[0].AREA_ABREV);

       setValue("AREA_CODIGO",data[0].AREA_CODIGO);
       setValue("AREA_TIPO",data[0].AREA_TIPO);
       setValue("AREA_SUB_CODIGO",data[0].AREA_SUB_CODIGO);
       setValue("AREA_NOMBRE",data[0].AREA_NOMBRE);
       setValue("AREA_ABREV",data[0].AREA_ABREV);
       setValue("AREA_ORDEN",data[0].AREA_ORDEN);
       setValue("AREA_ESTADO",data[0].AREA_ESTADO);
       OpenModal("#IdModal");
       
    });
}

function EliminarData(AREA_CODIGO,AREA_ESTADO){
     let url = "areas/eliminar-area?AREA_CODIGO="+AREA_CODIGO+"&AREA_ESTADO="+AREA_ESTADO;
    fetchGet(url,function(data){
        showMessage(data.accion,data.smg,"Mensaje!");
        listarData();
    });
}

function LlenarComboGerencia(){

    let url = "areas/select-areas?AREA_TIPO=1";
    fetchGet(url,function(data){
        llenarCombo(data,"AREA_SUB_CODIGO","AREA_NOMBRE","AREA_CODIGO");
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
           url: urljs+'areas/guardar-areas',
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
