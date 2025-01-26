let tabPredial, tabArbitr;
let dataCta = [];
let dataSelected = [];
let totalSeleccionado = 0;
let totalIp = 0;
let totalArb = 0;
let totalCoac = 0;

var deudaTipoSelected = [
    { id: 1, name: "Predial", monto: 0 },
    { id: 2, name: "Arbitrios", monto: 0 },
    { id: 3, name: "Coactivo", monto: 0 },
];
$(document).ready(function () {
    //antes se llena en view de la vista
    dataCta = JSON.parse(localStorage.getItem("deuda"));
    //console.log(dataCta);

    /**************************************************************************Predial***************************************/

    var tableImpuesto = $("#tablaIp").DataTable({
        ordering: false,
        lengthChange: false,
        paging: true,
        searching: true,
        iDisplayLength: 6,
        bLengthChange: false,
        columnDefs: [
            { responsivePriority: 1, targets: 0 }, //Check siempre
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 3, targets: -1 } //total
        ]
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
        var selectedPages = {};
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

                var allSelected = $("input[type=checkbox]:checked", tableImpuesto.rows({ search: "applied" }).nodes()).length == $("input[type=checkbox]", tableImpuesto.rows({ search: "applied" }).nodes()).length;
                if (allSelected) {
                    $("#imp-select-all").prop("checked", true);
                } else {
                    $("#imp-select-all").prop("checked", false);
                }

                $("#thTotal").html(" S/. " + totalxAnio.toFixed(2));

                // selectedPages[page] = allSelected;
                // $('#pagination-ip li.page').each(function(index) {
                //     var year = $(this).find('a').text();
                //     $(this).find('a').removeClass('selected-page caja-' + year);

                //     if (parseInt(year) === page) {
                //         $(this).find('a').addClass('caja-' + year);

                //         if (selectedPages[page]) {
                //             $(this).find('a').addClass('selected-page');
                //         }
                //     }
                // });
            },
        });
    }

     //Seleccionar todos los tributos
     $("#imp-select-all").on("click", function () {
        var rows = tableImpuesto.rows({ search: "applied" }).nodes();
        var isChecked = $(this).is(":checked");
    
        $('input[type="checkbox"]', rows).prop("checked", isChecked);
        if (isChecked) {
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
                // totalIp += parseFloat(tributo[0].TOTAL);
                // totalSeleccionado += parseFloat(tributo[0].TOTAL);
            });
            //add class selected
            $(rows).addClass("selected");
        } else {
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                buscarCtaQuitar(codigoUnico);
            });
            //remove class selected
            $(rows).removeClass("selected");
        }
        listarDeudaSeleccionada();
    });

    $("#tablaIp").on("click", ".mis-tributos", function () {
        let codigoUnico = $(this).attr("codigo");
        let currentPage = $('#pagination-ip li.page.active').text();

        if ($(this).is(":checked")) {
            dataSelected.push(...buscarCta(codigoUnico));
            $(this).closest("tr").addClass("selected");

            // Guardar la página actual como seleccionada
            $('#pagination-ip li.page').each(function() {
                var year = $(this).find('a').text(); 
                if(year === currentPage) {
                    $(this).find('a').addClass('caja-selected');
                }
            });
        }
        else {
            buscarCtaQuitar(codigoUnico);
            $(this).closest("tr").removeClass("selected");

            // Si todos los elementos de la página están deseleccionados, eliminar la clase
            if ($('.mis-tributos:checked').length === 0) {
                $('#pagination-ip li.page').each(function() {
                    var year = $(this).find('a').text(); 
                    if(year === currentPage) {
                        $(this).find('a').removeClass('caja-selected');
                    }
                });
            }
        }
    
        listarDeudaSeleccionada();
        updateSelectAllCheckbox();
    });

    function updateSelectAllCheckbox() {
        var allChecked = tableImpuesto
            .rows({ search: "applied" })
            .nodes()
            .to$()
            .find(".mis-tributos")
            .length === tableImpuesto
            .rows({ search: "applied" })
            .nodes()
            .to$()
            .find(".mis-tributos:checked")
            .length;
    
        $("#imp-select-all").prop("checked", allChecked);
    }


    /**************************************************************************Arbitrios***************************************/

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


    $("#arb-select-all").on("click", function () {
        var rows = tableArbitrios.rows({
            'search': 'applied'
        }).nodes();

        if ($(this).is(":checked")) {
            tableArbitrios
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .prop("checked", true);

            $('input[type="checkbox"]', rows).each(function() {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
            });
            $(rows).addClass("selected");
        } else {

            $('input[type="checkbox"]', rows).each(function() {
                let codigoUnico = $(this).attr("codigo");
                buscarCtaQuitar(codigoUnico);
            });
            
            tableArbitrios
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .prop("checked", false);

            $(rows).removeClass("selected");
        }
        listarDeudaSeleccionada();
    });

    $("#tablaArb").on("click", ".mis-tributos", function () {
        let codigoUnico = $(this).attr("codigo");
        
        if ($(this).is(":checked")) {
            dataSelected.push(...buscarCta(codigoUnico));
            //totalArb += parseFloat(tributo[0].TOTAL);
            //totalSeleccionado += parseFloat(tributo[0].TOTAL);
            $(this).closest("tr").addClass("selected");
        } else {            
            buscarCtaQuitar(codigoUnico);
            $(this).closest("tr").removeClass("selected");
        }
        listarDeudaSeleccionada();
    });


    /**************************************************************************COACTIVO***************************************/
    var tableCoactivo = $("#tablaCoac").DataTable({
        ordering: false,
        lengthChange: false,
        paging: true,
        searching: true,
        iDisplayLength: 6,
    });

    var arr = tableCoactivo.column(2).data();

    if (typeof arr != "undefined") {
        var uniqueArray = arr.filter(function (elem, pos) {
            return arr.indexOf(elem) == pos;
        });

        var arr = [];
        for (var i = 0; i < uniqueArray.length; i++) {
            arr[i] = uniqueArray[i];
        }

        $("#pagination-coac").twbsPagination({
            totalPages: range,
            visiblePages: 4,
            first: "",
            prev: "<",
            next: ">",
            startPage: parseInt(arr[0]),
            array: arr,
            last: "",
            onPageClick: function (event, page) {
                tableCoactivo.column(2).search(page).draw();

                var data = tableCoactivo
                    .column(10, { search: "applied" })
                    .data();
                var totalxAnio = 0;
                data.each(function (value) {
                    totalxAnio += parseFloat(value);
                });

                if (
                    $(
                        "input[type=checkbox]:checked",
                        tableCoactivo.rows({ search: "applied" }).nodes()
                    ).length ==
                    $(
                        "input[type=checkbox]",
                        tableCoactivo.rows({ search: "applied" }).nodes()
                    ).length
                ) {
                    $("#coac-select-all").prop("checked", true);
                } else {
                    $("#coac-select-all").prop("checked", false);
                }
                $("#thTotalCoac").html(" S/. " + totalxAnio.toFixed(2));
            },
        });
    }


    $("#coac-select-all").on("click", function () {
        var rows = tableCoactivo.rows({
            'search': 'applied'
        }).nodes();

        if ($(this).is(":checked")) {
            tableCoactivo
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .prop("checked", true);

            $('input[type="checkbox"]', rows).each(function() {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
            });

            $(rows).addClass("selected");
        } else {

            $('input[type="checkbox"]', rows).each(function() {
                let codigoUnico = $(this).attr("codigo");
                buscarCtaQuitar(codigoUnico);
            });
            
            tableCoactivo
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .prop("checked", false);

            $(rows).removeClass("selected");
        }
        deudaTipoSelected[2].monto = totalCoac;
        listarDeudaSeleccionada();
    });

    $("#tablaCoac").on("click", ".mis-tributos", function () {
        let codigoUnico = $(this).attr("codigo");
        let tributo;

        if ($(this).is(":checked")) {
            dataSelected.push(...buscarCta(codigoUnico));
            $(this).closest("tr").addClass("selected");
        } else {            
            buscarCtaQuitar(codigoUnico);
            $(this).closest("tr").removeClass("selected");
        }
        listarDeudaSeleccionada();
    });

    $("#loader-overlay").fadeOut();





    $("#chkPagarTodoIp").on("click", function () {
        var rows = tableImpuesto.rows().nodes();
        //select all rows
        if ($(this).is(":checked")) {
            $('input[type="checkbox"]', rows).prop("checked", true);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
            });

            listarDeudaSeleccionada();

            //add class selected
            $(rows).addClass("selected");
        } else {
            $('input[type="checkbox"]', rows).prop("checked", false);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                buscarCtaQuitar(codigoUnico);
            });

            listarDeudaSeleccionada();
            //remove class selected
            $(rows).removeClass("selected");
        }
    });

    $("#chkPagarTodoArb").on("click", function () {
        var rows = tableArbitrios.rows().nodes();
        //select all rows
        if ($(this).is(":checked")) {
            $('input[type="checkbox"]', rows).prop("checked", true);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
            });

            listarDeudaSeleccionada();
            $(rows).addClass("selected");
        } else {
            $('input[type="checkbox"]', rows).prop("checked", false);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                buscarCtaQuitar(codigoUnico);
            });

            listarDeudaSeleccionada();
            $(rows).removeClass("selected");
        }
    });

    $("#chkPagarTodoCoac").on("click", function () {
        var rows = tableCoactivo.rows().nodes();
        //select all rows
        if ($(this).is(":checked")) {
            $('input[type="checkbox"]', rows).prop("checked", true);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
            });
            
            listarDeudaSeleccionada();
            $(rows).addClass("selected");
        } else {
            $('input[type="checkbox"]', rows).prop("checked", false);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                buscarCtaQuitar(codigoUnico);
            });

            listarDeudaSeleccionada();
            $(rows).removeClass("selected");
        }
    });



});
let dataSelectedIp = [];
let dataSelectedArb = [];

