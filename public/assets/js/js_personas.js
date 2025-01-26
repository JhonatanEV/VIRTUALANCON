$(document).ready(function() {
    soloNumeros("#PERS_DOCUMENTO");
    soloNumeros("#PERS_CELULAR");
    listarData();
})

function AbrirModal(){
    LimpiarDatos("frmModal");
    OpenModal("#IdModal");
}

function listarData(){

    $("#datatable").DataTable().destroy();

    let url = "seguridad/select-personas";
    fetchGet(url,function(data){
        var contenido = "";
        var elemento;
        var n=1;
        for (var j = 0; j < data.length; j++) {
            elemento = data[j];
            contenido +=
           `<tr>
                <td>${n}</td>
                <td>${elemento.PERS_DOCUMENTO}</td>
                <td>${elemento.PERS_NOMCOM}</td>
                <td>${elemento.PERS_FECNACI}</td>
                <td>${elemento.PERS_OCUPACION}</td>
                <td><span class="badge badge-soft-${(elemento.PERS_ESTADO==1)? 'success':'danger' }">${(elemento.PERS_ESTADO==1)? 'Activo':'Inactivo' }</span></td>
                <td class="text-center">
                    <button class="btn btn-soft-info btn-sm" onclick="Contactos(${elemento.PERS_CODIGO})" title="Contactos"><i class="fas fa-id-card-alt font-16"></i></i></button>
                    <button class="btn btn-soft-warning btn-sm" onclick="EditarData(${elemento.PERS_CODIGO})" title="Editar"><i class="las la-pen font-16"></i></button>
                    <button class="btn btn-soft-danger btn-sm ${(elemento.PERS_ESTADO==1) ? '':'d-none' }" onclick="EliminarData(${elemento.PERS_CODIGO},0)" title="Desactivar"><i class="las la-trash-alt font-16"></i></button>
                    <button class="btn btn-soft-success btn-sm ${(elemento.PERS_ESTADO==1) ? 'd-none':'' }" onclick="EliminarData(${elemento.PERS_CODIGO},1)" title="Activar"><i class="fas fa-check-circle font-16"></i></button>
                </td>
            </tr>`;
            n++;
        } 
        
        $("#dataContenedor").html(contenido);
        $("#datatable").DataTable({ordering: true});
    });

};

function EditarData(PERS_CODIGO){
    LimpiarDatos("frmModal");

    let url = "seguridad/select-personas?PERS_CODIGO="+PERS_CODIGO;
    fetchGet(url,function(data){

        setValue("PERS_CODIGO",data[0].PERS_CODIGO);
        setValue("PERS_TIPODOC",data[0].PERS_TIPODOC);
        setValue("PERS_DOCUMENTO",data[0].PERS_DOCUMENTO);
        setValue("PERS_APATERNO",data[0].PERS_APATERNO);
        setValue("PERS_AMATERNO",data[0].PERS_AMATERNO);
        setValue("PERS_NOMBRE",data[0].PERS_NOMBRE);
        setValue("PERS_SEXO",data[0].PERS_SEXO);
        setValue("PERS_FECNACI",data[0].PERS_FECNACI);
        setValue("PERS_DIRECCION",data[0].PERS_DIRECCION);
        setValue("PERS_OCUPACION",data[0].PERS_OCUPACION);

       OpenModal("#IdModal");
       
    });
}

function EliminarData(PERS_CODIGO,PERS_ESTADO){
     let url = "seguridad/eliminar-persona?PERS_CODIGO="+PERS_CODIGO+"&PERS_ESTADO="+PERS_ESTADO;
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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           type: 'POST',
           url: urljs+'seguridad/guardar-persona',
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


function Contactos(PERS_CODIGO){
    let url = "seguridad/select-contactos-individual?PERS_CODIGO="+PERS_CODIGO;
    fetchGet(url,function(data){
        var contenido = "";
        var elemento;
        var n=1;
        for (var j = 0; j < data.length; j++) {
            elemento = data[j];
            contenido +=
           `<tr>
                <td>${elemento.TIPO_D_NOMBRE}</td>
                <td>${elemento.CONTC_DATOS}</td>
            </tr>`;
            n++;
        } 
        
        $("#dataContacto").html(contenido);
    });
    OpenModal("#IdModalContacto");
}