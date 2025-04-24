@php

$data = json_decode($jsonData, true);

@endphp
<div class="row">
    <div class="col-lg-5 mx-auto">
        <div class="card">
            <div class="card-body p-0">
                <div class="text-center p-3">
                    <a href="#" class="logo logo-admin">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" height="50" alt="logo" class="auth-logo">
                    </a>
                    <p class=" mb-0">Ha ocurrido un problema al realizar el pago:</p>  
                    <h4 class="mt-3 mb-1 fw-semibold text-danger font-18">
                        <strong class="parpadea">{{ $data['ACTION_DESCRIPTION'] }}</strong><br>
                        <span>{{ $data['ECI_DESCRIPTION'] ?? '' }}</span>
                    </h4>   
                </div>
            </div>
            <div class="card-body">
                <div class="ex-page-content text-center">
                    <div class="row font-14 text-muted">
                        <div class="col-md-12">
                            <b>Número de pedido: </b> {{ $PURCHASENUMBER }}
                        </div>
                        <div class="col-md-12">
                            <b>Fecha y hora del pedido: </b> {{ date('d/m/Y H:i:s') }}
                        </div>
                        <div class="col-md-12">
                            <b>Tarjeta: </b> {{ $data['CARD'] }} ({{ $data['BRAND'] }})
                        </div>
                        <div class="col-md-12">
                            <b>Importe pagado: </b>S/. {{ $data['AMOUNT'] }}
                        </div>
                    </div>                             
                </div>            
                <a class="btn bg-beanred w-100 waves-effect waves-light" href="{{ route('pago-en-linea') }}">Volver <i class="fas fa-redo ms-1"></i></a>                         
            </div>
        </div>
    </div>
</div>
