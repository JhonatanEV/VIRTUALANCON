$(document).ready(function() {
    dataAnno("NU_ANN",2023);
    soloNumeros("#NU_EMI");

});
$("#btnSearchExpediente").click(function() {
    getSeguimiento();
});

function getSeguimiento() {
    var NU_ANN = getValue('NU_ANN');
    var NU_EMI = getValue('NU_EMI');
    var TIPO = getValue('TIPO_BUSQUEDA');
    //var data = `NU_ANN=${NU_ANN}&NU_EMI=${NU_EMI}&TIPO=${TIPO}`; 
    //let url = 'seguimiento/gettramites?'+data;
    let url = 'seguimiento/gettramites';
   
    var data = new FormData();
    data.append('NU_ANN', NU_ANN);
    data.append('NU_EMI', NU_EMI);
    data.append('TIPO', TIPO);

    envioAjaxdata(url, data,function(resp) {
    //fetchGet(url, function(resp) {
        let cabecera = resp.cabecera;
        let html = '';
        if(cabecera.length > 0){
            html +=`
            <table width="100%" class="table">
                <tr><td><b>REMITENTE</b></td><td>: ${cabecera[0].datRemitente}</td></tr>
            </table>
            <div class="accordion" id="accordionExample">`;
            for(let i = 0; i < cabecera.length; i++) {
                const element = cabecera[i];
                html +=`
                    <div class="accordion-item">
                        <h5 class="accordion-header m-0" id="headingThree${i}">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#collapseThree${i}" 
                            aria-expanded="false" 
                            aria-controls="collapseThree${i}"
                            onclick="getDetalleSeguimiento('${element.numExpediente}',${i})">
                            <table width="100%" class="table">
                            <tr><td><b>${element.Tipo_Expediente}</b></td><td>: N° ${element.numExpediente}</td></tr>
                            <tr><td><b>ASUNTO</b></td><td>: ${element.Asunto}</td></tr>
                            <tr><td><b>FECHA INGRESO</b></td><td>: ${element.Fecha_Registro}</td></tr>
                            </table>
                            </button>
                        </h5>
                        <div id="collapseThree${i}" class="accordion-collapse collapse" aria-labelledby="headingThree${i}" data-bs-parent="#accordionExample">
                            <div class="accordion-body detalle_seguimiento_${i}">
                            </div>
                        </div>
                    </div>`;
            }
            html +=`</div>`;
            $('#conte_detalle_expediente').html(html);
        }else {
            $('#conte_detalle_expediente').html('<div class="alert alert-warning">No se encontraron resultados</div>');
        }
        
    });
}

function getDetalleSeguimiento(NU_EXPE,codigo){

    let url = 'seguimiento/getSeguimiento';
    var data = new FormData();
    data.append('NU_EXPE', NU_EXPE);

    envioAjaxdata(url, data,function(resp) {
        console.log(resp);
    //fetchGet(url, function(resp) {
        let detalle = resp.detalle;
        if (detalle.length > 0) {
            let total = detalle.length;
            let contenido = '';
            n=1;
            for (let i = 0; i < detalle.length; i++) {
                const element = detalle[i];
                contenido +=`
    <fieldset class="scheduler-border border border-2 p-2 mt-2" style="width: 99%">
        <legend class="scheduler-border float-lg-none w-auto font-11 bg-light p-1">Fecha Movimiento :<b>${element.TRAMITE_FECHA_INGRESO}</b></legend>
        <div class="row">
            <div class="form-group col-md-9 font-14">
            <label for="txt_desde"><b>Área</b></label><br>
            ${element.DE_DEPENDENCIA} <br>
            ${element.COPIASNOM ? `
                <label for="txt_desde" style="color: grey; font-size: 10px;"><b>CC:</b></label> 
                <span style="color: grey; font-size: 10px;">
                ${Array.isArray(element.COPIASNOM) ? element.COPIASNOM.join(", ") : element.COPIASNOM}
                </span>` : ''}
            </div>
            
        </div>
        <div class="form-group col-md-9 font-14" >
            <label for="txt_desde" style="color: grey; font-size: 10px;"><b>Estado:</b></label> 
            <span style="color: grey; font-size: 10px;">
                <strong>${element.TRAMITE_DE_EST2}</strong>
            </span> 
        </div>

        <div class="row">
            <div class="form-group col-md-12 font-14">
            <label for="txt_desde"><b>${element.TRAMITE_DESDOC}</b></label><br>
            ${element.TRAMITE_NU_DOC}              
            </div>
        </div>

    </fieldset>
`;

                n++;
            }
            $('.detalle_seguimiento_'+codigo).html(contenido);
        } else {
            $('.detalle_seguimiento_'+codigo).html('<div class="alert alert-warning">No se encontraron resultados</div>');
        }
        
    });
}
$("#NU_EMI").keypress(function(e) {
    if (e.which == 13) {
        getSeguimiento();
    }
});

$("#TIPO_BUSQUEDA").change(function() {
    var value = $(this).val();
    if(value == 2){
        $("#NU_EMI").attr('maxlength', '8');
    }else{
        $("#NU_EMI").attr('maxlength', '12');
    }
});