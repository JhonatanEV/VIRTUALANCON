let tabPredial, tabArbitr;
let dataCta = [];
let dataArb = [];
let dataCoac = [];

let dataSelected = [];
let totalSeleccionado = 0;
let totalIp = 0;
let totalArb = 0;
let totalCoac = 0;

$(document).ready(function () {
    dataCta = JSON.parse(localStorage.getItem("deuda"));
    //dataArb = JSON.parse(localStorage.getItem("deuda_arb"));
    //dataCoac = JSON.parse(localStorage.getItem("deuda_coac"));

    let anios_unicos = dataCta.map((item) => item.cperanio).filter((value, index, self) => self.indexOf(value) === index);
    anios_unicos.sort((a, b) => b - a);

    let anexos = Object.values(dataCta).map(item => item.cidpred).filter((value, index, self) => self.indexOf(value) === index); 
    anexos.sort((a, b) => b - a);

    let htmlanexos = `<option value="1">Impuesto Predial</option>`;
    anexos.forEach((anexo) => {
        if(anexo!='0000'){
            htmlanexos += `<option value="${anexo}">Anexo ${anexo}</option>`;
        }
    });
    $("#CMB_ANEXO").html(htmlanexos);
    $('#CMB_ANEXO').multiSelect({
        noneText: 'Seleccione Anexo'
    });
    /*****************************************************************************************************************/


    var tableImpuesto = $("#tablaTodos").DataTable({
        ordering: false,
        lengthChange: false,
        paging: false,
        searching: true,
        iDisplayLength: 10,
        scrollY: "800px",
        bLengthChange: false,
        "bInfo" : false,
        responsive: true,
        rowGroup: {
            dataSrc: [10,1],
            startRender: function (rows, group) {
                return $("<tr/>")
                    .append("<td colspan='9' class='text-start'><strong>" + group + "</strong></td><td style='background: none;'></td>");
            },
            endRender: function (rows, group) {
                var total = rows
                    .data()
                    .pluck(9)
                    .reduce(function (a, b) {
                        var number = parseFloat(b.replace(/,/g, ''));
                        return a + (isNaN(number) ? 0 : number);
                    }, 0);
                return $("<tr/>")
                    .append("<td colspan='9' class='text-end text-dark' style='background: none;'>Total: S/. " + number_format(total, 2) + "</td><td style='background: none;'></td>");
            },
        },
        columnDefs: [
            { responsivePriority: 1, targets: [2,9,11,12] },
            { responsivePriority: 1, targets: -1 },
            {
                targets: [10,1],
                visible: false
            },
            {
                targets: 11,
                className: window.matchMedia("(max-width: 767px)").matches ? "d-md-table-cell" : "d-none",
            },
            {
                targets: [0,4,5,6,7,8],
                visible: window.matchMedia("(max-width: 767px)").matches ? false : true,
            },
            {
                targets: 2, // Índice de la columna
                width: "5%" // Ancho de la columna
            }
        ],
    });

    $("#CMB_ANEXO").on("change", function () {
        var anexos = $(this).val();
        tableImpuesto.column(10).search(anexos.join("|"), true, false).draw();
    });

    /**************************************************************************COACTIVO***************************************/
    
    
    /********************************************MONTO TOTAL PARA BOTON ACCESO DIRECTO **************************************/
    var totalCoactivo = 0;
    dataCoac = dataCta.filter(function (item) {
        return item.ESTADO_DEUDA == 'C';
    });
    totalCoactivo = dataCoac.reduce(function (a, b) {
        return a + parseFloat(b.total);
    }, 0);


    var totalVencidos = 0;
    var dataVencidos = dataCta.filter(function (item) {
        return moment(item.dfecven).isBefore(moment());
    });

    totalVencidos = dataVencidos.reduce(function (a, b) {
        return a + parseFloat(b.total);
    }, 0);

    var totalGeneral = 0;
    totalGeneral = dataCta.reduce(function (a, b) {
        return a + parseFloat(b.total);
    }, 0);

    actualizarTotalYMostrarBoton(totalCoactivo, "#txtTotalPagarCOAC", "#btn-pagar-coac");
    
    actualizarTotalYMostrarBoton(totalVencidos, "#txtTotalPagarVenc", "#btn-pagar-venc");
    actualizarTotalYMostrarBoton(totalGeneral, "#txtTotalPagarTodo", "#btn-pagar-todo");


    function actualizarTotalYMostrarBoton(total, selectorTexto, selectorBoton) {
        const totalFormateado = number_format(total, 2);
        $(selectorTexto).html(`S/. ${totalFormateado}`);
        
        // Ocultar o mostrar el botón según el total
        if (total <= 0) {
            $(selectorBoton).hide();
            $("label[for='"+selectorBoton.replace('#','')+"']").hide();
        } else {
            $(selectorBoton).show();
            $("label[for='"+selectorBoton.replace('#','')+"']").show();
        }
    }
    /**************************************************************************Arbitrios***************************************/


    $("#deuda-select-all").on("click", function () {
        var rows = tableImpuesto.rows({
            'search': 'applied'
        }).nodes();

        if ($(this).is(":checked")) {
            tableImpuesto
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
            
            tableImpuesto
                .rows({ search: "applied" })
                .nodes()
                .to$()
                .find(".mis-tributos")
                .prop("checked", false);

            $(rows).removeClass("selected");
        }
        listarDeudaSeleccionada();
    });

    $("#tablaTodos").on("click", ".mis-tributos", function () {
        let codigoUnico = $(this).attr("codigo");
        
        if ($(this).is(":checked")) {
            dataSelected.push(...buscarCta(codigoUnico));
            $(this).closest("tr").addClass("selected");
        } else {            
            buscarCtaQuitar(codigoUnico);
            $(this).closest("tr").removeClass("selected");
        }
        $(this).blur();
        listarDeudaSeleccionada();
    });


    $("#loader-overlay").fadeOut();

    $("#btn-pagar-todo").on("click", function () {

        if($(this).is(":checked")){
  
            var rows = tableImpuesto.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", true);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
            });
            $(rows).addClass("selected");

            showMessage('success','Excelente, se acaba de agregar el monto total a pagar','Correcto');
            $("label[for='btn-pagar-venc']").addClass("disabled");
            $("label[for='btn-pagar-coac']").addClass("disabled");

            listarDeudaSeleccionada();
        }else{
           
            
            var rows = tableImpuesto.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", false);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                buscarCtaQuitar(codigoUnico);
            });
            $(rows).removeClass("selected");

            showMessage('success','Excelente, se acaba de quitar el monto total a pagar','Correcto');

            $("label[for='btn-pagar-venc']").removeClass("disabled");
            $("label[for='btn-pagar-coac']").removeClass("disabled");

            listarDeudaSeleccionada();
        }

        
    });


    $("#btn-pagar-coac").on("click", function () {
        if($(this).is(":checked")){
           //buscar key de coactivo en dataCoac y agregar a dataSelected
            dataCoac.forEach(function (tributo) {
                dataSelected.push(tributo);
            });
            //marcar checks de coactivo
            function marcarChecks(table) {
                var rows = table.rows().nodes();
                $('input[type="checkbox"]', rows).each(function () {
                    let codigoUnico = $(this).attr("codigo");
                    if (dataCoac.some(tributo => tributo.llave == codigoUnico)) {
                        $(this).prop("checked", true).closest('tr').addClass("selected");
                    }
                });
            }
            marcarChecks(tableImpuesto);
            showMessage('success','Excelente, se acaba de agregar el monto total de Coactivo','Correcto');
            listarDeudaSeleccionada();
        }else{
            dataCoac.forEach(function (tributo) {
                buscarCtaQuitar(tributo.llave);
            });
            function desmarcarChecks(table) {
                var rows = table.rows().nodes();
                $('input[type="checkbox"]', rows).each(function () {
                    let codigoUnico = $(this).attr("codigo");
                    if (dataCoac.some(tributo => tributo.llave == codigoUnico)) {
                        $(this).prop("checked", false).closest('tr').removeClass("selected");
                    }
                });
            }
            desmarcarChecks(tableImpuesto);
            showMessage('success','Excelente, se acaba de quitar el monto total de Coactivo','Correcto');
            listarDeudaSeleccionada();
        }
    });

    $("#btn-pagar-venc").on("click", function () {
        if ($(this).is(":checked")) {
            dataVencidos.forEach(function (tributo) {
                dataSelected.push(tributo);
            });
    
            function marcarChecks(table) {
                var rows = table.rows().nodes();
                $('input[type="checkbox"]', rows).each(function () {
                    let codigoUnico = $(this).attr("codigo");
                    if (dataVencidos.some(tributo => tributo.llave == codigoUnico)) {
                        $(this).prop("checked", true).closest('tr').addClass("selected");
                    }
                });
            }
    
            marcarChecks(tableImpuesto);
    
            showMessage('success', 'Excelente, se acaba de agregar el monto total de Vencidos', 'Correcto');
            listarDeudaSeleccionada();
        } else {
            dataVencidos.forEach(function (tributo) {
                buscarCtaQuitar(tributo.llave);
            });
    
            function desmarcarChecks(table) {
                var rows = table.rows().nodes();
                $('input[type="checkbox"]', rows).each(function () {
                    let codigoUnico = $(this).attr("codigo");
                    if (dataVencidos.some(tributo => tributo.llave == codigoUnico)) {
                        $(this).prop("checked", false).closest('tr').removeClass("selected");
                    }
                });
            }
            desmarcarChecks(tableImpuesto);
    
            showMessage('success', 'Excelente, se acaba de quitar el monto total de Vencidos', 'Correcto');
            listarDeudaSeleccionada();
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
        if (!acc[curr.vdescri]) {
            acc[curr.vdescri] = { 
                tipo: '',
                total: 0, 
                coactivo: 0,
                data: []
            };
        }
        if(curr.ctiping == '0000000273'){
            dataSelectedIp.push(curr);
        }else if(curr.ctiping == '0000000278'){
            dataSelectedArb.push(curr);
        }
        // Suma el TOTAL al total de vdescri
        acc[curr.vdescri].total += parseFloat(curr.total);
        
        acc[curr.vdescri].tipo = curr.ctiping;
        acc[curr.vdescri].data.push(curr);

        // Si fasitrecib es 'E' o 'T', acumula en coactivo
        if (curr.fasitrecib === 'E' || curr.fasitrecib === 'T') {
            acc[curr.vdescri].coactivo += parseFloat(curr.total);
        }
    
        return acc;
    }, {});
    // Recorrer agrupado
    for (const key in dataAgrupada) {
        if (Object.hasOwnProperty.call(dataAgrupada, key)) {
            const element = dataAgrupada[key];
            html += '<li class="list-group-item d-flex justify-content-between align-items-center">';
            html += "<div class='font-10'>";
            html += '<i class="fas fa-arrow-right text-muted me-2"></i>' + key;
            
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
        return item.llave == codigoUnico;
    });
    if (existe.length > 0) {
        return [];
    }
    //agregar a dataSelected
    let tributo = dataCta.filter(function (item) {
        return item.llave == codigoUnico;
    });
    if (tributo.length > 0) {
        return tributo;
    }else{
        return [];
    }
}

