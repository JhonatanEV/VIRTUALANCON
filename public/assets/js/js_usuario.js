$(document).ready(function() {
    listarUsuarios();
    LlenarComboPerfil();
})

function AbrirModal(){
    LimpiarDatos("frmUsuario");
    OpenModal("#IdModal");
}

function listarUsuarios(){

    $("#datatable").DataTable().destroy();
    let url = "seguridad/usuarios/listar";
    fetchGet(url,function(data){
        var contenido = "";
        var elemento;        
        let user = data.data;
        for (var j = 0; j < user.length; j++) {
            elemento = user[j];
            contenido +=
           `<tr>
                <td>${elemento.usua_codigo}</td>
                <td>${elemento.pers_documento}</td>
                <td>${elemento.pers_nombre_completo}</td>
                <td>${elemento.perf_nombre}</td>
                <td><span class="badge badge-soft-${(elemento.usua_estado==1)? 'success':'danger' }">${ (elemento.usua_estado==1)? 'Activo':'Inactivo'}</span></td>
                <td class="text-center">
                    <button class="btn btn-soft-warning btn-sm" data-elemento='${JSON.stringify(elemento)}' onclick="EditarData(this)"><i class="las la-pen font-16"></i></button>
                    <button class="btn btn-soft-danger btn-sm ${(elemento.usua_estado==1) ? '':'d-none' }" onclick="EliminarData(${elemento.usua_codigo},0)"><i class="las la-trash-alt font-16"></i></button>
                    <button class="btn btn-soft-success btn-sm ${(elemento.usua_estado==1) ? 'd-none':'' }" onclick="EliminarData(${elemento.usua_codigo},1)" title="Activar"><i class="fas fa-check-circle font-16"></i></button>

                </td>
            </tr>`;
        } 
        
        $("#dataContenedor").html(contenido);
        $("#datatable").DataTable({ordering: false});
    });
};

function listarPersona(){

    let url = "seguridad/select-personas";
    fetchGet(url,function(data){
        var contenido = "";
        var elemento;
        for (var j = 0; j < data.length; j++) {
            elemento = data[j];
            contenido +=`<option data-value="${elemento.PERS_CODIGO}" value="${elemento.PERS_APATERNO} ${elemento.PERS_AMATERNO} ${elemento.PERS_NOMBRE}"></option>`;
        } 
        $("#listPersona").html(contenido);
    });
};

function EliminarData(usua_codigo,usua_estado){
    let url = "seguridad/usuarios/actualizar-estado";
    let frm = {
        usua_codigo: usua_codigo,
        usua_estado: usua_estado
    }
    fetchPost(url, frm, function(res){
        listarUsuarios();
    },true);
     
}

function EditarData(btn){
        LimpiarDatos("frmUsuario");
        let data = JSON.parse($(btn).attr("data-elemento"));
       // console.log(data);
       setValue("pers_codigo",data.pers_codigo);
       setValue("perf_codigo",data.perf_codigo);
       setValue("pers_nombre",data.pers_nombre);
       setValue("pers_tipodoc",data.pers_tipodoc);
       setValue("pers_documento",data.pers_documento);
       setValue("usua_codigo",data.usua_codigo);
       setValue("usua_username",data.usua_username);
       setValue("pers_contr_codigo",data.pers_contr_codigo);
       setValue("pers_correo",data.pers_correo);
       setValue("pers_celular",data.pers_celular);
       setValue("usua_password",'');
       setValue("usua_estado",data.usua_estado);

       OpenModal("#IdModal");
}

function LlenarComboPerfil(){
    
    let url = "seguridad/select-roles";
    fetchGet(url,function(data){
        llenarCombo(data.data,"perf_codigo","perf_nombre","perf_codigo")
    });
}

