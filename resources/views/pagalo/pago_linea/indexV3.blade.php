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
            
            <!-- <input type="checkbox" class="btn-check" id="btn-pagar-ip" autocomplete="off">
            <label class="btn btn-outline-primary btn-lg btn-acceso fw-bold" for="btn-pagar-ip">
                <i class="me-2">👉</i>Pagar Todo Predial <strong id="txtTotalPagarIP">S/. 00.00</strong>
            </label>
            
            <input type="checkbox" class="btn-check" id="btn-pagar-arb" autocomplete="off">
            <label class="btn btn-outline-primary btn-lg btn-acceso fw-bold" for="btn-pagar-arb">
                <i class="me-2">👉</i>Pagar Todo Arbitrios <strong id="txtTotalPagarABR">S/. 00.00</strong>
            </label> -->
    
            
            <input type="checkbox" class="btn-check" id="btn-pagar-venc" autocomplete="off">
            <label class="btn btn-outline-primary btn-lg btn-acceso fw-bold me-2" for="btn-pagar-venc">
                <i class="me-2">👉</i>Pagar deuda vencida predial / arbitriso <strong id="txtTotalPagarVenc">S/. 00.00</strong>
            </label>
            
            <input type="checkbox" class="btn-check" id="btn-pagar-coac" autocomplete="off">
            <label class="btn btn-outline-beanred btn-lg btn-acceso fw-bold" for="btn-pagar-coac">
                <i class="me-2">👉</i>Pagar Todo Coactivo <strong id="txtTotalPagarCOAC">S/. 00.00</strong>
            </label>

        </div>
        
    </div>
    <div class="col-md-7 contenedor-primero">
        <div class="card border-0">
            <div class="card-header">
                <h4 class="card-title">Hola, <b>{{ trim($contribuyente->FANOMCONTR) }}</b> con codigo <b>{{ $contribuyente->FACODCONTR }}</b></h4>
                <p class="text-muted mb-0">Seleccione tipos de tributo para ver su deuda pendiente a pagar.</p>
            </div><!--end card-header-->
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link fw-bold active" data-bs-toggle="tab" href="#home" role="tab" aria-selected="true">TRIBUTOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" data-bs-toggle="tab" href="#coactivo" role="tab" aria-selected="false" id="headerCoactivo">COACTIVO</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane p-3 active" id="home" role="tabpanel">

                        <div class="row">
                            <!-- <div class="col-sm-12" style="text-align: center">
                                <p>Búsqueda por año</p>
                                <ul id="pagination-tributo" class="pagination-sm pagination justify-content-center mb-0 mt-0">

                                </ul>
                            </div> -->
                            <div class="col-sm-12">
                                <span class="titulo-tributo text-decoration-underline fw-bold text-muted">IMPUESTO PREDIAL</span>
                            </div>
                        </div>

                        <table id="tablaIp" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="background-color: #6464644f;">
                                <tr>
                                    
                                    <th class="text-center fw-bold">TRIBUTO</th>
                                    <th class="text-center fw-bold">AÑO</th>
                                    <th class="text-center fw-bold">PER.</th>
                                    <th class="text-center fw-bold">F. VENC</th>
                                    <th class="text-center fw-bold">INSOLUTO</th>
                                    <th class="text-center fw-bold">REAJUSTE</th>
                                    <th class="text-center fw-bold">EMISIÓN</th>
                                    <th class="text-center fw-bold">COSTAS</th>
                                    <th class="text-center fw-bold">DSCTO</th>
                                    <th class="text-center fw-bold">TOTAL</th>
                                    <th>
                                        <div class="col-md">
                                            <input type="checkbox" class="btn-check" id="imp-select-all" autocomplete="off">
                                            <label class="btn btn-outline-info btn-sm" for="imp-select-all"><i class="fas fa-check"></i> Seleccionar</label><br>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ipEcuenta as $data)
                                <tr>
                                    <td>{{ $data->FADESTRIBU }}</td>
                                    <td>{{ $data->faanotribu }}</td>
                                    <td>{{ $data->faperiodo }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->FECVENC)->format('d/m/Y') }}</td>
                                    <td class="text-end">{{ number_format($data->VNFIMP01,2) }}</td>
                                    <td class="text-end">{{ number_format($data->fnmora,2) }}</td>
                                    <td class="text-end">{{ number_format($data->fngasadmin,2) }}</td>
                                    <td class="text-end">{{ number_format($data->VNFCOSPROCE,2) }}</td>
                                    <td class="text-end">{{ number_format($data->DESCUENTO,2) }}</td>
                                    <td class="text-end total-pie-tabla">{{ number_format($data->TOTAL,2) }}</td>
                                    <td class="dtr-control text-end">
                                        <div class="col-md">
                                            <input type="checkbox" 
                                            class="btn-check mis-tributos" 
                                            name="recibo[]" 
                                            id="recibo{{ $data->fanrorecib }}{{ $data->facodtribu }}" 
                                            autocomplete="off" 
                                            precio-trib="{{ $data->TOTAL }}" 
                                            codigo="{{ $data->key }}"
                                            value="1"
                                            >
                                            <label class="btn btn-outline-info btn-sm" for="recibo{{ $data->fanrorecib }}{{ $data->facodtribu }}">
                                                <i class="fas fa-check"></i>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <br>
                        <div class="row">
                            <div class="col-sm-8">
                                <span class="titulo-tributo text-decoration-underline fw-bold text-muted">IMPUESTO ARBITRIOS</span>
                            </div>
                            <div class="col-sm-4 text-end">
                                <div class="form-floating">
                                    <select class="form-select form-select-sm" id="CMB_ANEXO" multiple>
                                    <option value="">-- Seleccione --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <table id="tablaArb" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="background-color: #6464644f;">
                                <tr>
                                    <th class="text-center fw-bold">TRIBUTO</th>
                                    <th class="text-center fw-bold">AÑO</th>
                                    <th class="text-center fw-bold">PER.</th>
                                    <th class="text-center fw-bold">F. VENC</th>
                                    <th class="text-center fw-bold">INSOLUTO</th>
                                    <th class="text-center fw-bold">REAJUSTE</th>
                                    <th class="text-center fw-bold">EMISIÓN</th>
                                    <th class="text-center fw-bold">COSTAS</th>
                                    <th class="text-center fw-bold">DSCTO</th>
                                    <th class="text-center fw-bold">TOTAL</th>
                                    <th class="text-center fw-bold">ANEXO</th>
                                    <th>
                                        <div class="col-md">
                                            <input type="checkbox" class="btn-check" id="arb-select-all" autocomplete="off">
                                            <label class="btn btn-outline-info btn-sm" for="arb-select-all"><i class="fas fa-check"></i> Seleccionar</label><br>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($arbEcuenta as $arb)
                                @php
                                    $anexo_arb = 'ANEXO: '.$arb->faanexo.' - '.$arb->DIRANEXO;
                                    $insoluto = $arb->fnimp01 + $arb->fnimp02 + $arb->fnimp03 + $arb->fnimp04 + $arb->fnimp05;
                                @endphp
                                <tr>
                                    <td>{{ $arb->FADESTRIBU }}</td>
                                    <td>{{ $arb->faanotribu }}</td>
                                    <td>{{ $arb->faperiodo }}</td>
                                    <td>{{ \Carbon\Carbon::parse($arb->FECVENC)->format('d/m/Y') }}</td>
                                    <td class="text-end">{{ number_format($insoluto,2) }}</td>
                                    <td class="text-end">{{ number_format($arb->fnmora,2) }}</td>
                                    <td class="text-end">{{ number_format($arb->fngasadmin,2) }}</td>
                                    <td class="text-end">{{ number_format($arb->VNFCOSPROCE,2) }}</td>
                                    <td class="text-end">{{ number_format($arb->DESCUENTO,2) }}</td>
                                    <td class="text-end total-pie-tabla">{{ number_format($arb->TOTAL,2) }}</td>
                                    <td>{{ $anexo_arb }}</td>
                                    <td class="dtr-control text-end">
                                        <div class="col-md">
                                            <input 
                                            type="checkbox" 
                                            class="btn-check mis-tributos" 
                                            name="recibo[]" 
                                            id="recibo{{ $arb->fanrorecib }}{{ $arb->facodtribu }}" 
                                            autocomplete="off" 
                                            precio-trib="{{ $arb->TOTAL }}"
                                            codigo="{{ $arb->key }}"
                                            value="1">
                                            <label class="btn btn-outline-info btn-sm" for="recibo{{ $arb->fanrorecib }}{{ $arb->facodtribu }}">
                                                <i class="fas fa-check"></i>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane p-3" id="coactivo" role="tabpanel">
                        
                        <div class="col-sm-12" style="text-align: center">
                            <p>Búsqueda por año</p>
                            <ul id="pagination-coac" class="pagination-sm pagination justify-content-center mb-0 mt-0">
                            </ul>
                        </div>
                        <!-- <div class="col-sm-12">
                            <span class="badge badge-soft-primary">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="chkPagarTodoCoac">
                                    <label class="form-check-label mt-1" for="chkPagarTodoCoac" id="txtPagarTodoCoac">Pagar todo los años</label>
                                </div>
                            </span>
                        </div> -->
                        <div class="row">
                            <div class="col-sm-12">
                                <span class="titulo-tributo text-decoration-underline fw-bold text-muted">COACTIVO</span>
                            </div>
                        </div>
                        <table id="tablaCoac" class="table table-sm table-striped table-bordered dt-responsive nowrap" width="100%">
                            <thead style="background-color: #6464644f;">
                                <tr>
                                    <th class="text-center fw-bold">TRIBUTO</th>
                                    <th class="text-center fw-bold">AÑO</th>
                                    <th class="text-center fw-bold">PER.</th>
                                    <th class="text-center fw-bold">F. VENC</th>
                                    <th class="text-center fw-bold">INSOLUTO</th>
                                    <th class="text-center fw-bold">REAJUSTE</th>
                                    <th class="text-center fw-bold">EMISIÓN</th>
                                    <th class="text-center fw-bold">COSTAS</th>
                                    <th class="text-center fw-bold">DSCTO</th>
                                    <th class="text-center fw-bold">TOTAL</th>
                                    <th class="text-center fw-bold">ANEXO</th>
                                    <th>
                                        <div class="col-md">
                                            <input type="checkbox" class="btn-check" id="coac-select-all" autocomplete="off">
                                            <label class="btn btn-outline-info btn-sm " for="coac-select-all"><i class="fas fa-check"></i> Seleccionar</label><br>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            @foreach($coacEcuenta as $coac)
                                @php
                                    $insoluto = $coac->fnimp01 + $coac->fnimp02 + $coac->fnimp03 + $coac->fnimp04 + $coac->fnimp05;

                                    if($coac->facodtribu == 'IP'):
                                        $anexo = $coac->FADESTRIBU;
                                    else:
                                        $anexo = 'ANEXO: '.$coac->faanexo.' - '.$coac->DIRANEXO;
                                    endif;
                                @endphp
                                <tr>
                                    <td>{{ $coac->FADESTRIBU }}</td>
                                    <td>{{ $coac->faanotribu }}</td>
                                    <td>{{ $coac->faperiodo }}</td>
                                    <td>{{ \Carbon\Carbon::parse($coac->FECVENC)->format('d/m/Y') }}</td>
                                    <td class="text-end">{{ number_format($insoluto,2) }}</td>
                                    <td class="text-end">{{ number_format($coac->fnmora,2) }}</td>
                                    <td class="text-end">{{ number_format($coac->fngasadmin,2) }}</td>
                                    <td class="text-end">{{ number_format($coac->VNFCOSPROCE,2) }}</td>
                                    <td class="text-end">{{ number_format($coac->DESCUENTO,2) }}</td>
                                    <td class="text-end total-pie-tabla">{{ number_format($coac->TOTAL,2) }}</td>
                                    <td>{{ $anexo }}</td>
                                    <td class="dtr-control">
                                        <div class="col-md">
                                            <input 
                                            type="checkbox" 
                                            class="btn-check mis-tributos" 
                                            name="recibo[]" 
                                            id="recibo{{ $coac->fanrorecib }}{{ $coac->facodtribu }}" 
                                            autocomplete="off" 
                                            precio-trib="{{ $coac->TOTAL }}"
                                            codigo="{{ $coac->key }}"
                                            value="1">
                                            <label class="btn btn-outline-info btn-sm" for="recibo{{ $coac->fanrorecib }}{{ $coac->facodtribu }}">
                                                <i class="fas fa-check"></i>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-lg-center">TOTAL</th>
                                    <th class="text-end" id="thTotalCoac">0.00</th>
                                    <th></th>
                                </tr>
                            </tfoot> -->
                        </table>
                    </div>

                </div>
            </div><!--end card-body-->
        </div>
    </div>
    <div class="col-md-3 contenedor-segundo" style="display: none;">
        <div class="row" style="position: sticky;top: 58px;">
            <div class="col-lg-12">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-muni">
                        <div>
                            <span class="text-white"> <i class="fas fa-shopping-cart text-white font-20 me-2"></i> Monto Total a Pagar:</span>
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
    <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-muni p-2">
                <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Procesar mis deudas seleccionadas - <b>{{ Session::get('SESS_NOMBRE_COMPLETO') }}</b></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-9">
                        <table id="tablaProcesar" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="background-color: #6464644f;">
                                <tr>
                                    <th class="text-center fw-bold">MATERIA</th>
                                    <th class="text-center fw-bold">AÑO</th>
                                    <th class="text-center fw-bold">PER.</th>
                                    <th class="text-center fw-bold">F. VENC</th>
                                    <th class="text-center fw-bold">INSOLUTO</th>
                                    <th class="text-center fw-bold">P.J.</th>
                                    <th class="text-center fw-bold">SERZ</th>
                                    <th class="text-center fw-bold">B.CALLE</th>
                                    <th class="text-center fw-bold">DSCTO</th>
                                    <th class="text-center fw-bold">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-3 text-center align-self-center">
                        <div class="card border-0">
                            <div class="card-body">
                                <div class="col-sm-12 mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="chkAutorizo" checked>
                                        <label class="form-check-label" for="chkAutorizo">
                                            Acepto <a href="https://virtual.muniancon.gob.pe/terminos-y-condiciones" class="text-primary" target="_blank">Términos y condiciones</a>
                                        </label>
                                    </div>
                                        
                                </div>
                                <h5 class="card-title">Monto Total a Pagar</h5>
                                <h3 class="card-text text-danger fw-bolder MontoSeleccionado">S/ 0.00</h3>
                                <button type="button" class="btn btn-success btn-lg mt-3" id="btnPagarDeuda"><i class="far fa-credit-card me-2"></i>Pagar</button>
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
<script src="https://static-content-qas.vnforapps.com/v2/js/checkout.js?qa=true"></script>
<script>
    $(document).ready(function() {
        //let deudaIp = @json($ipEcuenta);
        let deudaArb = @json($arbEcuenta);
        //let deuda = deudaIp.concat(deudaArb);
        let allaEcuenta = @json($allEcuenta);

        if (localStorage.getItem('deuda')) {
            localStorage.removeItem('deuda');
        }
        localStorage.setItem('deuda', JSON.stringify(allaEcuenta));

        if (localStorage.getItem('deuda_arb')) {
            localStorage.removeItem('deuda_arb');
        }
        localStorage.setItem('deuda_arb', JSON.stringify(deudaArb));
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
        font-size: 18px;
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

    #tablaIp_filter{
        display: none;
    }
    #tablaArb_filter{
        display: none;
    }
    #tablaCoac_filter{
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
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
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
    .button-slider {
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
    }

</style>