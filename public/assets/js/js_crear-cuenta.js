$(document).ready(function(){
    
});


$("#pers_tipodoc").change(function(){
    var tipo_doc = $("#pers_tipodoc").val();
    $("#btn-validar-doc").show();
    $("#pers_nombre").attr("readonly",true);
    $("#pers_direccion").attr("readonly",true);

    $("#pers_documento").val('');
    $("#pers_nombre").val('');
    $("#pers_direccion").val('');

    if(tipo_doc==1){
        $("#pers_documento").attr("maxlength",8);
    }else if(tipo_doc==3){
        $("#pers_documento").attr("maxlength",12);
        $("#pers_nombre").attr("readonly",false);
        $("#pers_direccion").attr("readonly",false);
        $("#btn-validar-doc").hide();
    }
});

function valid_campo(input) {
    if($(input).val()=='') {
        $(input).addClass('is-invalid');
        $(input).removeClass('is-valid');
        return false;
    }else{
        $(input).removeClass('is-invalid');
        $(input).addClass('is-valid');
    }
}

function validadatos(){
    var tipo_doc = $("#pers_tipodoc").val();
    var num_doc = $("#pers_documento").val();

    //$("#txtvalidadni").val(0); 

    if(tipo_doc==''){
        $("#pers_documento").val('');
        $("#pers_tipodoc").addClass('is-invalid');
        return;
    }else{
        $("#pers_tipodoc").removeClass('is-invalid');
    }
}


 /*Validar campos cambio de tab*/
 $("#pers_tipodoc").change(function(){
    let valor = $("#pers_tipodoc").val();
    if(valor==1){
        $("#hideapellidos").show();
        setValue("pers_tipodoc",1);
        setValue("pers_documento","");
        setValue("pers_nombre","");
        $("#pers_documento").attr("maxlength",8);
    }else if(valor==2){
        $("#hideapellidos").hide();
        setValue("pers_tipodoc",2);
        setValue("pers_documento","");
        setValue("pers_nombre","");
        $("#pers_documento").attr("maxlength",11);
    }
});

let valida_documento = false;
let vlaida_codigo = false;

$("#btn-validar-doc").click(function(){
    let TIPO  = getValue("pers_tipodoc");
    let DOCUMENTO  = getValue("pers_documento");

    if(TIPO==1){
        TIPO ='DNI'
    }else if(TIPO==2){
        TIPO='RUC';
    }
    
    if(DOCUMENTO.length>0){

        let param = '?TIPO='+TIPO+'&DOCUMENTO='+DOCUMENTO;
        envioAjaxdata("buscar-contribuyente"+param,[],function(res){
            if(res.status){
                if(res.nombre!=''){
                    setValue('pers_nombre',res.nombre);
                    setValue('pers_direccion',res.direccion);

                    $("#pers_documento").attr("readonly",true);
                    $("#pers_nombre").attr("readonly",true);
                    $("#pers_direccion").attr("readonly",true);
                    $(".floating-text").show();

                    valida_documento = true;
                }else{
                    $("#pers_documento").val('');
                    $("#pers_nombre").attr("readonly",false);
                    $("#pers_direccion").attr("readonly",false);

                    showMessageAlert("Mensaje","No se encontro datos del contribuyente","warning",function(e){});

                    valida_documento = false;
                }
            }else if(!res.status){

                $("#pers_documento").val('');
                showMessageAlert("Mensaje",res.mensaje,"warning",function(e){});

                valida_documento = false;
            }else{
                $("#pers_nombre").attr("readonly",false);
                $("#pers_direccion").attr("readonly",false);
            }
        });
    }else{
        $("#pers_documento").focus();
    }
    
})

document.getElementById('pers_correo').addEventListener('input', function() {
    campo = event.target;
        
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    //Se muestra un texto a modo de ejemplo, luego va a ser un icono
    if (emailRegex.test(campo.value)) {
        $("#pers_correo").removeClass("is-invalid");
      $("#pers_correo").addClass("is-valid");
    } else {
      
      $("#pers_correo").removeClass("is-valid");
      $("#pers_correo").addClass("is-invalid");
    }
});


function valida_clave(){
    var rango1 = $("#password").val().length;
    var rango2 = $("#conf_password").val().length;

    var pass1 = $("#password").val(); //.length
    var pass2 = $("#conf_password").val(); //.length
    
        if(rango2>0){
            if (pass1==pass2) {
                $("#smserror").html("<p style='color:green'>Correcto!</p>").show();
                $("#conf_password").removeClass('is-invalid');
                $("#conf_password").addClass('is-valid');
                return false;
            }else{
                $("#conf_password").addClass('is-invalid');
                $("#conf_password").removeClass('is-valid');
                $("#smserror").html("<p style='color:red'>Contraseña no coincide!!</p>").show();
            }
        }else{
            $("#smserror").html("<p style='color:red'>Contraseña no coincide!!</p>").show();
            $("#conf_password").addClass('is-invalid');
            $("#conf_password").removeClass('is-valid');
        }
    
}


$("#btn-validar-contribuyente").click(function(){
    var codigo = getValue("codigo");
    let documento = getValue("pers_documento");

    if(codigo==''){
        showMessageAlert("Mensaje",'Ingrese el codigo de contribuyente',"warning",function(e){});
        return false;
    }

    let data = {
        codigo:codigo,
        documento:documento        
    }
    fetchPost('valida-contribuyente', data, function(res){
      if(res.status){
        $("#btn-editar").removeClass('d-none');
        $("#btn-validar-contribuyente").addClass('d-none');
        $("#codigo").addClass('disabled');
        setValue("contribuyente",res.nombre);
        // showMessageAlert("Mensaje",`El codigo ${codigo} de contribuyente esta vinculado al N° documento ingresado`,"success",function(e){});

        valida_codigo = true;

      }else{
        setValue("codigo","");
        setValue("contribuyente","");
        showMessageAlert("Mensaje",`El codigo ${codigo} de contribuyente no esta vinculado al N° documento ingresado`,"warning",function(res){
            $("#codigo").focus();
        });

        valida_codigo = false;
      }
    },loading=true);
});

$("#frmCuenta").submit(function(e) {
    e.preventDefault();

    if(valida_documento==false){
        showMessageAlert("Mensaje","Debe validar el documento del contribuyente","warning",function(e){});
        return false;
    }

    if(valida_codigo==false){
        showMessageAlert("Mensaje","Debe validar el codigo del contribuyente","warning",function(e){});
        return false;
    }


    var parametros = $(this).serialize();
    var data = new FormData(this);

    envioAjaxdata("guardar-cuenta",data,function(res){
        if(res.status){
            showMessageAlert("Mensaje",res.mensaje,'success',function(e){});
            setTimeout(function(){
                window.location.href = 'login';
            }, 2000);

        }else{

            showMessageAlert("Mensaje",res.mensaje,'info',function(e){});
        }

        
        $("#frmCuenta")[0].reset();
    });
});