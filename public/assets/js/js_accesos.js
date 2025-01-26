function selectedLi(id){
    $.ajax({
             type: "POST",
             url: urljs+'SeguridadController/consulta_opcion_id',
             data:{id:id},
             dataType: 'json', 
             beforeSend:function(){
             },
             success: function(response){
                response.id_opcion
                response.sup_id_opcion
                $("#txticon").val(response.icon);
                $("#txtruta").val(response.href);
                $("#textnombre").val(response.name_opcion);
                response.icon_notifica
                response.norder
                if(response.nestado==1){
                    $("#chkestado").attr('checked',true);
                }else{
                    $("#chkestado").attr('checked',false);
                }
            }
       });
}

$("#search").on("keyup", function(ev){
    var texto = $(this).val();
    filtro(texto);
});

function filtro(texto) {
    var lista = $("#jstree ul li").hide()
                     .filter(function(){
                         var item = $(this).text();
                         var padrao = new RegExp(texto, "i");
                         
                         return padrao.test(item);
                     }).closest("li").show();
}


$("#cmbopcion").change(function(){
    var tipo = this.value;

     $.ajax({
             type: "POST",
             url: urljs+'SeguridadController/seleccion',
             data:{tipo:tipo},
             dataType: 'html', 
             beforeSend:function(){
             },
             success: function(response){
                $("#cmbSeleccion").html(response);
            }
       });

});


   $("#frmAccesos").submit(function(e) {
        e.preventDefault();
        var form = $(this);

            $.ajax({
               type: form.attr('method'),
               url: form.attr('action'),
               data: form.serialize(),
               dataType: 'json',  
               beforeSend:function(){
               },
               success: function(data){

                        showMessage(data.accion,data.sms,"Mensaje!");
                        window.location.reload(true);
                    
                    
               },
               error:function(){
                    showMessage("error","Ups, ocurrio un problema, intente nuevamente","Mensaje!");
               }
            });
        // }
    });