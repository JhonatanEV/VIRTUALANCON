$(document).ready(function() {

    listarData();
 
    LlenarComboPerfil();   
})

function AbrirModal(){
    LimpiarDatos("frmModal");
    OpenModal("#IdModal");
}

function listarData(){
    $("#dataContenedor").html("");
    $("#datatable").DataTable().destroy();

    let url = "seguridad/select-opciones";
    fetchGet(url,function(data){
        var contenido = "";
        var elemento;
        
        for (var j = 0; j < data.length; j++) {
            elemento = data[j];
            contenido +=
           `<tr>
                <td>${elemento.OPCI_CODIGO}</td>
                <td>${elemento.OPCI_SUB_NOMBRES}</td>
                <td>${elemento.OPCI_ICON}</td>
                <td>${elemento.OPCI_HREF}</td>
                <td>${elemento.OPCI_NOMBRE}</td>
                <td><span class="badge badge-soft-${(elemento.OPCI_ESTADO==1)? 'success':'danger' }">${elemento.OPCI_ESTADO_TEXTO}</span></td>
                <td class="text-center">
                    <button class="btn btn-soft-warning btn-sm" onclick="EditarData(${elemento.OPCI_CODIGO})" title="Editar"><i class="las la-pen font-16"></i></button>
                    <button class="btn btn-soft-danger btn-sm ${(elemento.OPCI_ESTADO==1) ? '':'d-none' }" onclick="EliminarData(${elemento.OPCI_CODIGO},0)" title="Desactivar"><i class="las la-trash-alt font-16"></i></button>
                    <button class="btn btn-soft-success btn-sm ${(elemento.OPCI_ESTADO==1) ? 'd-none':'' }" onclick="EliminarData(${elemento.OPCI_CODIGO},1)" title="Activar"><i class="fas fa-check-circle font-16"></i></button>
                </td>
            </tr>`;
        } 
        
        $("#dataContenedor").html(contenido);
        $("#datatable").DataTable({ordering: true});
    });

    buscarEnTabla("#TextFiltrar","#table");
    $("#btnListar").prop('disabled',false); 
};

function EditarData(OPCI_CODIGO){
    LimpiarDatos("frmModal");

    let url = "seguridad/editar-opcion?OPCI_CODIGO="+OPCI_CODIGO;
    fetchGet(url,function(data){
       validaTipoOpcion(data[0].OPCI_TIPO,data[0].OPCI_SUB_CODIGO);

       setValue("OPCI_CODIGO",data[0].OPCI_CODIGO);
       setValue("OPCI_NOMBRE",data[0].OPCI_NOMBRE);
       setValue("OPCI_SUB_NOMBRE",data[0].OPCI_SUB_NOMBRE);
       setValue("OPCI_ICON",data[0].OPCI_ICON);
       setValue("OPCI_HREF",data[0].OPCI_HREF);
       setValue("OPCI_ICON_NOTIFICA",data[0].OPCI_ICON_NOTIFICA);
       setValue("OPCI_ORDER",data[0].OPCI_ORDER);
       setValue("OPCI_SUB_CODIGO",data[0].OPCI_SUB_CODIGO);
       setValue("OPCI_ESTADO",data[0].OPCI_ESTADO);
       setValue("OPCI_TIPO",data[0].OPCI_TIPO);
       
       OpenModal("#IdModal");
       
    });
}

function EliminarData(OPCI_CODIGO,OPCI_ESTADO){
     let url = "seguridad/eliminar-opcion?OPCI_CODIGO="+OPCI_CODIGO+"&OPCI_ESTADO="+OPCI_ESTADO;
    fetchGet(url,function(data){
        showMessage(data.accion,data.smg,"Mensaje!");
        listarData();
    });
}

function LlenarComboPerfil(OPCI_TIPO="",DEFAULT=""){
    
    let url = "seguridad/select-menu-opciones?OPCI_TIPO="+OPCI_TIPO;
    fetchGet(url,function(data){
        llenarCombo(data,"OPCI_SUB_CODIGO","OPCI_NOMBRE","OPCI_CODIGO");
        setValue("OPCI_SUB_CODIGO",DEFAULT);
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
           url: urljs+'seguridad/guardar-opcion',
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

function validaTipoOpcion(valor,valCombo){

    if(valor>0){
        if(valor==1){
            
           /* $("#OPCI_SUB_CODIGO").prop("disabled",true);
            $("#OPCI_ICON").prop("disabled",true);
            $("#OPCI_HREF").prop("disabled",true);
            $("#OPCI_ICON_NOTIFICA").prop("disabled",true);

            $("#OPCI_SUB_NOMBRE").prop("disabled",false);*/
        }else if(valor==2){
           /* $("#OPCI_SUB_CODIGO").prop("disabled",false);
            $("#OPCI_ICON").prop("disabled",false);
            $("#OPCI_HREF").prop("disabled",false);
            $("#OPCI_ICON_NOTIFICA").prop("disabled",false);

            $("#OPCI_SUB_NOMBRE").prop("disabled",true);*/
            LlenarComboPerfil(valor,valCombo);
        }else if(valor==3){
           /* $("#OPCI_SUB_CODIGO").prop("disabled",false);
            $("#OPCI_ICON").prop("disabled",false);
            $("#OPCI_HREF").prop("disabled",false);
            $("#OPCI_ICON_NOTIFICA").prop("disabled",false);
            $("#OPCI_SUB_NOMBRE").prop("disabled",false);

            $("#OPCI_ICON_NOTIFICA").prop("disabled",true);
            $("#OPCI_ICON").prop("disabled",true);
            $("#OPCI_SUB_NOMBRE").prop("disabled",true);*/

            LlenarComboPerfil(valor,valCombo);
        }else if(valor==4){
            $("#OPCI_ICON").prop("disabled",false);
            LlenarComboPerfil(valor,valCombo);
        }else if(valor==5){
            
            $("#OPCI_SUB_CODIGO").prop("requered",true);
            LlenarComboPerfil();
        }


    }
}