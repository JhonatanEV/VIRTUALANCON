$(document).ready(function(){
    $(".div-imprimir-ecuenta").hide();
});

function ec_accion(val){
    if(val==1){
        $("#form1").attr("action",urljs+"RentasController/ecuenta");
        $("#form1").submit();
    }else if(val==2){

        var tipo = 1; //$('input[type="radio"][name="rdTipo"]:checked').val();
        
        //$("#fmrImprimir").attr("action",urljs+"Ecimprimir/ecuenta/"+tipo);
        $("#fmrImprimir").attr("action",urljs+"Ecimprimir/pdf/"+tipo);
        $("#fmrImprimir").submit();

    }else if(val==3){
        $("#form11").attr("action",urljs+"RentasController/ecuenta_ajax");
        //$("#form11").submit();

    }
}

// $("#anno_desde").keydown(function(){
    
//     var desde = $("#anno_desde").val().trim().length;
    
//     if(desde==3){
//         $("#anno_desde").removeClass("is-invalid");
//         $("#anno_desde").addClass("is-valid");
//     }else if(desde>0 && desde<3){
//         $("#anno_desde").removeClass("is-valid");
//         $("#anno_desde").addClass("is-invalid");
//     }else if(desde>3){
//         $("#anno_desde").removeClass("is-valid");
//          $("#anno_desde").addClass("is-invalid");

//     }else if(desde==0){
//         $("#anno_desde").removeClass("is-valid");
//         $("#anno_desde").removeClass("is-invalid");
//     }
// });

// $("#anno_hasta").keydown(function(){
    
//     var desde = $("#anno_hasta").val().trim().length;
    
//     if(desde==3){
//         $("#anno_hasta").removeClass("is-invalid");
//         $("#anno_hasta").addClass("is-valid");
//     }else if(desde>0 && desde<3){
//         $("#anno_hasta").removeClass("is-valid");
//         $("#anno_hasta").addClass("is-invalid");
//     }else if(desde>3){
//         $("#anno_hasta").removeClass("is-valid");
//          $("#anno_hasta").addClass("is-invalid");

//     }else if(desde==0){
//         $("#anno_hasta").removeClass("is-valid");
//         $("#anno_hasta").removeClass("is-invalid");
//     }
// });


$("#form11").submit(function(e) {
    e.preventDefault();
    $(".dt-buttons").html('');
    $("#html-tabla-ecuenta").css("display","none");

    var desde = $("#anno_desde").val();
    var hasta = $("#anno_hasta").val();

    if(desde!='' && hasta==''){
        showMessage("warning","Ingrese el año Final","Mensaje!");
        $("#anno_hasta").focus();
        return;
    }

    if(hasta!='' && desde==''){
        showMessage("warning","Ingrese el año Inicial","Mensaje!");
        $("#anno_desde").focus();
        return;
    }



    var form1 = $(this)[0];
    var data = new FormData(form1);

    var form = $(this);
    $.ajax({
       type: form.attr('method'),
       url: form.attr('action'),
       data: data,
       dataType: 'html',
       processData: false,
       contentType: false, 
       beforeSend:function(){
        $("#btn-consulta-ecuenta").prop("disabled",true);
        $("#btn-consulta-ecuenta").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando..');
        $("#html-tabla-ecuenta").css("display","show");
        $('#html-tabla-ecuenta').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando..');
       },
       success: function(data){
        $(".div-imprimir-ecuenta").show();
        $("#html-tabla-ecuenta").fadeIn(1000).html(data);
        $("#btn-consulta-ecuenta").html('<i class="fas fa-paper-plane"></i> Consultar');
        $("#btn-consulta-ecuenta").prop("disabled",false);
       },
       error:function(){
            showMessage("error",data.sms,"Mensaje!")
            $("#btn-consulta-ecuenta").prop("disabled",false);
       }
    });

});


function createDropdowns(api) {
	api.columns().every(function() {
		if (this.searchable()) {
			var that = this;
			var col = this.index();

			// Only create if not there or blank
			var selected = $('thead tr:eq(1) td:eq(' + col + ') select').val();
			if (selected === undefined || selected === '') {
				// Create the `select` element
				$('thead tr:eq(1) td')
					.eq(col)
					.empty();
				var select = $('<select class="form-control"><option value="">[Seleccione]</option></select>')
					.appendTo($('thead tr:eq(1) td').eq(col))
					.on('change', function() {
						that.search($(this).val()).draw();
						createDropdowns(api);
					});

				api
					.cells(null, col, {
						search: 'applied'
					})
					.data()
					.sort()
					.unique()
					.each(function(d) {
						select.append($('<option>' + d + '</option>'));
					});
			}
		}
	});
}

$('#chkanno_').click(function () {    
     $('input[name=channos\\[\\]').prop('checked', this.checked);    
 });

$('#chktipotribu_').click(function () {    
     $('input[name=chktipotribu\\[\\]').prop('checked', this.checked);    
});

$('#chk_denominacion').click(function () {    
     $('input[name=chkdenomina\\[\\]').prop('checked', this.checked);    
});

$('#chktipodeuda_').click(function () {    
     $('input[name=chktipodeuda\\[\\]').prop('checked', this.checked);    
});




function returnview(){
    $('.ec-contenedor').show();
    $('.ec-seleccion').html("");
}