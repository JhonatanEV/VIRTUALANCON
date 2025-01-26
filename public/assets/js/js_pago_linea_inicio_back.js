var tabPredial, tabArbitr;
var dataCta = [];
var totalSeleccionado = 0;
var deudaTipoSelected = [
    { id: 1, name: "Predial", monto: 0 },
    { id: 2, name: "Arbitrios", monto: 0 },
];
$(document).ready(function () {
    //antes se llena en view de la vista
    dataCta = JSON.parse(localStorage.getItem("deuda"));
    console.log(dataCta);
    //desde ahora vamos trabajar con dataCta para seleccionar los tributos a pagar

    var tableImpuesto = $("#tablaIp").DataTable({
        ordering: false,
        lengthChange: false,
        paging: true,
        searching: true,
        iDisplayLength: 6,
        bLengthChange: false,
    });
    var fecha = new Date();
    var anio = fecha.getFullYear();
    var range = anio - 1993 + 1;

    var arr = tableImpuesto.column(2).data();

    if (typeof arr != "undefined") {
        var uniqueArray = arr.filter(function (elem, pos) {
            return arr.indexOf(elem) == pos;
        });

        var arr = [];
        for (var i = 0; i < uniqueArray.length; i++) {
            arr[i] = uniqueArray[i];
        }

        $("#pagination-ip").twbsPagination({
            totalPages: range,
            visiblePages: 4,
            first: "",
            prev: "<",
            next: ">",
            startPage: parseInt(arr[0]),
            array: arr,
            last: "",
            onPageClick: function (event, page) {
                tableImpuesto.column(2).search(page).draw();

                var data = tableImpuesto
                    .column(10, { search: "applied" })
                    .data();
                var totalxAnio = 0;
                data.each(function (value) {
                    totalxAnio += parseFloat(value);
                });

                if (
                    $(
                        "input[type=checkbox]:checked",
                        tableImpuesto.rows({ search: "applied" }).nodes()
                    ).length ==
                    $(
                        "input[type=checkbox]",
                        tableImpuesto.rows({ search: "applied" }).nodes()
                    ).length
                ) {
                    $("#imp-select-all").prop("checked", true);
                } else {
                    $("#imp-select-all").prop("checked", false);
                }
                $("#thTotal").html(" S/. " + totalxAnio.toFixed(2));
            },
        });
    }

    // Tabla Arbitrios
    var tableArbitrios = $("#tablaArb").DataTable({
        ordering: false,
        lengthChange: false,
        paging: true,
        searching: true,
        iDisplayLength: 6,
    });

    var arr = tableArbitrios.column(2).data();

    if (typeof arr != "undefined") {
        var uniqueArray = arr.filter(function (elem, pos) {
            return arr.indexOf(elem) == pos;
        });

        var arr = [];
        for (var i = 0; i < uniqueArray.length; i++) {
            arr[i] = uniqueArray[i];
        }

        $("#pagination-arb").twbsPagination({
            totalPages: range,
            visiblePages: 4,
            first: "",
            prev: "<",
            next: ">",
            startPage: parseInt(arr[0]),
            array: arr,
            last: "",
            onPageClick: function (event, page) {
                tableArbitrios.column(2).search(page).draw();

                var data = tableArbitrios
                    .column(10, { search: "applied" })
                    .data();
                var totalxAnio = 0;
                data.each(function (value) {
                    totalxAnio += parseFloat(value);
                });

                if (
                    $(
                        "input[type=checkbox]:checked",
                        tableArbitrios.rows({ search: "applied" }).nodes()
                    ).length ==
                    $(
                        "input[type=checkbox]",
                        tableArbitrios.rows({ search: "applied" }).nodes()
                    ).length
                ) {
                    $("#arb-select-all").prop("checked", true);
                } else {
                    $("#arb-select-all").prop("checked", false);
                }
                $("#thTotalArb").html(" S/. " + totalxAnio.toFixed(2));
            },
        });
    }

    //Seleccionar todos los tributos
    $("#imp-select-all").on("click", function () {
        var rows = tableImpuesto.rows({ search: "applied" }).nodes();

        if ($(this).is(":checked")) {
            tableImpuesto
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .prop("checked", true);
            tableImpuesto
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .each(function () {
                    
                    totalSeleccionado += parseFloat(
                        $(this).attr("precio-trib")
                    );
                });
        } else {
            tableImpuesto
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .each(function () {
                    if ($(this).is(":checked")) {
                        console.log('deseleccionado:'+ $(this).attr("codigo"));
                        
                        totalSeleccionado -= parseFloat(
                            $(this).attr("precio-trib")
                        );
                    }
                });
            tableImpuesto
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .prop("checked", false);
        }
        totalSeleccionado = total = Math.round(totalSeleccionado * 1000) / 1000;

        deudaTipoSelected[0].monto = totalSeleccionado;
        listarDeudaSeleccionada();
    });

    $("#tablaIp").on("click", ".mis-tributos", function () {
        if ($(this).is(":checked")) {
            totalSeleccionado += parseFloat($(this).attr("precio-trib"));
        } else {
            totalSeleccionado -= parseFloat($(this).attr("precio-trib"));
        }
        deudaTipoSelected[0].monto = totalSeleccionado;
        listarDeudaSeleccionada();
    });

    $("#arb-select-all").on("click", function () {
        if ($(this).is(":checked")) {
            tableArbitrios
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .prop("checked", true);
            tableImpuesto
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .each(function () {
                    console.log($(this).attr("codigo"));
                    totalSeleccionado += parseFloat(
                        $(this).attr("precio-trib")
                    );
                });
        } else {
            tableImpuesto
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .each(function () {
                    if ($(this).is(":checked")) {
                        totalSeleccionado -= parseFloat(
                            $(this).attr("precio-trib")
                        );
                    }
                });
            tableArbitrios
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .prop("checked", false);
        }
        deudaTipoSelected[1].monto = totalSeleccionado;
        listarDeudaSeleccionada();
    });

    $("#tablaArb").on("click", ".mis-tributos", function () {
        if ($(this).is(":checked")) {
            totalSeleccionado += parseFloat($(this).attr("precio-trib"), 2);
        } else {
            totalSeleccionado -= parseFloat($(this).attr("precio-trib"), 2);
        }
        deudaTipoSelected[1].monto = totalSeleccionado;
        listarDeudaSeleccionada();
    });

    $("#loader-overlay").fadeOut();
});