function listarDeudaSeleccionada() {
    var html = "";
    var total = 0;

    dataSelectedIp = [];
    dataSelectedArb = [];

    let dataAgrupada = dataSelected.reduce((acc, curr) => {
        // Inicializa el grupo si no existe
        if (!acc[curr.FADESTRIBU]) {
            acc[curr.FADESTRIBU] = { 
                tipo: '',
                total: 0, 
                coactivo: 0,
                data: []
            };
        }
        if(curr.facodtribu == 'IP'){
            dataSelectedIp.push(curr);
        }else if(curr.facodtribu == 'AR'){
            dataSelectedArb.push(curr);
        }
        // Suma el TOTAL al total de FADESTRIBU
        acc[curr.FADESTRIBU].total += parseFloat(curr.TOTAL);
        
        acc[curr.FADESTRIBU].tipo = curr.facodtribu;
        acc[curr.FADESTRIBU].data.push(curr);

        // Si fasitrecib es 'E' o 'T', acumula en coactivo
        if (curr.fasitrecib === 'E' || curr.fasitrecib === 'T') {
            acc[curr.FADESTRIBU].coactivo += parseFloat(curr.TOTAL);
        }
    
        return acc;
    }, {});
    
    // Recorrer agrupado
    for (const key in dataAgrupada) {
        if (Object.hasOwnProperty.call(dataAgrupada, key)) {
            const element = dataAgrupada[key];
            html += '<li class="list-group-item d-flex justify-content-between align-items-center">';
            html += "<div>";
            html += '<i class="fas fa-arrow-right text-muted me-2"></i>' + key;
            
            // Mostrar el valor de coactivo si es mayor a 0
            if (element.coactivo > 0) {
                html += "<div class='text-secondary font-10 fw-bold' style='padding-left: 25px;'></i>COACTIVO S/" + number_format(element.coactivo, 2) + "</div>";
            }/* else {
                html += "<div class='text-danger font-10 fw-bold'><i class='far fa-chart-bar me-2'></i>COACTIVO S/0.00</div>";
            }*/
            
            html += "</div>";
            html +=
                '<span class="text-dark">S/ ' +
                number_format(element.total, 2) +
                "</span>";
            html += "</li>";
            //     html += `<button type="button" class="btn btn-danger" onclick="procesarSeleccionTributo('${(element.tipo)}')"><i class="far fa-credit-card me-2"></i>Pagar S/ ${number_format(element.total, 2)}</button>`;
            // html += "</li>";
            total += element.total;
        }
    }

    if(total>0){
        $(".btn-procesar").removeClass('d-none');
        $(".contenedor-primero").addClass("ocultar");

        setTimeout(() => {
            $(".contenedor-segundo").css("display", "block");
            $(".contenedor-segundo").addClass("mostrar");
        }, 500);
        
    }else{
        $(".btn-procesar").addClass('d-none');

        $(".contenedor-primero").removeClass("ocultar");
        $(".contenedor-segundo").removeClass("mostrar");
        $(".contenedor-segundo").css("display", "none");
    }
    $(".MontoSeleccionado1").html(" S/. " + number_format(total,2));

    $("#deuda-seleccionada").html(html).fadeIn(500);
    $("#txtMontoSeleccion").val(total);
    $(".btn-procesar").html(`<i class="fas fa-check-circle font-16 me-2"></i> Pagar S/. ${number_format(total,2)}`);
}

