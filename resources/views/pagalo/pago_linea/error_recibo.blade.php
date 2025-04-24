@php

$data = json_decode($jsonData, true);

@endphp

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Error al procesar el recibo</div>
            <div class="card-body">
                <p>Ha ocurrido un error al procesar el recibo. Por favor, inténtelo de nuevo.</p>
                <hr>
                <div class="alert alert-danger" role="alert">
                    Estimado(a), el incoveniente. Su pago se realizó pero esta en evaluación. Si su cuenta sigue como pendiente, cuminicarse con el administrador del sistema.
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <b>Número de pedido: </b> {{ $data->PURCHASENUMBER }}
                    </div>
                    <div class="col-md-12">
                        <b>Fecha y hora del pedido: </b> {{ date('d/m/Y H:i:s') }}
                    </div>
                    <div class="col-md-12">
                        <b>Tarjeta: </b> {{ $data->CARD }} ({{ $data->BRAND }})
                    </div>
                    <div class="col-md-12">
                        <b>Importe pagado: </b>S/. {{ $data->AMOUNT }}
                    </div>
                </div>

                <a href="{{ route('pago-en-linea') }}" class="btn btn-primary">Volver</a>
            </div>
        </div>
    </div>
</div>