function listarDeudaSeleccionada() {
    var html = "";
    var total = 0;

    deudaTipoSelected.forEach(function (deuda) {
        if (deuda.monto > 0) {
            html +=
                '<li class="list-group-item d-flex justify-content-between align-items-center">';
            html += "<div>";
            html +=
                '<i class="far fa-chart-bar text-muted font-18 me-2"></i>' +
                deuda.name;
            html += "</div>";
            html +=
                '<span class="text-dark">S/ ' +
                number_format(deuda.monto, 2) +
                "</span>";
            html += "</li>";
            total += deuda.monto;
        }
    });

    $("#MontoSeleccionado").html(" S/. " + total);

    $("#deuda-seleccionada").html(html).fadeIn(500);
    $("#txtMontoSeleccion").val(total);
}

function round(num, decimales = 2) {
    var signo = num >= 0 ? 1 : -1;
    num = num * signo;
    if (decimales === 0)
        //con 0 decimales
        return signo * Math.round(num);
    // round(x * 10 ^ decimales)
    num = num.toString().split("e");
    num = Math.round(
        +(num[0] + "e" + (num[1] ? +num[1] + decimales : decimales))
    );
    // x * 10 ^ (-decimales)
    num = num.toString().split("e");
    return signo * (num[0] + "e" + (num[1] ? +num[1] - decimales : -decimales));
}

function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + "").replace(/[^0-9+\-Ee.]/g, "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}
