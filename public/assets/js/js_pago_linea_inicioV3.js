let tabPredial, tabArbitr;
let dataCta = [];
let dataArb = [];
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
    dataCta = JSON.parse(localStorage.getItem("deuda"));
    dataArb = JSON.parse(localStorage.getItem("deuda_arb"));

    let anios_unicos = dataCta.map((item) => item.faanotribu).filter((value, index, self) => self.indexOf(value) === index);
    anios_unicos.sort((a, b) => b - a);

    let anexos = Object.values(dataArb).map(item => item.faanexo).filter((value, index, self) => self.indexOf(value) === index); 
    anexos.sort((a, b) => b - a);
    
    //ANIO_DESDE
    // let html = "";
    // anios_unicos.forEach((anio) => {
    //     html += `<option value="${anio}">${anio}</option>`;
    // });
    // $("#ANIO_DESDE").html(html);
    // $("#ANIO_HASTA").html(html);
    

    let htmlanexos = "";
    anexos.forEach((anexo) => {
        htmlanexos += `<option value="${anexo}">${anexo}</option>`;
    });
    $("#CMB_ANEXO").html(htmlanexos);
    $('#CMB_ANEXO').multiSelect({
        noneText: 'Seleccione Anexo'
    });
    /**************************************************************************Predial***************************************/

    var tableImpuesto = $("#tablaIp").DataTable({
        ordering: false,
        lengthChange: false,
        paging: false,
        searching: false,
        iDisplayLength: 6,
        scrollY: "500px",
        bLengthChange: true,
        "bInfo" : false,
        columnDefs: [
            { responsivePriority: 1, targets: 0 }, //concepto
            { responsivePriority: 1, targets: 9 }, //total
            { responsivePriority: 2, targets: -1 }, //Check siempre
            {
                targets: [1],
                visible: false
            }
        ],
        rowGroup: {
            dataSrc: [1], 
            startRender: function (rows, group) {
                return $("<tr/>")
                    .append("<td colspan='9' class='text-start'><strong>" + group + "</strong></td><td style='background: none;'></td>");
            },
            endRender: function (rows, group) {
                var total = rows
                    .data()
                    .pluck(9) 
                    .reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0);
                return $("<tr/>")
                    .append("<td colspan='9' class='text-end text-dark' style='background: none;'>Total: S/. " + number_format(total, 2) + "</td><td style='background: none;'></td>");
            },
        },
    });

 /**************************************************************************Arbitrios***************************************/

    var tableArbitrios = $("#tablaArb").DataTable({
        ordering: false,
        lengthChange: false,
        paging: false,
        searching: true,
        iDisplayLength: 10,
        scrollY: "600px",
        bLengthChange: false,
        "bInfo" : false,
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
                        return a + parseFloat(b);
                    }, 0);
                return $("<tr/>")
                    .append("<td colspan='9' class='text-end text-dark' style='background: none;'>Total: S/. " + number_format(total, 2) + "</td><td style='background: none;'></td>");
            },
        },
        columnDefs: [
            { responsivePriority: 1, targets: 0 }, //Check siempre
            { responsivePriority: 1, targets: 9 },
            { responsivePriority: 3, targets: -1 }, //Check
            {
                targets: [10,1],
                visible: false
            }
        ],
    });

    /**************************************************************************COACTIVO***************************************/
    var tableCoactivo = $("#tablaCoac").DataTable({
        ordering: false,
        lengthChange: false,
        paging: false,
        searching: false,
        iDisplayLength: 10,
        scrollY: "500px",
        bLengthChange: false,
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
                        return a + parseFloat(b);
                    }, 0);
                return $("<tr/>")
                    .append("<td colspan='9' class='text-end text-dark' style='background: none;'>Total: S/. " + number_format(total, 2) + "</td><td style='background: none;'></td>");
            },
        },
        columnDefs: [
            { responsivePriority: 1, targets: 0 }, //concepto
            { responsivePriority: 1, targets: 9 }, //total
            { responsivePriority: 3, targets: -1 }, //Check siempre
            {
                targets: [10,1],
                visible: false
            }
        ],
    });
    
    /********************************************MONTO TOTAL PARA BOTON ACCESO DIRECTO **************************************/
    var totalCoactivo = 0;
    totalCoactivo = tableCoactivo.column(9).data().reduce(function (a, b) {
        return a + parseFloat(b);
    }, 0);
    
    var totalIpTable = 0;
    totalIpTable = tableImpuesto.column(9).data().reduce(function (a, b) {
        return a + parseFloat(b);
    }, 0);    

    var totalArbTable = 0;
    totalArbTable = tableArbitrios.column(9).data().reduce(function (a, b) {
        return a + parseFloat(b);
    }, 0);
    
    let totalGeneral = totalIpTable + totalArbTable + totalCoactivo;


    var totalVencidos = 0;
    var dataVencidos = dataCta.filter(function (item) {
        return moment(item.FECVENC).isBefore(moment());
    });

    totalVencidos = dataVencidos.reduce(function (a, b) {
        return a + parseFloat(b.TOTAL);
    }, 0);


    //actualizarTotalYMostrarBoton(totalIpTable, "#txtTotalPagarIP", "#btn-pagar-ip");
    //actualizarTotalYMostrarBoton(totalArbTable, "#txtTotalPagarABR", "#btn-pagar-arb");
    actualizarTotalYMostrarBoton(totalCoactivo, "#txtTotalPagarCOAC", "#btn-pagar-coac");
    
    actualizarTotalYMostrarBoton(totalVencidos, "#txtTotalPagarVenc", "#btn-pagar-venc");
    actualizarTotalYMostrarBoton(totalGeneral, "#txtTotalPagarTodo", "#btn-pagar-todo");


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

        if ($(this).is(":checked")) {
            dataSelected.push(...buscarCta(codigoUnico));
            $(this).closest("tr").addClass("selected");
        }
        else {
            buscarCtaQuitar(codigoUnico);
            $(this).closest("tr").removeClass("selected");
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

    $("#btn-pagar-todo").on("click", function () {

        if($(this).is(":checked")){
            var rows = tableImpuesto.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", true);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
            });
            $(rows).addClass("selected");

            var rows = tableArbitrios.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", true);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
            });
            $(rows).addClass("selected");

            var rows = tableCoactivo.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", true);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
            });
            $(rows).addClass("selected");
            showMessage('success','Excelente, se acaba de agregar el monto total a pagar','Correcto');

            $("label[for='btn-pagar-ip']").addClass("disabled");
            $("label[for='btn-pagar-arb']").addClass("disabled");
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
            
            var rows = tableArbitrios.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", false);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                buscarCtaQuitar(codigoUnico);
            });
            $(rows).removeClass("selected");

            var rows = tableCoactivo.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", false);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                buscarCtaQuitar(codigoUnico);
            });
            $(rows).removeClass("selected");
            showMessage('success','Excelente, se acaba de quitar el monto total a pagar','Correcto');

            $("label[for='btn-pagar-ip']").removeClass("disabled");
            $("label[for='btn-pagar-arb']").removeClass("disabled");
            $("label[for='btn-pagar-coac']").removeClass("disabled");

            listarDeudaSeleccionada();
        }

        
    });

    $("#btn-pagar-ip").on("click", function () {
        if($(this).is(":checked")){
            var rows = tableImpuesto.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", true);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
            });
            $(rows).addClass("selected");
            showMessage('success','Excelente, se acaba de agregar el monto total de Predial','Correcto');
            listarDeudaSeleccionada();
        }else{
            var rows = tableImpuesto.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", false);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                buscarCtaQuitar(codigoUnico);
            });
            $(rows).removeClass("selected");
            showMessage('success','Excelente, se acaba de quitar el monto total de Predial','Correcto');
            listarDeudaSeleccionada();
        }
    });

    $("#btn-pagar-arb").on("click", function () {
        if($(this).is(":checked")){
            var rows = tableArbitrios.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", true);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
            });
            $(rows).addClass("selected");
            showMessage('success','Excelente, se acaba de agregar el monto total de Arbitrios','Correcto');
            listarDeudaSeleccionada();
        }else{
            var rows = tableArbitrios.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", false);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                buscarCtaQuitar(codigoUnico);
            });
            $(rows).removeClass("selected");
            showMessage('success','Excelente, se acaba de quitar el monto total de Arbitrios','Correcto');
            listarDeudaSeleccionada();
        }
    });

    $("#btn-pagar-coac").on("click", function () {
        if($(this).is(":checked")){
            var rows = tableCoactivo.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", true);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                dataSelected.push(...buscarCta(codigoUnico));
            });
            $(rows).addClass("selected");
            showMessage('success','Excelente, se acaba de agregar el monto total de Coactivo','Correcto');
            listarDeudaSeleccionada();
        }else{
            var rows = tableCoactivo.rows().nodes();
            $('input[type="checkbox"]', rows).prop("checked", false);
            $('input[type="checkbox"]', rows).each(function () {
                let codigoUnico = $(this).attr("codigo");
                buscarCtaQuitar(codigoUnico);
            });
            $(rows).removeClass("selected");
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
                    if (dataVencidos.some(tributo => tributo.key == codigoUnico)) {
                        $(this).prop("checked", true).closest('tr').addClass("selected");
                    }
                });
            }
    
            marcarChecks(tableImpuesto);
            marcarChecks(tableArbitrios);
            marcarChecks(tableCoactivo);
    
            showMessage('success', 'Excelente, se acaba de agregar el monto total de Vencidos', 'Correcto');
            listarDeudaSeleccionada();
        } else {
            dataVencidos.forEach(function (tributo) {
                buscarCtaQuitar(tributo.key);
            });
    
            function desmarcarChecks(table) {
                var rows = table.rows().nodes();
                $('input[type="checkbox"]', rows).each(function () {
                    let codigoUnico = $(this).attr("codigo");
                    if (dataVencidos.some(tributo => tributo.key == codigoUnico)) {
                        $(this).prop("checked", false).closest('tr').removeClass("selected");
                    }
                });
            }
            desmarcarChecks(tableImpuesto);
            desmarcarChecks(tableArbitrios);
            desmarcarChecks(tableCoactivo);
    
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