function buscarCtaQuitar(codigoUnico) {
    dataSelected = dataSelected.filter(function (item) {
        return item.llave != codigoUnico;
    });
}
/***************************************************************************PROCESAR***********************************************/

$(".btn-procesar").on("click", function () {
    
    if(dataSelected.length == 0){
        return;
    }
    try {
        $("#loadingSpinner").hide();
        $("#btnPagarDeuda").prop("disabled", false);
        $("#dataParaPagar").show();
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
    frm.append("total", $("#txtMontoSeleccion").val());

    await fetch(urljs+url, {
        method: "POST",
        body: frm,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    })
    .then(res=> res.json())
    .then(res => {
        if(res.code == 200){
            
            let dataArray = res.data
            dataResponseProcesar = res;
            $("#tablaProcesar").DataTable().destroy();
            $("#tablaProcesar tbody").html('');

            var html = "";
            var total = 0;
            let total_descuento = 0;
            let subtotal = 0;
            let tributodetalle = '';
            dataArray.forEach(function (tributo) {

                if(tributo.ctiping == '0000000278'){
                    tributodetalle = tributo.vdescri;
                }else{
                    tributodetalle = 'ANEXO: '+tributo.cidpred+' - '+tributo.vdescri;
                }

                html += "<tr>";
                html += "<td class='white-space'>" + tributodetalle + "</td>";
                html += "<td>" + tributo.cperanio + "</td>";
                html += "<td>" + tributo.cperiod + "</td>";
                html += "<td class='text-end'>" + number_format(tributo.total ?? 0,2) + "</td>";
                html += "<td class='text-end'>" + number_format(0,2) + "</td>";
                html += "<td class='text-end'>" + number_format(tributo.total,2) + "</td>";
                html += "</tr>";
                subtotal += parseFloat(tributo.total);
                total += parseFloat(tributo.total);
                total_descuento += parseFloat(0);
            });
            
            $(".MontoSeleccionado").html(`<h4 class="text-danger font-15">SubTotal: S/ ${number_format(subtotal,2)}</h4>
                <h4 class="text-success font-13">Dscto: S/ ${number_format(total_descuento,2)}</h4><hr>
                <h4 class="text-blue fw-bold">Total a pagar S/. ${number_format(total,2)}</h4>`);

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
                rowGroup: {
                    dataSrc: [0],
                    startRender: function (rows, group) {
                        return $("<tr/>")
                            .append("<td colspan='6' class='text-start'><strong>" + group + "</strong></td>");
                    }
                },
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

    let url = "pago-linea/valida-cuenta";
    let frm = new FormData();
    
    frm.append("codCheckout", dataResponseProcesar.codCheckout);
    frm.append("amount", dataResponseProcesar.amount);
    frm.append("purchasenumber", dataResponseProcesar.purchasenumber);

    fetch(urljs+url, {
        method: "POST",
        body: frm,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    })
    .then(res=> res.json())
    .then(res => {
        if(res.code == 200){
            $(this).prop("disabled", true);

            $("#loadingSpinner").show();
            $("#dataParaPagar").hide();

            OpenPago(res);

            $("body").removeClass("loader");
        }else{
            $("body").removeClass("loader");
            showMessageAlert("Error", res.mensaje, "error",function(){
                // location.reload();
            });
        }
    }).catch(err => {
        console.log(err);
        $("body").removeClass("loader");
    });
    
    
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
        cardholderemail:gtpasarela.pers_correo,
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