$(document).ready(function(){
     $("#txtvalor1").focus();
	soloNumeros("#txtvalor1");
	soloNumeros("#txtvalor2");
     validaCoreo("txtvalor3");
     listarData();
 });

// $("#btn-actualizar-datos").click(function(){
//      actualizar_datos();
// });

function actualizar_datos(){
     var datos = $("input[name='datos_pers[]']").map(function(){return $(this).val();}).get();

     if(datos.length>0){
          
          let data = $("#fmr-actualizar-datos").serialize();
        
          let url = "seguridad/grabar-contactos?"+data;
          fetchGet(url, function(response){
               var data = response.split('|');
               showMessage(data[0],data[1],"Mensaje!");
               listarData();
          });
     }else{
          showMessage("error","La información no puede estar vacio!!","Mensaje!");
          $("#txtvalor").focus();
     }
}

function agregar_cuadro(e,c) {
     
     txt_name=e[0].childElementCount;
     
     txt_name=txt_name+1;

     //console.log(txt_name);
     if (c==1) {
     
     e.append('<div class="col-md group'+txt_name+'1"">'+
               '<div class="input-group mb-3 ">'+
                 '<input type=\"number\" class=\"form-control\" placeholder=\"Telefono\" name="txtTelefono[]">'+
                 '<button class=\"btn btn-secondary\" type=\"button"\  onclick=\"eliminar_cuadros('+txt_name+'1);\"><i class=\"mdi mdi-trash-can-outline\"></i></button>'+
                '</div></div>');

          $('#cant_tele').val(txt_name)

     }else if(c==2){

          e.append('<div class="col-md group'+txt_name+'2"">'+
               '<div class="input-group mb-3 ">'+
                 '<input type=\"text\" class=\"form-control\" placeholder=\"Correo Electronico\"   name="txtCorreo_e[]">'+
                 '<button class=\"btn btn-secondary\" type=\"button"\  onclick=\"eliminar_cuadros('+txt_name+'2);\"><i class=\"mdi mdi-trash-can-outline\"></i></button>'+
                '</div></div>');

          $('#cant_ema').val(txt_name)
     }

}

function eliminar_cuadros(id){
     console.log(id);
      $('.group'+id).remove();
}

$('#btn-add-datos1').on("click", function () {
     agregar_datos(1);
});  
$('#btn-add-datos2').on("click", function () {
     agregar_datos(2);
});  
$('#btn-add-datos3').on("click", function () {
     agregar_datos(3);
});  


function agregar_datos(cod){

     if ($('#txtvalor'+cod).val()) {
          
          $("#table-datos-actualizar tr:last").after("<tr class='bg-soft-danger'></tr>");
          var val = $('#txtvalor'+cod).val();
          var name = $('#cmbtipo-datos'+cod+' option:selected').text();
          var tipo = $('#cmbtipo-datos'+cod).val();
          var ramdon = ((Math.random()));
          
          const data = {
               TIPO_D_CODIGO:tipo,
               CONTC_DATOS:val
           };
          fetchGet('seguridad/grabar-contactos?TIPO_D_CODIGO='+tipo+"&CONTC_DATOS="+val,function(data){

               $("#table-datos-actualizar tr:last").append("<td> <span class='text-muted fw-bold'>"+name+"</span></td><td>"+val+"</td><td class='text-center'><button type='button' class='btn btn-sm' onclick='deleteRow(this,"+data.codigo+");'><i class='las la-trash-alt text-danger font-16'></i></button></td>");
               $(".datos-div").append("<input type='hidden' class='id-delete-"+data.codigo+"' id-tipo-datos="+tipo+" name='datos_pers[]'' value="+tipo+"*"+val+">");
               $('#txtvalor'+cod).val('');
               $("#txtvalor"+cod).focus();
          });

          //fetchPost('contribuyente/grabar-contactos',data,function(data){},false);
          
      }   
      else {
          showMessage("error","Ingrese algún dato!","Mensaje!");
          $("#txtvalor"+cod).focus();
      }
      return false;

}


function deleteRow(obj,id) {
  $(obj).parent().parent().remove();
  
  $('.id-delete-'+id).remove();
  fetchGet('seguridad/eliminar-contacto?CONTC_CODIGO='+id+"&CONTC_ESTADO=0",function(data){});

}

$('#txtvalor1').on("keypress", function(e) {    
  if (e.keyCode == 13) {
        agregar_datos(1);
     }
});
$('#txtvalor2').on("keypress", function(e) {    
  if (e.keyCode == 13) {
        agregar_datos(2);
     }
});
$('#txtvalor3').on("keypress", function(e) {    
  if (e.keyCode == 13) {
        agregar_datos(3);
     }
});

function listarData(){

     let url = "seguridad/select-contactos";
     fetchGet(url,function(data){
          var contenido = "";
          var elemento;
          var datos="";
          for (var j = 0; j < data.length; j++) {
               elemento = data[j];
               contenido +=
               `<tr>
                    <td class="text-muted fw-bold">${elemento.TIPO_D_NOMBRE}</td>
                    <td>${elemento.CONTC_DATOS}</td>
                    <td class="text-center">                        
                         <button type="button" class="btn btn-sm" onclick="deleteRow(this,${elemento.CONTC_CODIGO});"><i class="las la-trash-alt text-danger font-16"></i></button>
                    </td>
               </tr>`;

               datos += `<input type="hidden" 
                         class="form-control id-delete-${elemento.CONTC_CODIGO}" 
                         id-tipo-datos="${elemento.TIPO_D_CODIGO}" 
                         name="datos_pers[]" 
                         value="${elemento.TIPO_D_CODIGO}*${elemento.CONTC_DATOS}">`
          } 
          $(".datos-div").html(datos);
          $("#dataContenedor").html(contenido);
    });
}