function buscarCta(codigoUnico) {
    //si ya existe en dataSelected no lo agrega
    let existe = dataSelected.filter(function (item) {
        return item.key == codigoUnico;
    });
    if (existe.length > 0) {
        return [];
    }
    //agregar a dataSelected
    let tributo = dataCta.filter(function (item) {
        return item.key == codigoUnico;
    });
    if (tributo.length > 0) {
        return tributo;
    }else{
        return [];
    }
}

function buscarCtaQuitar(codigoUnico) {
    dataSelected = dataSelected.filter(function (item) {
        return item.key != codigoUnico;
    });
}
/***************************************************************************PROCESAR***********************************************/
// function procesarSeleccionTributo(tipo){
//     if(tipo == 'IP'){
//         procesarSeleccion(dataSelectedIp, tipo);
//     }else if(tipo == 'AR'){
//         procesarSeleccion(dataSelectedArb, tipo);
//     }
// }


$(".btn-procesar").on("click", function () {
    
    if(dataSelected.length == 0){
        return;
    }
    try {
        
        procesarSeleccion();

    } catch (error) {
        console.log(error);
    }
    
});

let dataResponseProcesar = {};

async function procesarSeleccion(){
    $("body").addClass("loader");

    let url = "pago-linea/procesar";
    let frm = new FormData();
    frm.append("data", JSON.stringify(dataSelected));
    //frm.append("tipo", tipo);

    await fetch(urljs+url, {
        method: "POST",
        body: frm,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    })
    .then(res=> res.json())
    .then(res => {
        if(res.code == 200){
            dataResponseProcesar = res;
            $("#tablaProcesar").DataTable().destroy();
            $("#tablaProcesar tbody").html('');

            var html = "";
            var total = 0;
            dataSelected.forEach(function (tributo) {
                html += "<tr>";
                html += "<td>" + tributo.FADESTRIBU + "</td>";
                html += "<td>" + tributo.faanotribu + "</td>";
                html += "<td>" + tributo.faperiodo + "</td>";
                html += "<td>" + moment(tributo.FECVENC).format("DD/MM/YYYY") + "</td>";
                html += "<td class='text-end'>" + number_format(tributo.VNFIMP01,2) + "</td>";
                html += "<td class='text-end'>" + number_format(tributo.VNFIMP03,2) + "</td>";
                html += "<td class='text-end'>" + number_format(tributo.VNFIMP04,2) + "</td>";
                html += "<td class='text-end'>" + number_format(tributo.fnmora,2) + "</td>";
                html += "<td class='text-end'>" + number_format(tributo.DESCUENTO,2) + "</td>";
                html += "<td class='text-end'>" + number_format(tributo.TOTAL,2) + "</td>";
                html += "</tr>";
                total += parseFloat(tributo.TOTAL);
            });
            
            $(".MontoSeleccionado").html(" S/. " + number_format(total,2));

            $("#tablaProcesar tbody").html(html);
            $("#tablaProcesar").DataTable({
                ordering: false,
                lengthChange: false,
                paging: true,
                searching: false,
                iDisplayLength: 10,
                //ADD GROUPING
                "columnDefs": [
                    { "visible": false, "targets": 0 }
                ],
                "order": [[0, 'asc']],
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({ page: 'current' }).nodes();
                    var last = '';
                    api.column(0, { page: 'current' }).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group bg-soft-blue"><td colspan="10">' + group + '</td></tr>'
                            );
                            last = group;
                        }
                    });
                }
            });

            OpenModal("#modalProcesar");
            setTimeout(() => {  
                $("body").removeClass("loader");
            }, 500);
        }else{
            $("body").removeClass("loader");
            console.log(res);
        }


    }).catch(err => {
        console.log(err);
        $("body").removeClass("loader");
    });
}

