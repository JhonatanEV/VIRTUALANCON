<div id="loader-overlay" 
        style="position: fixed;
            width: 100%;
            height: 100%;
            background: rgb(225 229 231);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            left: 0;"
>
    <div id="loader">Cargando...</div>
</div>

<div class="row justify-content-center">
    <div class="col-md-2">
        <div class="button-slider">

            <input type="checkbox" class="btn-check" id="btn-pagar-todo" autocomplete="off">
            <label class="btn btn-outline-success btn-lg btn-acceso fw-bold me-2" for="btn-pagar-todo">
                <i class="me-2">👉</i>Pagar Todo <strong id="txtTotalPagarTodo">S/. 00.00</strong>
            </label>
            
            <input type="checkbox" class="btn-check" id="btn-pagar-venc" autocomplete="off">
            <label class="btn btn-outline-primary btn-lg btn-acceso fw-bold me-2" for="btn-pagar-venc">
                <i class="me-2">👉</i>Pagar deuda vencida predial / arbitrios <strong id="txtTotalPagarVenc">S/. 00.00</strong>
            </label>
        </div>
        <div class="alert alert-warning alert-dismissible fade show border-0 mb-0" role="alert">
            <strong>Nota!</strong>  Para acogerse a beneficio vigente, selecciona la deuda a pagar y continua con el proceso. En resumen, de su pago se visualizará los descuentos vigentes
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <div class="col-md-8 contenedor-primero">
        <div class="card border-0">
            <div class="card-header">
                <h4 class="card-title">Hola, <b>{{ trim($contribuyente->vnombre ?? '') }}</b> con codigo <b>{{ $contribuyente->idsigma ?? ''}}</b></h4>
                <p class="text-muted mb-0">Seleccione tipos de tributo para ver su deuda pendiente a pagar.</p>
            </div>
            <div class="card-body p-0">
                    <div class="row">
                        <div class="col-sm-8">
                            <span class="titulo-tributo text-decoration-underline fw-bold text-muted">DEUDAS PENDIENTES</span>
                        </div>
                        <div class="col-sm-4 text-end">
                            <div class="form-floating">
                                <select class="form-select form-select-sm" id="CMB_ANEXO" multiple>
                                <option value="">-- Seleccione --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                    <table id="tablaTodos" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead style="background-color: #6464644f;">
                            <tr>
                                <th class="text-center fw-bold">TRIBUTO</th>
                                <th class="text-center fw-bold">AÑO</th>
                                <th class="text-center fw-bold">PER.</th>
                                <th class="text-center fw-bold">F. VENC</th>
                                <th class="text-center fw-bold">SITUACIÓN</th>
                                <th class="text-center fw-bold">INSOLUTO</th>
                                <th class="text-center fw-bold">REAJUSTE</th>
                                <th class="text-center fw-bold">EMISIÓN</th>
                                <th class="text-center fw-bold">MORA</th>
                                <th class="text-center fw-bold">TOTAL</th>
                                <th class="text-center fw-bold">ANEXO</th>
                                <th class="text-center fw-bold">SITU.</th>
                                <th>
                                    <div class="col-md">
                                        <input type="checkbox" class="btn-check" id="deuda-select-all" autocomplete="off">
                                        <label class="btn btn-outline-info btn-sm" for="deuda-select-all"><i class="fas fa-check"></i>Marcar</label><br>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allEcuenta as $ecuenta)

                                @if($ecuenta['abrev_tributo'] == 'IP')
                                    @php
                                        $tributo = $ecuenta['nom_tributo'];
                                    @endphp
                                @else
                                    @php
                                        $tributo = 'ANEXO: '.$ecuenta['cod_pred'].' - '.$ecuenta['nom_tributo'];
                                    @endphp
                                @endif

                            <tr>
                                <td class="dtr-control">{{ $ecuenta['nom_tributo'] }}</td>
                                <td class="text-end">{{ $ecuenta['anio'] }}</td>
                                <td class="text-end">{{ $ecuenta['periodo'] }}</td>
                                <td class="text-end">{{ \Carbon\Carbon::parse($ecuenta['fecha_vencimiento'])->format('d/m/Y') }}</td>
                                <td class="text-end fw-bold">{{ $ecuenta['estado'] }}</td>
                                <td class="text-end">{{ number_format($ecuenta['imp_insol'],2) }}</td>
                                <td class="text-end">{{ number_format($ecuenta['reajuste'],2) }}</td>
                                <td class="text-end">{{ number_format($ecuenta['costo_emis'],2) }}</td>
                                <td class="text-end">{{ number_format($ecuenta['mora'],2) }}</td>
                                <td class="text-end total-pie-tabla">{{ number_format($ecuenta['total'],2) }}</td>
                                <td>{{ $tributo }}</td>
                                <td class="text-end">{{ $ecuenta['situacion'] }}</td>
                                <td class="text-center">
                                    <div class="col-md">
                                        <input 
                                        type="checkbox" 
                                        class="form-check-input font-24 mis-tributos" 
                                        name="recibo[]" 
                                        id="recibo{{ $ecuenta['llave'] }}" 
                                        autocomplete="off" 
                                        precio-trib="{{ $ecuenta['total'] }}"
                                        codigo="{{ $ecuenta['llave'] }}"
                                        value="1">
                                        {{-- <label class="btn btn-outline-info btn-sm text-white" for="recibo{{ $ecuenta['llave'] }}">
                                            <i class="fas fa-check"></i>
                                        </label> --}}
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
    </div>
    <div class="col-md-2 contenedor-segundo" style="display: none;">
        <div class="row" style="position: sticky;top: 58px;">
            <div class="col-lg-12">
                <ul class="list-group">
                    <li class="list-group-item text-center justify-content-between align-items-center bg-blue">
                        <div>
                            <span class="text-white"> <i class="fas fa-shopping-cart text-white font-20 me-2"></i> Monto Total:</span>
                        </div>
                        <span class="text-white font-18 fw-bold MontoSeleccionado1">S/ 0.00</span>
                        <input type="hidden" name="txtMontoSeleccion" id="txtMontoSeleccion" value="0">
                    </li>
                    <div id="deuda-seleccionada">
                        
                    </div>
                    <li class="list-group-item d-flex justify-content-center align-items-center">
                        <div>
                            <button class="btn btn-success btn-round text-white btn-procesar d-none btn-xl"> <i class="fas fa-check-circle font-16 me-2"></i>Pagar S/. 00.00</button>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
