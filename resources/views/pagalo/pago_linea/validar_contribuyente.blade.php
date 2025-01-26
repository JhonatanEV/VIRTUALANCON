
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-3 align-self-center text-center">
                        <img class="" src="{{ asset('assets/images/img/usuario_seguro.png') }}" alt="Card image">
                    </div>
                    <div class="col-md-9">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">                      
                                    <h4 class="card-title fw-bold">Validar Contribuyente</h4>               
                                </div> 
                                <div class="col-auto">                 
                                    <span class="badge badge-outline-light">
                                        <i class="mdi mdi-account"></i>
                                    </span>              
                                </div>
                            </div>  
                        </div>
                        <div class="card-body">
                                <ol>
                                    <li>
                                        Estimado usuario, en esta sección podrá validar sí su n° documento se encuentra registrado en el sistema de la Municipalidad de Ancón. 
                                    </li>
                                    <li>Recuerde que la validación es unicamente para contribuyentes que se encuentran registrados.</li>
                                    <li>Esta validación solo será por única vez. Caso contrario, deberá acercarse a la oficina de la Municipalidad de Ancón.

                                    </li>
                                </ol>
                                <div class="input-group mb-3">
                                    <input 
                                    type="text" 
                                    name="documento" 
                                    id="documento" 
                                    class="form-control border-3 border-blue" 
                                    required
                                    placeholder="Ingrese su número de documento"
                                    value="{{ Session::get('SESS_PERS_DOCUMENTO') }}"
                                    readonly
                                    >
                                </div>
                            <div class="input-group mb-3">
                                <input 
                                type="text" 
                                name="codigo" 
                                id="codigo" 
                                class="form-control border-3 border-blue" 
                                required
                                placeholder="Ingrese el código de contribuyente"
                                maxlength="8"
                                >
                                <button class="btn btn-primary btn-sm" type="button" id="button-validar">Validar mis datos!</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="modal fade" id="modalConfirmar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3 text-center align-self-center">
                        <img src="{{ asset('assets/images/img/lista-de-verificacion.png') }}" alt="" class="img-fluid">
                    </div>
                    <div class="col-lg-9">
                        <h5>
                            Excelente, su número de documento se encuentra registrado en el sistema de la Municipalidad de Ancón.
                        </h5>
                        <span>
                            <h2 id="nombreContribuyente" class="text-center fw-bold"></h2>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">                                                    
                <button type="button" class="btn btn-success" id="btnConfirmar">Confirmar</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function(){
        $('#button-validar').click(function(){
            var documento = $('#documento').val();
            var codigo = $('#codigo').val();

            if(documento == '' || codigo == ''){
                $("#codigo").addClass('is-invalid');
                $("#codigo").focus();
                showMessage('warning','Ingrese un número documento y codigo','Alerta')
            }else{
                try {
                    $.ajax({
                        url: urljs + 'pago-linea/validar-contribuyente',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            documento: documento,
                            codigo: codigo
                        },
                        success: function(data){
                            if(data.status){
                                $("#nombreContribuyente").text(data.data.contribuyente);
                                showMessage('success',data.mensaje,'Éxito');
                                OpenModal('#modalConfirmar');
                                // setTimeout(function(){
                                //     location.reload();
                                // }, 500);
                            }else{
                                showMessage('error',data.mensaje,'Alerta');
                            }
                        }
                    });
                } catch (error) {
                    showMessage('error','Intente nuevamente en unos minutos','Error');
                }
            }
        });

        $('#btnConfirmar').click(function(){
            try{
                $(this).attr('disabled',true);

                let url = 'pago-linea/confirmar-contribuyente'
                let frm = new FormData();
                frm.append('documento', $('#documento').val());

                envioAjaxdata(url, frm, 
                    function(data){
                        if(data.status){
                            showMessage('success',data.mensaje,'Éxito');
                            setTimeout(function(){
                                location.reload();
                                $('#btnConfirmar').attr('disabled',false);
                            }, 500);

                        }else{
                            showMessage('error',data.mensaje,'Alerta');
                            $('#btnConfirmar').attr('disabled',false);
                        }
                });
            
            }catch(error){
                $('#btnConfirmar').attr('disabled',false);
                showMessage('error','Intente nuevamente en unos minutos','Error');
            }
        });
    });
</script>