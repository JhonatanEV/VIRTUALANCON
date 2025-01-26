$(document).ready(function() {
    listarUsuarios();
    listarPersona();
    LlenarComboPerfil();
})

function AbrirModal(){
    LimpiarDatos("frmUsuario");
    OpenModal("#IdModal");
}

function listarUsuarios(){

    $("#datatable").DataTable().destroy();

    let url = "seguridad/select-usuarios";
    fetchGet(url,function(data){
        var contenido = "";
        var elemento;
//                     <button class="btn btn-info btn-sm" onclick="accesosUsuario(${elemento.USUA_CODIGO},'${elemento.USUA_USERNAME}')"><i class="fas fa-clone"></i></i> Accesos</button>

        for (var j = 0; j < data.length; j++) {
            elemento = data[j];
            contenido +=
           `<tr>
                <td>${elemento.USUA_CODIGO}</td>
                <td>${elemento.PERS_DOCUMENTO}</td>
                <td>${elemento.USER_NOMBRE_COMPLETO}</td>
                <td>${elemento.PERF_NOMBRE}</td>
                <td><span class="badge badge-soft-${(elemento.USUA_ESTADO==1)? 'success':'danger' }">${elemento.USUA_ESTADO_TEXTO}</span></td>
                <td class="text-center">
                    <button class="btn btn-primary btn-sm" onclick="agregarArea(${elemento.USUA_CODIGO})"><i class="fas fa-clone"></i></i> Área</button>
                    <button class="btn btn-soft-warning btn-sm" onclick="EditarData(${elemento.USUA_CODIGO})"><i class="las la-pen font-16"></i></button>
                    <button class="btn btn-soft-danger btn-sm ${(elemento.USUA_ESTADO==1) ? '':'d-none' }" onclick="EliminarData(${elemento.USUA_CODIGO},0)"><i class="las la-trash-alt font-16"></i></button>
                    <button class="btn btn-soft-success btn-sm ${(elemento.USUA_ESTADO==1) ? 'd-none':'' }" onclick="EliminarData(${elemento.USUA_CODIGO},1)" title="Activar"><i class="fas fa-check-circle font-16"></i></button>

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

function EliminarData(USUA_CODIGO,USUA_ESTADO){
     let url = "seguridad/eliminarUsuario?USUA_CODIGO="+USUA_CODIGO+"&USUA_ESTADO="+USUA_ESTADO;
    fetchGet(url,function(data){
        showMessage(data.accion,data.smg,"Mensaje!");
        listarUsuarios();
    });
}

function EditarData(USUA_CODIGO){
    LimpiarDatos("frmUsuario");

    let url = "seguridad/select-usuarios?USUA_CODIGO="+USUA_CODIGO;
    fetchGet(url,function(data){
       // console.log(data);
       setValue("PERF_CODIGO",data[0].PERF_CODIGO);
       setValue("PERS_NOMBRE",data[0].PERS_APATERNO+' '+data[0].PERS_AMATERNO+' '+data[0].PERS_NOMBRE);
       setValue("USUA_CODIGO",data[0].USUA_CODIGO);
       setValue("USUA_USERNAME",data[0].USUA_USERNAME);
       setValue("USUA_PASSWORD",data[0].USUA_PASSWORD);
       setValue("PERS_CODIGO",data[0].PERS_CODIGO);
       setValue("USUA_ESTADO",data[0].USUA_ESTADO);

       OpenModal("#IdModal");
    });
}

function LlenarComboPerfil(){
    
    let url = "seguridad/select-roles";
    fetchGet(url,function(data){
        llenarCombo(data,"PERF_CODIGO","PERF_NOMBRE","PERF_CODIGO")
    });
}

$("#frmUsuario").submit(function(e) {
    e.preventDefault();
    
    var parametros = $(this).serialize();
    var data = new FormData(this);
    var form = $(this);
    

        $.ajax({
           type: 'POST',
           headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           url: urljs+'seguridad/guardar-usuario',
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
              listarUsuarios();
           },
           error:function(){
                showMessage("error",data.sms,"Mensaje!");
                $("#btnSave").html('Guardar información');
                $("#btnSave").removeClass("disabled");
           }
        });
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