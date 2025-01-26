	<div class="row">
		<div class="col-lg-4">
	        <div class="card">
	            <div class="card-body">
                <input type="hidden" id="CONTC_CODIGO" name="CONTC_CODIGO">
	                    <div class="form-group mb-1">
	                        <label class="form-label" for="TIPO_D_CODIGO">Tipo Contacto</label>
	                        <select class="form-select" id="TIPO_D_CODIGO" name="TIPO_D_CODIGO" onchange="SelectTipoContacto(this.value)" >
	                            <option value="">-- Seleccione --</option>
	                        </select>                   
	                    </div>
	                    <div class="form-group mb-1">
	                        <label class="form-label" for="CONTC_DATOS">Datos:</label>
	                        <input type="text" class="form-control" id="CONTC_DATOS" name="CONTC_DATOS" placeholder="Datos del contacto" autocomplete="off"> 
	                    </div>
	                    <button type="button" class="btn btn-soft-success w-100 btn-sm" id="btnAddContacto">+ Agregar</button>              
	            </div>
	        </div>
	    </div>
	    <div class="col-lg-8">
	        <div class="card">
	            <div class="card-body pt-2">
                    
	                <table id="datatable-buttonsContacto" class="table table-bordered dt-responsive nowrap" 
	                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	                    <thead class="bg-soft-primary">
	                    <tr>
	                        <th>Opciones</th>
	                        <th>Tipo Contacto</th>
	                        <th>Datos</th>
	                    </tr>
	                    </thead >
	                    <tbody id="dataContenedorContacto">
                        
	                    </tbody>
	                </table>
	            </div>
	        </div>
	    </div>
        
	</div>


<script>
	$(document).ready(function() {
	    ListarTipoContacto();
        listarDataContactos();
	});

	function SelectTipoContacto(VALUE){
	    if (VALUE >=15 && VALUE<=20){
	        $("#CONTC_DATOS").attr("type","email");
	    }else {
	        $("#CONTC_DATOS").attr("type","number");
	    }
	}

	function ListarTipoContacto(){
	    let url = "seguridad/tipo-contactos";
	    fetchGet(url,function(data){
	        llenarCombo(data,"TIPO_D_CODIGO","TIPO_D_NOMBRE","TIPO_D_CODIGO","");
	    });
	}

    function listarDataContactos(){

        let PARAMETROS = "";
        let url = "seguridad/select-contactos?"+PARAMETROS;
        fetchGet(url,function(data){
            var contenido = "";
            var elemento;
            for (var j = 0; j < data.length; j++) {
                elemento = data[j];
                contenido +=
                            `<tr id="tr_${elemento.CONTC_CODIGO}">
                                    <td class="text-center">
                                            <button class="btn btn-soft-warning btn-sm tippy-btn" data-tippy-arrow="true"  onclick="EditarContactoPerfil(${elemento.CONTC_CODIGO})" title="Editar"><i class="las la-pen font-16"></i></button>
                                            <button class="btn btn-soft-danger btn-sm tippy-btn " data-tippy-arrow="true"  onclick="EliminarContactoPerfil(${elemento.CONTC_CODIGO},0)" title="Eliminar"><i class="las la-trash-alt font-16"></i></button>
                                    </td>
                                    <td>${elemento.TIPO_D_NOMBRE}</td>
                                    <td>${elemento.CONTC_DATOS}</td>
                                </tr>`;
            } 
            
            $("#dataContenedorContacto").html(contenido);
        });
    };

    function EditarContactoPerfil(CONTC_CODIGO){
        let url = "seguridad/select-contactos?CONTC_CODIGO="+CONTC_CODIGO;
	    fetchGet(url,function(data){
	        setValue("CONTC_CODIGO",data[0].CONTC_CODIGO);
            setValue("TIPO_D_CODIGO",data[0].TIPO_D_CODIGO);
            setValue("CONTC_DATOS",data[0].CONTC_DATOS);
	    });
    }

    function EliminarContactoPerfil(CONTC_CODIGO,CONTC_ESTADO){
        let url = "seguridad/eliminar-contacto?CONTC_CODIGO="+CONTC_CODIGO+"&CONTC_ESTADO="+CONTC_ESTADO;
	    fetchGet(url,function(data){
	        listarDataContactos();
	    });
    }
	$("#btnAddContacto").click(function(){
        let CONTC_CODIGO = getValue("CONTC_CODIGO");
		let TIPO_D_CODIGO 	= getValue("TIPO_D_CODIGO");
		let TIPO_D_CODIGO_TEXT = $("#TIPO_D_CODIGO option:selected").text();
		let CONTC_DATOS 	= getValue("CONTC_DATOS");
		TIPO_D_CODIGO 		= TIPO_D_CODIGO.trim();
		let CODIGOTR = Math.floor((Math.random() * 100000) + 1);

		if(TIPO_D_CODIGO.length==''){
			$("#TIPO_D_CODIGO").focus();
			return false;
		}else if(CONTC_DATOS==''){
			$("#CONTC_DATOS").focus();
			return false;
		}else{

            let url = "seguridad/grabar-contactos?CONTC_CODIGO="+CONTC_CODIGO+"&TIPO_D_CODIGO="+TIPO_D_CODIGO+"&CONTC_DATOS="+CONTC_DATOS;
	        fetchGet(url,function(data){
                listarDataContactos();
            });
		}

        setValue("CONTC_CODIGO","");
		setValue("TIPO_D_CODIGO","");
		setValue("CONTC_DATOS","");
	});

	function  eliminarTrContacto(codigo) {
	
		$('#tr_'+codigo).remove();
		$('.id-delete-'+codigo).remove();
	}
</script>