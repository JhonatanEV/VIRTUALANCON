$(function(){
    //filtroEstadoCuenta();
    //dataAnno("anno_desde",1995);
    //dataAnno("anno_hasta",1995);

    getEcuenta()
});

function filtroEstadoCuenta(){
    $('#cmbTributo').multiSelect({
        noneText: 'Seleccione Tributo'
    });

    $('#cmbAnexos').multiSelect({
        noneText: 'Descripción Anexos'
    });
}

function getEcuenta(){
    try {
        var tributos = $('#cmbTributo').val();
        var anexos = $('#cmbAnexos').val();
        var anno_desde = $('#anno_desde').val();
        var anno_hasta = $('#anno_hasta').val();
        var data = {
            tributos: tributos,
            anexos: anexos,
            anno_desde: anno_desde,
            anno_hasta: anno_hasta
        };
        //destroys the DataTable object
        if ($.fn.DataTable.isDataTable('#row_callback')) {
            $('#row_callback').DataTable().destroy();
            $('#tableBodyEcuenta').html('');
        }

        var url = 'pagalo/get-ecuenta?tributos='+tributos+'&anexos='+anexos+'&anno_desde='+anno_desde+'&anno_hasta='+anno_hasta;
        fetchGet(url,function(res){
            var tableBodyEcuenta = '';
            let total_pagar = 0;

            res.data.forEach(function(ecuenta){
                total_pagar += parseFloat(ecuenta.total);
                let anexo_arb = '';
                if(ecuenta.abrev_tributo == 'IP'){
                    anexo_arb = ecuenta.nom_tributo;
                }else{
                    anexo_arb = ecuenta.nom_tributo+' '+ecuenta.direc_pred
                }

                tableBodyEcuenta += '<tr>';
                tableBodyEcuenta += '<td class="dtr-control">'+anexo_arb+'</td>';
                tableBodyEcuenta += '<td>'+ecuenta.anio+'</td>';
                tableBodyEcuenta += '<td>'+ecuenta.nro_recibo+'</td>';
                tableBodyEcuenta += '<td>'+ecuenta.periodo+'</td>';
                tableBodyEcuenta += '<td>'+moment(ecuenta.fecha_vencimiento).format("DD/MM/Y")+'</td>';
                tableBodyEcuenta += '<td>'+ecuenta.situacion+'</td>';
                tableBodyEcuenta += '<td class="text-end">'+number_format(ecuenta.imp_insol,2)+'</td>';
                tableBodyEcuenta += '<td class="text-end">'+number_format(ecuenta.mora,2)+'</td>';
                tableBodyEcuenta += '<td class="text-end">'+number_format(ecuenta.gasto_admin,2)+'</td>';
                tableBodyEcuenta += '<td class="text-end">'+number_format(ecuenta.costo_emis,2)+'</td>';
                tableBodyEcuenta += '<td class="text-end">'+number_format(ecuenta.descuento,2)+'</td>';
                tableBodyEcuenta += '<td class="text-end">'+number_format(ecuenta.total,2)+'</td>';
                tableBodyEcuenta += '</tr>';
            });
            $('#tableBodyEcuenta').html(tableBodyEcuenta);
            $("#row_callback").DataTable({
                ordering: false,
                "columnDefs": [
                        { "visible": false, "targets": [0,1] }
                ],
                rowGroup:{
                    dataSrc: [0,1],
                    startRender: function (rows, group) {
                        return $("<tr/>")
                            .append("<td colspan='9' class='text-start'><strong>" + group + "</strong></td><td style='background: none;'></td>");
                    },
                },
                "order": [[1, 'asc']],

            });
            $("#thTotal").text(number_format(total_pagar,2));
            //tableBodyEcuenta
        });
    } catch (error) {
        console.log(error);
    }
}

function imprimirEcuenta(){
    //enviar un post con los datos seleccionados
    var tributos = $('#cmbTributo').val();
    var anexos = $('#cmbAnexos').val();
    var anno_desde = $('#anno_desde').val();
    var anno_hasta = $('#anno_hasta').val();
    var data = {
        tributos: tributos,
        anexos: anexos,
        anno_desde: anno_desde,
        anno_hasta: anno_hasta
    };
    console.log(data);

    let ruta = 'estado-de-cuenta-pdf?tributos='+tributos+'&anexos='+anexos+'&anno_desde='+anno_desde+'&anno_hasta='+anno_hasta;
    OpenModal("#ModalPrint");

    $("#iframeEstadoCuenta").attr("src",ruta);
}