<div>
    <div class="contenedor-procesar">
    <button type="button" class="btn btn-success btn-round btn-lg btn-procesar"><i class="fas fa-check-circle font-16 me-2"></i>Pagar S/. 00.00</button>
    </div>
</div>

<div class="modal fade" id="modalProcesar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue p-2">
                <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Procesar mis deudas seleccionadas - <b>{{ Session::get('SESS_NOMBRE_COMPLETO') }}</b></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 text-center align-self-center">
                        <div class="card border-0">
                            <div class="card-body">
                                <div id="loadingSpinner" class="text-center mb-3" style="display: none;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Cargando...</span>
                                    </div>
                                    <p>Procesando, por favor espere...</p>
                                </div>

                                <div class="row" id="dataParaPagar">
                                    <div class="col-lg-8">
                                        <table id="tablaProcesar" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead style="background-color: #6464644f;">
                                                <tr>
                                                    <th class="text-center fw-bold">TRIBUTO</th>
                                                    <th class="text-center fw-bold">AÑO</th>
                                                    <th class="text-center fw-bold">PER.</th>
                                                    <th class="text-end fw-bold">SUB TOTAL</th>
                                                    <th class="text-end fw-bold">DESCUENTO</th>
                                                    <th class="text-end fw-bold">TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-4 mt-4">
                                        <div class="bg-light p-4 rounded shadow-sm">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="chkAutorizo" checked>
                                                <label class="form-check-label" for="chkAutorizo">
                                                    Acepto <a href="./terminos-y-condiciones" class="text-primary" target="_blank">Términos y condiciones</a>
                                                </label>
                                            </div>
                                            <h5 class="text-secondary">Monto Total a Pagar</h5>
                                            <h3 class="text-danger fw-bold MontoSeleccionado">S/ 0.00</h3>
                                            <button type="button" class="btn btn-success btn-lg w-100 mt-3" id="btnPagarDeuda">
                                                <i class="far fa-credit-card me-2"></i> Pagar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">                                                    
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script src="https://static-content.vnforapps.com/v2/js/checkout.js"></script>
<!-- <script src="https://static-content-qas.vnforapps.com/v2/js/checkout.js?qa=true"></script> -->
<script>
    $(document).ready(function() {
        let allaEcuenta = @json($allEcuenta);

        if (localStorage.getItem('deuda')) {
            localStorage.removeItem('deuda');
        }
        localStorage.setItem('deuda', JSON.stringify(allaEcuenta));

    })
