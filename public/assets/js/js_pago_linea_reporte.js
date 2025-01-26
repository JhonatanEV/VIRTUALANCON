$(document).ready(function () {
    let fec_ini = moment().format("YYYY-MM-DD");
    let fec_fin = moment().format("YYYY-MM-DD");

    $("#FEC_INI").val(fec_ini);
    $("#FEC_HASTA").val(fec_fin);

    $("#FEC_INI_CANCHA").val(fec_ini);
    $("#FEC_HASTA_CANCHA").val(fec_fin);

    $("#FEC_INI_TALLER").val(fec_ini);
    $("#FEC_HASTA_TALLER").val(fec_fin);

    $("#btn-consultar").on("click", function () {
        generarReportePagoLinea();
    });

    $("#btn-consultar-cancha").on("click", function () {
        generarReporteCancha();
    });

    $("#btn-consultar-taller").on("click", function () {
        generarReporteTaller();
    });
});

function generarReportePagoLinea() {
    var fechaInicio = $("#FEC_INI").val();
    var fechaFin = $("#FEC_HASTA").val();

    if (fechaInicio == "" || fechaFin == "") {
        alert("Debe seleccionar un rango de fechas");
        return;
    }
    $("#montoTotal").html(`S/. 0.00`);
    $("#tablaIngreso tbody").html("");
    $("#tablaIngreso").DataTable().destroy();

    var url = "pagalo/reporte-ingresos-select?fec_ini=" + fechaInicio + "&fec_hasta=" + fechaFin;
    fetchGet(url,function(res){
        var html = "";
        var dataArray = res.data;
        let item=0;
        let total=0;
        dataArray.forEach(function (tributo) {
            item++;
            html += "<tr>";
            html += "<td>" + item + "</td>";
            html += "<td>" + tributo.FECHA_INGRESO + "</td>";
            // html += "<td>" + tributo.OPERACION + "</td>";
            html += "<td class='fw-bold'>S/ " + number_format(tributo.TOTAL,2) + "</td>";
            html += "<td>" + tributo.CODIGO_CONTRI + "</td>";
            html += "<td>" + tributo.RAZON_SOCIAL + "</td>";
            html += "</tr>";
            total+=parseFloat(tributo.TOTAL);
        });
        $("#montoTotal").html(`S/. ${number_format(total.toFixed(2),2)}`);
        $("#tablaIngreso tbody").html(html);
        $("#tablaIngreso").DataTable({
            ordering:false,
        });

    },true)
}

function generarReporteCancha() {
    var fechaInicio = $("#FEC_INI_CANCHA").val();
    var fechaFin = $("#FEC_HASTA_CANCHA").val();

    if (fechaInicio == "" || fechaFin == "") {
        alert("Debe seleccionar un rango de fechas");
        return;
    }
    $("#montoTotalCancha").html(`S/. 0.00`);
    $("#tablaIngresoCancha tbody").html("");
    $("#tablaIngresoCancha").DataTable().destroy();

    var url = "reportes-online/reporte-canchas?fec_ini=" + fechaInicio + "&fec_hasta=" + fechaFin;
    fetchGet(url,function(res){
        var html = "";
        var dataArray = res.data;
        let item=0;
        let total=0;
        dataArray.forEach(function (tributo) {
            item++;
            html += "<tr>";
            html += "<td>" + item + "</td>";
            html += "<td>" + moment(tributo.RESE_FECHA_PAGO).format('L') + "</td>";
            html += "<td>" + tributo.FNIMPORTE + "</td>";
            html += "<td class='fw-bold'>S/ " + number_format(tributo.FNIMPORTE,2) + "</td>";
            html += "<td>" + tributo.PERS_DOCUMENTO + "</td>";
            html += "<td>" + tributo.PERS_NOMBRES + "</td>";
            html += "</tr>";
            total+=parseFloat(tributo.FNIMPORTE);
        });
        $("#montoTotalCancha").html(`S/. ${number_format(total.toFixed(2),2)}`);
        $("#tablaIngresoCancha tbody").html(html);
        $("#tablaIngresoCancha").DataTable({
            ordering:false,
        });

    },true)
}
function generarReporteTaller() {
    var fechaInicio = $("#FEC_INI_TALLER").val();
    var fechaFin = $("#FEC_HASTA_TALLER").val();

    if (fechaInicio == "" || fechaFin == "") {
        alert("Debe seleccionar un rango de fechas");
        return;
    }
    $("#montoTotalTaller").html(`S/. 0.00`);
    $("#tablaIngresoTaller tbody").html("");
    $("#tablaIngresoTaller").DataTable().destroy();

    var url = "reportes-online/reporte-talleres?fec_ini=" + fechaInicio + "&fec_hasta=" + fechaFin;
    fetchGet(url,function(res){
        var html = "";
        var dataArray = res.data;
        let item=0;
        let total=0;
        dataArray.forEach(function (tributo) {
            item++;
            html += "<tr>";
            html += "<td>" + item + "</td>";
            html += "<td>" + moment(tributo.MATRI_FECHA_PAGO).format('L') + "</td>";
            html += "<td>" + tributo.FNIMPORTE + "</td>";
            html += "<td class='fw-bold'>S/ " + number_format(tributo.FNIMPORTE,2) + "</td>";
            html += "<td>" + tributo.ALUM_DOCUMENTO + "</td>";
            html += "<td>" + tributo.ALUM_NOMBRES + "</td>";
            html += "</tr>";
            total+=parseFloat(tributo.FNIMPORTE);
        });
        $("#montoTotalTaller").html(`S/. ${number_format(total.toFixed(2),2)}`);
        $("#tablaIngresoTaller tbody").html(html);
        $("#tablaIngresoTaller").DataTable({
            ordering:false,
        });

    },true)
}