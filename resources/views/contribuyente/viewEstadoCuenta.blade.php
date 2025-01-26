<div class="row ec-contenedor">
	<div class="col-lg-2">
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
                                <label class="form-label" for="cmbProcedencia">Procedencia</label><br>
                                <select id="cmbProcedencia" name="cmbProcedencia[]" multiple class="form-select">
                                </select>
                            </div>
                        
                            <div class="mb-1">
                                <label class="form-label" for="cmbMateria">Materia</label><br>
                                <select id="cmbMateria" name="cmbMateria[]" multiple class="form-select">
                                
                                </select>
                            </div>

                            <div class="mb-1">
                                <label class="form-label" for="cmbDesTribu">Descripcion de Tributos</label>
                                <select id="cmbDesTribu" name="cmbDesTribu[]" multiple class="form-control">
                                    
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

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="username">Peridos <sub>Desde</sub></label>
                                        <!-- <input type="number" class="form-control" id="periodo_ini" name="periodo_ini" placeholder="01"> -->
                                        <select id="periodo_ini" name="periodo_ini" class="form-select">
                                            <option value="">-- Seleccione --</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="useremail"><sub>Hasta</sub></label>
                                        <!-- <input type="number" class="form-control" id="periodo_fin" name="periodo_fin" placeholder="12"> -->
                                        <select id="periodo_fin" name="periodo_fin" class="form-select">
                                            <option value="">-- Seleccione --</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="cmbTipDeuda">Tipo Deuda</label>
                                <select id="cmbTipDeuda" name="cmbTipDeuda[]" multiple class="form-control">
                                </select>
                            </div>
                            <hr>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-gradient-primary" id="btn-consulta-ecuenta"><i class="fas fa-paper-plane"></i> Consultar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
    <div class="col-lg-10 mx-auto">
        <div class="accordion" id="accordionEcuenta">
            <div class="accordion-item">
                <h5 class="accordion-header m-0" id="headingOne">
                    <button class="accordion-button fw-bold bg-soft-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEstado" aria-expanded="true" aria-controls="collapseEstado">
                        Mi estado de cuenta
                    </button>
                </h5>
                <div id="collapseEstado" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionEcuenta" style="">
                    <div class="accordion-body">
                        <div class="row" id="html-tabla-ecuenta" style="display:none;">

                        </div>
                        <div class="row justify-content-center border">
                            <div class="col-lg-3">
                                <h5 class="mt-4">Para conocimiento :</h5>
                                <ul class="ps-3">
                                    <li><small class="font-12">Usa los filtros para buscar los registros!</small></li>                                          
                                    <li><small class="font-12">Interes proyectado hasta el {{date('d/m/Y')}} </small></li>
                                    <li><small class="font-12">Marque con check a las deudas que desea pagar</small></li>
                                </ul>
                            </div>                                    
                            <div class="col-lg-4 d-flex justify-content-center align-items-center border" >
                            <p><b>Importante:</b> Seleccione las deudas con <label class="btn btn-outline-dark btn-sm" style="font-size: x-small;">✓</label> para continuar y acogerse al beneficio vigente.</p> 
                            </div>
                            <div class="col-lg-5 d-flex justify-content-end " style="align-items: center;">
                                <div class="float-end dt-buttons">
                                </div>
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