</script>
<style>
    .titulo-tributo{
        padding: 5px;
        border-radius: 1px;
        font-size: 18px;
    }
    .selected-page {
        background-color: green!important;
        color: white;
    }
    .contenedor-primero{
        transition: all .3s ease;
        transition-property: width, transform;
    }
    .contenedor-segundo {
        /* position: absolute; */
        top: 0;
        right: -100%;
        transition: all 0.5s ease;
        transition: right 0.5s ease, opacity 0.5s ease;
        opacity: 0;
    }

    .contenedor-segundo.mostrar {
        right: 0;
        transform: translateX(0)!important;
        transition: right 0.5s ease, opacity 0.5s ease;
        /* right: 0; */
        opacity: 1;
    }

    .contenedor-primero.ocultar {
        transform: translateX(-1%);
        transition: all 0.5s ease;
        /* opacity: 0; */
    }
    .total-pie-tabla{
        font-weight: bold!important;
        font-size: 14px;
        color: #1761fd!important; ;
    }
    #loader-overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        background: rgb(225 229 231);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        left: 0;
    }

    /* Estilo para el texto del loader */
    #loader {
        font-size: 2em;
        color: #333;
    }

    .banner-muni {
        /* background-image: url(https://i.ibb.co/jWTTjpb/muniancon2-1.png);
        height: 45vh;
        background-position: bottom;
        display: flex;
        align-items: center;
        position: relative;
        color: #fff; */
    }

    .banner-muni .page-title-box .row .col h4 {
        /* color: #fff; */
    }

    .breadcrumb-item a {
        /* color: #fff; */
    }

    .breadcrumb-item a:hover {
        /* color: #fff; */
    }

    .nav.nav-tabs .nav-item.show:focus,
    .nav.nav-tabs .nav-item.show.active,
    .nav.nav-tabs .nav-link:focus,
    .nav.nav-tabs .nav-link.active {
        color: #ffffff;
        background-color: #2594bf;
        border-color: transparent transparent #2594bf;
        box-shadow: 0px 0px 4px 0px rgb(12 116 151);
        
    }
    
    .nav-tabs .nav-link {
        border-top-left-radius: unset;
        border-top-right-radius: unset;
        border-radius: 25px;
    }

    .list-group {
        box-shadow: 0px 0px 15px 0px rgba(175, 193, 223, 0.40);
    }

    .btn-procesar:hover {
        scale: 110%;
        transition: scale 250ms, box-shadow 250ms;
        box-shadow: 0px -5px 10px rgb(212 221 243 / 25%), 0px 15px 30px rgb(212 221 243 / 75%);
    }

    .nav-tabs {
        background: white;
        box-shadow: 0px 0px 15px 0px rgba(175, 193, 223, 0.40);
        padding: 7px 0 7px 7px;
        border-radius: 5px;
    }

    .nav-tabs .nav-item {
        padding: 0.12rem;
    }

    .nav.nav-tabs .nav-item.show.active:hover,
    .nav.nav-tabs .nav-link.active:hover {}

    @media (max-width: 991px) {
        .wrapper {
            margin-top: 30px;
        }
    }

    .pagination-sm>li>a,
    .pagination-sm>li>span {
        margin: 0px 8px;
        border: 1.9px solid #2594bf;
        border-radius: 6px;
    }

    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px
    }

    .pagination>li {
        display: inline
    }

    .pagination>li>a,
    .pagination>li>span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #337ab7;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd
    }

    .pagination>li:first-child>a,
    .pagination>li:first-child>span {
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px
    }

    .pagination>li:last-child>a,
    .pagination>li:last-child>span {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px
    }

    .pagination>li>a:focus,
    .pagination>li>a:hover,
    .pagination>li>span:focus,
    .pagination>li>span:hover {
        z-index: 2;
        color: #23527c;
        background-color: #eee;
        border-color: #ddd
    }

    .pagination>.active>a,
    .pagination>.active>a:focus,
    .pagination>.active>a:hover,
    .pagination>.active>span,
    .pagination>.active>span:focus,
    .pagination>.active>span:hover {
        z-index: 3;
        color: #fff;
        cursor: default;
        background-color: #337ab7;
        border-color: #337ab7
    }

    .pagination>.disabled>a,
    .pagination>.disabled>a:focus,
    .pagination>.disabled>a:hover,
    .pagination>.disabled>span,
    .pagination>.disabled>span:focus,
    .pagination>.disabled>span:hover {
        color: #777;
        cursor: not-allowed;
        background-color: #d1d1d1;
        border-color: #ddd;
        pointer-events: auto;
        /*display: none; agregado */
    }

    .pagination-lg>li>a,
    .pagination-lg>li>span {
        padding: 10px 16px;
        font-size: 18px;
        line-height: 1.3333333
    }

    .pagination-lg>li:first-child>a,
    .pagination-lg>li:first-child>span {
        border-top-left-radius: 6px;
        border-bottom-left-radius: 6px
    }

    .pagination-lg>li:last-child>a,
    .pagination-lg>li:last-child>span {
        border-top-right-radius: 6px;
        border-bottom-right-radius: 6px
    }

    .pagination-sm>li>a,
    .pagination-sm>li>span {
        padding: 0px 15px!important;
        font-size: 12px!important;
        line-height: 2.5
    }

    .pagination-sm>li:first-child>a,
    .pagination-sm>li:first-child>span {
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px
    }

    .pagination-sm>li:last-child>a,
    .pagination-sm>li:last-child>span {
        border-top-right-radius: 3px;
        border-bottom-right-radius: 3px
    }

    .pager {
        padding-left: 0;
        margin: 20px 0;
        text-align: center;
        list-style: none
    }

    .pager li {
        display: inline
    }

    .pager li>a,
    .pager li>span {
        display: inline-block;
        padding: 5px 14px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 15px
    }

    .pager li>a:focus,
    .pager li>a:hover {
        text-decoration: none;
        background-color: #eee
    }

    .pager .next>a,
    .pager .next>span {
        float: right
    }

    .pager .previous>a,
    .pager .previous>span {
        float: left
    }

    .pager .disabled>a,
    .pager .disabled>a:focus,
    .pager .disabled>a:hover,
    .pager .disabled>span {
        color: #777;
        cursor: not-allowed;
        background-color: #fff
    }

    .contenedor-procesar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #f8f9fa;
        padding: 10px;
        text-align: center;
        z-index: 10;
        display: none!important;
    }

    /* a list-group agregar la clase contenedor-procesar cuando sea responsive */
    @media (max-width: 991px) {
        .list-group {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            z-index: 9999;
        }
        .contenedor-segundo{
            display: none!important;
        }
        .contenedor-procesar{
            display: block!important;
            box-shadow: -5px -7px 17px 4px rgba(175, 193, 223, 0.40);
        }
    }

    #tablaTodos_filter{
        display: none;
    }

    table {
        width: 100%;
        border-collapse: separate; 
        border-spacing: 0 10px; 
    }
    table tr {
        background-color: #fff;
        border-radius: 10px; 
        transition: transform 0.2s;
    }
    table td, table th {
        padding: 15px;
        text-align: left;
        border: none;
    }
    table tr:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    .table-sm>:not(caption)>*>*{
        padding: 0.1rem 0.25rem;
    }
    .btn-acceso{
        background-color: #edf2f9;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
        width: 100%;
    }
    /* .button-slider {
        flex-wrap: nowrap;
        padding-bottom: 10px;
    }

    .button-slider::-webkit-scrollbar {
        height: 8px;
    }

    .button-slider::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 4px;
    }

    .button-slider::-webkit-scrollbar-track {
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 4px;
    }

    @media (max-width: 767.98px) {
        .button-slider {
            padding: 0 10px;
            display: flex;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .btn-acceso {
            flex: 0 0 auto;
            width: auto;
        }
    } */

</style>