 


 $("#frmPlantilla").submit(function(e) {
        e.preventDefault();

        var parametros = $(this).serialize();
        var plantilla= CKEDITOR.instances.plantilla.updateElement();    
        var dataString ='plantilla='+plantilla;      
        var data = new FormData(this);
      
        var form = $(this);

            $.ajax({
               type: form.attr('method'),
               url: form.attr('action'),
               data: data,
               dataType: 'json', 
               encode: true,
               cache: false,
               processData: false,
                contentType: false, 
               beforeSend:function(){
               },
               success: function(data){
                  $(form)[0].reset();
                  $("#modal-plantilla").modal('hide');
                  CKEDITOR.instances.plantilla.setData('');
                   showMessage(data.accion,data.sms,"Mensaje!");

                   setTimeout(function() { 
                        location.reload()
                        }
                        , 1000);
                   
               },
               error:function(){
                    showMessage("error",data.sms,"Mensaje!")
               }
            });
        
    });


function editarplantilla(id){

     var titulo = $(".class-plantilla-"+id+" .class-titulo div h4 ").html();
     var cuerpo = $(".class-plantilla-"+id+" .class-cuerpo .cuerpo").html();
     var estado = $(".class-plantilla-"+id+" .class-cuerpo #estado-pla").val();
    

     $("#cod_plantilla").val(id);
      $("#txtTitulo").val(titulo);
      CKupdate();
      CKEDITOR.instances.plantilla.setData(cuerpo);
      if(estado==1){
            $("#chk_estado").attr("checked",true);
      }else{
            $("#chk_estado").attr("checked",false);
      }

      $("#modal-plantilla").modal('show');

}


function CKupdate(){
    for(instance in CKEDITOR.instance){
        CKEDITOR.instances['plantilla'].updateElement();
    }
}

function nuevoPlantilla(){

      $("#frmPlantilla")[0].reset();
      $("#cod_plantilla").val('');
      $("#txtTitulo").val('');
      CKEDITOR.instances.plantilla.setData('');
       $("#modal-plantilla").modal('show');

}


function eliminarplantilla(id){

      $.ajax({
         type: 'POST',
         url: urljs + 'AdministracionController/eliminarplantilla',
         data: {cod_plantilla:id},
         dataType: 'json', 
         beforeSend:function(){
         },
         success: function(data){
             showMessage(data.accion,data.sms,"Mensaje!");

             setTimeout(function() { 
                  location.reload()
                  }
                  , 1000);
             
         },
         error:function(){
              showMessage("error",data.sms,"Mensaje!")
         }
      });

}