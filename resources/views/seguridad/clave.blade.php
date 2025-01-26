<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form id="frmClaves">
                    <label class="form-label" for="setPassword">Nueva contraseña</label>
                    <input type="password" class="form-control" name="PASS_NUEVO" id="PASS_NUEVO" placeholder="Nueva contraseña">
                    <label class="form-label" for="setPassword">Confirmar contraseña</label>
                    <input type="password" class="form-control" name="USUA_PASSWORD" id="PASS_CONFIRMAR" onkeydown="valida_clave();" onkeyup="valida_clave();" placeholder="Confirmar contraseña">
                    <strong id="smserror" class="m-0 mb-lg-n2"></strong>
                    <button type="submit" class="btn btn-primary btn-sm mt-3 disabled" id="btncambiarclave">Guardar cambios</button>
                </form> <!--end form-->
            </div><!--end card-body-->
        </div><!--end card-->
    </div>
</div>


<script>
	
	function valida_clave(){
	    var rango1 = $("#PASS_NUEVO").val().length;
	    var rango2 = $("#PASS_CONFIRMAR").val().length;

	    var pass1 = $("#PASS_NUEVO").val(); //.length
	    var pass2 = $("#PASS_CONFIRMAR").val(); //.length
	    
	        if(rango2>0){
	            if (pass1==pass2) {
	                $("#smserror").html("<p style='color:green'>Correcto!</p>").show();
	                $("#PASS_CONFIRMAR").removeClass('is-invalid');
	                $("#PASS_CONFIRMAR").addClass('is-valid');
	                $("#btncambiarclave").removeClass('disabled');
	                return false;
	            }else{
	                $("#PASS_CONFIRMAR").addClass('is-invalid');
	                $("#PASS_CONFIRMAR").removeClass('is-valid');
	                $("#smserror").html("<p style='color:red'>Contraseña no coincide!!</p>").show();
	                $("#btncambiarclave").addClass('disabled');
	            }
	        }else{
	            $("#smserror").html("<p style='color:red'>Contraseña no coincide!!</p>").show();
	            $("#PASS_CONFIRMAR").addClass('is-invalid');
	            $("#PASS_CONFIRMAR").removeClass('is-valid');
	            $("#btncambiarclave").addClass('disabled');
	        }
	    
	}

	$("#frmClaves").submit(function(e) {
    	e.preventDefault();
		var data = new FormData(this);
		envioAjaxdata("seguridad/save-clave",data,function(res){
			showMessageAlert("Mensaje",res.smg,res.accion);
			window.location.href = window.location.href;
		})
	});
</script>