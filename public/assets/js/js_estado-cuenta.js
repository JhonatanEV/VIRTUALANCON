
$(function(){
    //$("body").addClass('enlarge-menu');    
    filtroEstadoCuenta();
});

function filtroEstadoCuenta(){
    let url = "contribuyente/filtro-ecuenta";
    fetchGet(url,function(data){
        
        llenarCombo(data.procedencia,"cmbProcedencia","CCPR_chDESPRO","CCPR_P_inCODPRO",valueDefecto="",valueSelected="");
        $('#cmbProcedencia').multiSelect({
            noneText: 'Seleccione Procedencia'
        });

        llenarCombo(data.materia,"cmbMateria","CCOR_chDESAUX","CCOR_P_inCODORI",valueDefecto="",valueSelected="");
        $('#cmbMateria').multiSelect({
            noneText: 'Seleccione Materia',
            afterSelect: function(){
                var selections = [];
                $("#cmbMateria option:selected").each(function(){
                    var optionValue = $(this).val();
                    var optionText = $(this).text();
                    console.log("optionText",optionText);     
                    selections.push(optionValue);
                });
                console.log(selections);
            }
        });
        llenarCombo(data.tipo_tributo,"cmbDesTribu","TRIB_chDESTRI","TRIB_P_inCODTRI",valueDefecto="",valueSelected="");
        $('#cmbDesTribu').multiSelect({
            noneText: 'Descripción Deuda'
        });
        llenarCombo(data.tipo_deuda,"cmbTipDeuda","COSE_chDESCOD","COSE_P_inCODSEC",valueDefecto="",valueSelected="");
        $('#cmbTipDeuda').multiSelect({
            noneText: 'Tipo Deuda'
        });

        llenarCombo(data.anio,"anno_desde","ANIO_P_chCODANO","ANIO_P_chCODANO",valueDefecto="",valueSelected="");
        llenarCombo(data.anio,"anno_hasta","ANIO_P_chCODANO","ANIO_P_chCODANO",valueDefecto="",valueSelected="");
        

    });
    
}

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
    
    envioAjaxdataText("contribuyente/consulta-ecuenta",data,function(res){
        // $(".div-imprimir-ecuenta").show();
        $("#html-tabla-ecuenta").css("display","show");
        $("#html-tabla-ecuenta").fadeIn(1000).html(res);
    })
});