$("#frmUsuario").submit(function(e) {
    e.preventDefault();
    
    // var data = new FormData(this);
    var url = "seguridad/usuarios/guardar";
    let dataForm = {
        pers_codigo: getValue("pers_codigo"),
        perf_codigo: getValue("perf_codigo"),
        pers_nombre: getValue("pers_nombre"),
        pers_tipodoc: getValue("pers_tipodoc"),
        pers_documento: getValue("pers_documento"),
        usua_codigo: getValue("usua_codigo"),
        usua_username: getValue("usua_username"),
        pers_contr_codigo: getValue("pers_contr_codigo"),
        usua_password: getValue("usua_password"),
        usua_estado: getValue("usua_estado"),
        pers_correo: getValue("pers_correo"),
        pers_celular: getValue("pers_celular")
    }
    fetchPost(url, dataForm, function(res){
        listarUsuarios();
        CloseModal("#IdModal");
    },true);

    // var parametros = $(this).serialize();
    // var data = new FormData(this);
    // var form = $(this);
    

    //     $.ajax({
    //        type: 'POST',
    //        headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //        url: urljs+'seguridad/usaurios/guardar',
    //        data: data,
    //        dataType: 'json', 
    //        encode: true,
    //        cache: false,
    //         processData: false,
    //         contentType: false,
    //        beforeSend:function(){
    //         $("#btnSave").addClass("disabled");
    //         $("#btnSave").html('Creando...');
    //        },
    //        success: function(data){
    //           $("#btnSave").html('Guardar información');
    //           $("#btnSave").removeClass("disabled");
    //           $(form)[0].reset();
    //           showMessage(data.accion,data.smg,"Mensaje!")
    //           CloseModal("#IdModal");
    //           listarUsuarios();
    //        },
    //        error:function(){
    //             showMessage("error",data.sms,"Mensaje!");
    //             $("#btnSave").html('Guardar información');
    //             $("#btnSave").removeClass("disabled");
    //        }
    //     });
}); 

// $("#PERS_NOMBRE").blur('input', function () {
//     var dataImputBefore = $("#PERS_NOMBRE").val();
//     $("#PERS_NOMBRE").prop('data-value',dataImputBefore);
//     var elementOption = $("#listPersona option[value='"+dataImputBefore+"']")
    
//     $("#PERS_NOMBRE").val(elementOption.text());
// });

//"change keyup input blur"
$("#PERS_NOMBRE").on("keyup", function() {
    var value = $(this).val();
    var codigo = $('#listPersona [value="' + value + '"]').data('value');
    $("#btnSave").prop("disabled", true);
    if(codigo){
        $(this).removeClass('is-invalid'); 
        $(this).addClass('is-valid');
        $("#btnSave").prop("disabled", false);
        $("#PERS_CODIGO").val(codigo);
        buscarPersona(codigo);
    }else{
        $("#PERS_CODIGO").val('');
        $("#btnSave").prop("disabled", true);
        $(this).removeClass('is-valid');
        $(this).addClass('is-invalid');
    }
    
    //console.log(codigo);
});


function buscarPersona(PERS_CODIGO){
    let url = "seguridad/select-usuarios?PERS_CODIGO="+PERS_CODIGO;
    fetchGet(url,function(data){
        if(data.length>0){
            showMessage("warning","La persona seleccionada ya esta registrado como Usuario!","Mensaje!");
            $("#PERS_NOMBRE").val('');
            $("#PERS_NOMBRE").focus();
        }
        //console.log(data.length);
    });
}

function agregarArea(USUA_CODIGO){
   
    let ruta = "seguridad/modal-area?USUA_CODIGO="+USUA_CODIGO;
    showPopup(ruta,"modalArea",className="modal-lg","Areas para el usuario");
}

function accesosUsuario(USUA_CODIGO,USER){
    let ruta = "seguridad/accesos-usuario?USUA_CODIGO="+USUA_CODIGO;
    showPopup(ruta,"modalAccesos",className="","Accesos del Usuario: "+USER);
}