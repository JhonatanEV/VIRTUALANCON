<div class="row">
		<div class="col-lg-4">
	        <div class="card">
	            <div class="card-body">
                <input type="hidden" id="USUA_CODIGO_AREA"  value="{{ $USUA_CODIGO }}">
	                    <div class="form-group mb-1">
	                        <label class="form-label" for="AREA_CODIGO">Área</label>
	                        <select class="form-select" id="AREA_CODIGO" name="AREA_CODIGO" >
	                            <option value="">-- Seleccione --</option>
                                @foreach($dbArea as $area)
                                <option value="{{ $area->AREA_CODIGO }}">{{ $area->AREA_NOMBRE }}</option>
                                @endforeach
	                        </select>                   
	                    </div>
	                   
	                    <button type="button" class="btn btn-soft-success w-100 btn-sm" id="btnAddArea">+ Agregar</button>              
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
	                        <th>Área</th>
	                    </tr>
	                    </thead >
	                    <tbody id="dataContenedorArea">

	                    </tbody>
	                </table>
	            </div>
	        </div>
	    </div>
        
	</div>


    <script>
	$(document).ready(function() {
        listarDataArea();
	});


    function listarDataArea(){
        let USUA_CODIGO_AREA = getValue("USUA_CODIGO_AREA");
        let PARAMETROS = "USUA_CODIGO="+USUA_CODIGO_AREA;
        let url = "seguridad/select-usuario-area?"+PARAMETROS;
        fetchGet(url,function(data){
            var contenido = "";
            var elemento;
            for (var j = 0; j < data.length; j++) {
                elemento = data[j];
                contenido +=
                            `<tr id="tr_${elemento.USUA_A_CODIGO}">
                                    <td class="text-center">
                                            <button class="btn btn-soft-danger btn-sm tippy-btn " data-tippy-arrow="true"  onclick="EliminarUsuarioArea(${elemento.USUA_A_CODIGO},0)" title="Eliminar"><i class="las la-trash-alt font-16"></i></button>
                                    </td>
                                    <td>${elemento.AREA_NOMBRE}</td>
                                </tr>`;
            } 
            
            $("#dataContenedorArea").html(contenido);
        });
    };


    function EliminarUsuarioArea(USUA_A_CODIGO,USUA_A_ESTADO){
        let url = "seguridad/eliminar-usuario-area?USUA_A_CODIGO="+USUA_A_CODIGO+"&USUA_A_ESTADO="+USUA_A_ESTADO;
	    fetchGet(url,function(data){
	        listarDataArea();
	    });
    }
	$("#btnAddArea").click(function(){
        let USUA_CODIGO_AREA = getValue("USUA_CODIGO_AREA");
		let AREA_CODIGO 	 = getValue("AREA_CODIGO");
        
		if(AREA_CODIGO.length==''){
			$("#AREA_CODIGO").focus();
			return false;
		}else{
            let url = "seguridad/grabar-usua-area?USUA_CODIGO="+USUA_CODIGO_AREA+"&AREA_CODIGO="+AREA_CODIGO;
	        fetchGet(url,function(data){
                listarDataArea();
            });
		}

        //setValue("USUA_CODIGO_AREA","");
		//setValue("AREA_CODIGO","");
	});

</script>