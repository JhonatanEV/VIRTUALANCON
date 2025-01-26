<style>
    .app:hover{
        background-color: #2594bf2b;
        transform: scale(1) translateZ(0);
        box-shadow: 0 15px 24px rgba(0,0,0,0.11);
        border: 1px solid #12aff6;
    }
    .app:hover .card-body strong{
        color: blue;
    }
    .app:hover img{
        filter: drop-shadow(2px 4px 0px blue);
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card border-0">
            <div class="card-body">
            <table>
                <tr>
                    <td>Usuario</td>
                    <td><span class="fw-bold">: {{Session::get('SESS_NOMBRE_COMPLETO')}}</span></td>
                </tr>
                <tr>
                    <td>N° Documento</td>
                    <td><span class="fw-bold">: {{Session::get('SESS_PERS_DOCUMENTO')}}</span></td>
                </tr>
                <tr>
                    <td>Fecha de ingreso</td>
                    <td><span class="fw-bold">: {{date('d/m/Y h:i a')}}</span></td>
                </tr>
                
            </table>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            
            <div class="col-lg-2 d-none" id="accesoDirectoPagoOnline">
                <div class="card app border-2">
                    <div class="card-body">
                        <a href="./pagalo/pago-en-linea">
                            <div class="row d-flex justify-content-center">                                                
                                <div class="col text-center">
                                    <strong>PAGO EN LÍNEA<br>DE TRIBUTOS</strong><br>
                                    <img src="{{ asset('assets/images/apps/pagoenlinea.png') }}" alt="" class="thumb-xl"><br>
                                    <span class="text-muted">Ir a pagar</span>
                                </div> 
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 d-none" id="accesoDirectoEstadoCuenta">
                <div class="card app border-2">
                    <div class="card-body">
                        <a href="./pagalo/estado-de-cuenta">
                        <div class="row d-flex justify-content-center">
                            <div class="col text-center">
                                <strong>ESTADO<br>DE CUENTA</strong><br>
                                <img src="{{ asset('assets/images/apps/pagar.png') }}" alt="" class="thumb-xl"><br>
                                <small class="text-muted">Ir a ver</small>
                            </div> 
                        </div>
                        </a>
                    </div>
                </div>
            </div> 
            <div class="col-lg-2 d-none" id="accesoCuponeraVirtual">
                <div class="card app border-2">
                    <div class="card-body">
                        <a href="./contribuyente/cuponera">
                        <div class="row d-flex justify-content-center">
                            <div class="col text-center">
                                <strong>CUPONERA<br>VIRTUAL</strong><br>
                                <img src="{{ asset('assets/images/apps/cuponera.png') }}" alt="" class="thumb-xl"><br>
                                <small class="text-muted">Ir a ver</small>
                            </div> 
                        </div>
                        </a>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>