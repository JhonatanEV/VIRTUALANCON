<div class="row ec-contenedor">
	<div class="col-lg-2 d-none">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h5 class="accordion-header m-0" id="headingOne">
                    <button class="accordion-button fw-bold bg-soft-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Filtros
                    </button>
                </h5>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body">
                        <form action="#" method="post" id="form11">
                            <input type="hidden" name="tipo_consulta" id="tipo_consulta" value="">

                            <div class="mb-1">
                                <label class="form-label" for="cmbTributo">Tributo</label><br>
                                <select id="cmbTributo" name="cmbTributo[]" multiple class="form-select">
                                    
                                    <option value="IP">Impuesto Predial</option>
                                    <option value="ARB">Impuesto Arbitrios</option>
                                </select>
                            </div>
                        
                            <div class="mb-1">
                                <label class="form-label" for="cmbAnexos">Anexos</label><br>
                                <select id="cmbAnexos" name="cmbAnexos[]" multiple class="form-select">
                                
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="username">Años <sub>Desde</sub></label>
                                        <!-- <input type="number" class="form-control" min="1" maxlength="4" onkeypress="if(this.value.length==4) return false;" id="anno_desde" name="anno_desde" placeholder="2010"> -->
                                        <select id="anno_desde" name="anno_desde" class="form-select">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="useremail"><sub>Hasta</sub></label>
                                        <!-- <input type="number" class="form-control" min="1" maxlength="4" onkeypress="if(this.value.length==4) return false;" id="anno_hasta" name="anno_hasta" placeholder="<?=date("Y") ?>"> -->
                                        <select id="anno_hasta" name="anno_hasta" class="form-select">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary" id="btn-consulta-ecuenta" onclick="getEcuenta()"><i class="fas fa-paper-plane"></i> Consultar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
    <div class="col-lg-12 mx-auto">
        <div class="accordion" id="accordionEcuenta">
            <div class="accordion-item">
                <h5 class="accordion-header m-0" id="headingOne">
                    <button class="accordion-button fw-bold bg-soft-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEstado" aria-expanded="true" aria-controls="collapseEstado">
                        Mi estado de cuenta
                    </button>
                </h5>
                <div id="collapseEstado" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionEcuenta" style="">
                    <div class="accordion-body">
                        <div class="row" id="html-tabla-ecuenta">
                        <table id="row_callback" class="table table-sm table-striped table-bordered dt-responsive nowrap">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center fw-bold text-white">TRIBUTO</th>
                                    <th class="text-center fw-bold text-white">AÑO</th>
                                    <th class="text-center fw-bold text-white">NRO RECIBO</th>
                                    <th class="text-center fw-bold text-white">PER.</th>
                                    <th class="text-center fw-bold text-white">F. VENC</th>
                                    <th class="text-center fw-bold text-white">SITUACIÓN</th>
                                    <th class="text-center fw-bold text-white">INSOLUTO</th>
                                    <th class="text-center fw-bold text-white">REAJUSTE</th>
                                    <th class="text-center fw-bold text-white">EMISIÓN</th>
                                    <th class="text-center fw-bold text-white">COSTAS</th>
                                    <th class="text-center fw-bold text-white">DESC.</th>
                                    <th class="text-center fw-bold text-white">TOTAL PAGAR</th>
                                </tr>
                            </thead>
                            <tbody id="tableBodyEcuenta">
                            
                            </tbody>           
                            <tfoot>
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
                                        <th></th>
                                        <th class="text-lg-center">TOTAL</th>
                                        <th class="text-end" id="thTotal">0.00</th>
                                    </tr>
                                </tfoot>
                        </table> 
                        </div>
                        <div class="row justify-content-center border">
                            <div class="col-lg-6">
                                <h5 class="mt-4">Para conocimiento :</h5>
                                <ul class="ps-3">
                                    <li><small class="font-12">Usa los filtros para buscar los registros!</small></li>                                          
                                    <li><small class="font-12">Interes proyectado hasta el {{date('d/m/Y')}} </small></li>
                                </ul>
                            </div> 
                            <div class="col-lg-6 align-content-center text-end">
                                <button type="button" class="btn btn-danger" onclick="imprimirEcuenta()"><i class="mdi mdi-printer font-16 me-2"></i>Imprimir Estado de Cuenta</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-12 col-xl-4 ms-auto align-self-center">
                                <div class="text-center"><small class="font-12">Muchas gracias por utilizar la {{config('app.SISTEMA')}}</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalPrint" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary p-1">
                <h6 class="modal-title m-0 text-white">Estado de cuenta</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                    <iframe id="iframeEstadoCuenta" 
                        src="" 
                        frameborder="0" width="100%" 
                        height="100%" style="height: 45rem;"
                        >
                    </iframe>
            </div>
            <div class="modal-footer">                                                    
                <button type="button" class="btn btn-soft-secondary " data-bs-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>

<style>
    @media screen and (max-width: 480px) {
      .div-filtros {
            position: initial!important;
            width: 100%!important;
      }
      .multi-select-container{
      	width: 100%!important;
      }
      .multi-select-button{
      	 max-width: 100%!important;
      	 width: -webkit-fill-available!important;
      }
    }

    input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
	  -webkit-appearance: none; 
	  margin: 0; 
	}
	.multi-select-container{
		display: block;
	}
    .multi-select-button{
    	display: block;
	    width: 100%;
	    padding: 0.375rem 0.75rem;
	    font-size: .8125rem;
	    font-weight: 400;
	    line-height: 1.5;
	    color: #303e67;
	    background-color: #fff;
	    background-clip: padding-box;
	    border: 1px solid #e3ebf6;
	    appearance: none;
	    border-radius: 0.25rem;
	    transition: border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;
	    max-width: 100%;
    }
</style>