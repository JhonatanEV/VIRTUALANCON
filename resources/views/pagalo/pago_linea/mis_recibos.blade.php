<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">                      
                        <h4 class="card-title">Mis recibos</h4>
                        <small class="text-muted">Recibos cancelados por vía Online</small>                      
                    </div>
                    <div class="col-auto">      
                    </div>
                </div>  
            </div>
            <div class="card-body">
                <div class="files-nav overflow-auto" style="max-height: 33rem;">                                     
                    <div class="nav flex-column nav-pills" id="files-tab" aria-orientation="vertical">
                        @foreach($recibos as $recibo)
                            <a class="nav-link" href="{{ route('pagalo.mis-recibos-pdf', $recibo->cnumcom) }}">
                                <div class="icon-dual-file icon-sm me-3">
                                    <i class="lar la-file-code text-danger font-34"></i>
                                </div>
                                <div class="d-inline-block align-self-center">
                                    <h5 class="m-0">Recibo N° {{ $recibo->cnumcom }} - {{ \Carbon\Carbon::parse($recibo->dfecpag)->format('d/m/Y') }}</h5>
                                    <small>Total pagado: S/. {{ number_format($recibo->nmontot,2) }}</small>                                                    
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="">
            <iframe src="" frameborder="0"
                style="width: 100%; height: 600px;"
                allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"
                id="pdf-viewer"
            >
            </iframe>
            <h4 class="card-title mt-0 mb-3">Seleccione un recibo para visualizar</h4>                                                                          
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#files-tab a').on('click', function (e) {
            e.preventDefault()
            $(this).tab('show')

            var url = $(this).attr('href');
            $('#pdf-viewer').attr('src', url);

        })
    });
</script>