$("#btnPagarDeuda").on("click", function () {
    $("body").addClass("loader");
    OpenPago(dataResponseProcesar);
    $("body").removeClass("loader");
});

function OpenPago(gtpasarela) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    VisanetCheckout.configure({
        sessiontoken: gtpasarela.sessionKey,
        channel:gtpasarela.channel,
        merchantid:gtpasarela.merchantid,
        purchasenumber:gtpasarela.purchasenumber,
        amount:gtpasarela.amount,
        expirationminutes:'15',
        timeouturl:'/',
        merchantlogo:'https://virtual.muniancon.gob.pe/assets/images/logo-dark.png',
        // formbuttoncolor:'#000000',
        action:urljs+"pago-linea/finalizar-pago/"+gtpasarela.nro_operacion+"?_token="+csrfToken+"&amount="+gtpasarela.amount+"&purchasenumber="+gtpasarela.purchasenumber+"&codCheckout="+gtpasarela.codCheckout,
        usertoken:gtpasarela.token,
        //cardholdername:gtpasarela.pers_nombre,
        //cardholderlastname:gtpasarela.pers_apellido,
        //email:gtpasarela.pers_correo,
        complete: function(params) {
            $("body").removeClass("loader");
        }
    });
    VisanetCheckout.open();
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

$(".btn-pay").on('click', function(event) {
    event.preventDefault();
    console.log('cerradooo');
});

$("#chkAutorizo").on("click", function () {
    if ($(this).is(":checked")) {
        $("#btnPagarDeuda").prop("disabled", false);
    } else {
        $("#btnPagarDeuda").prop("disabled", true);
    }
});