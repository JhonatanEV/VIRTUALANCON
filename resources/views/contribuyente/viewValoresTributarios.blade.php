<div class="row">
    <div class="col-lg-12">
        <div class="d-flex align-items-center mb-4">
            <div class="flex-grow-1">
                <p class="text-muted fs-14 mb-0">Resultado: <span id="total-result">0</span></p>
            </div>
            <div class="flex-shrink-0">
                <div class="dropdown">
                    <a class="text-muted fs-14 dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        All View
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="card">
        <div class="card-header">
            <label for="" class="card-title">Lista de valores emitidos</label>
        </div>
        <div class="card-body">
                <table class="table table-sm table-bordered dt-responsive nowrap" id="datatable">
                    <thead class="bg-danger-gradient">
                        <tr>
                            <th class="fw-bold text-center" style="width:50px;">Fecha Emisión</th>
                            <th class="fw-bold text-center" style="width:60px;">Tipo Emisión</th>
                            <th class="fw-bold text-center" style="width:200px;">Tipo Deuda</th>
                            <th class="fw-bold text-center" style="width:50px;">N° Lote</th>
                            <th class="fw-bold text-center" style="width:30px;">Año</th>
                            <th class="fw-bold text-center" style="width:30px;">N° Valor</th>
                            <th class="fw-bold text-center" style="width: 100px;">Monto Valor</th>
                            <th class="fw-bold text-center" style="width:30px;">Estado Valor</th>
                        </tr>
                    </thead>
                    <tbody id="dataContenedor">
                    </tbody>
                </table>
        </div>
    </div>
</div>