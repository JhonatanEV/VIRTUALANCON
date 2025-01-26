
@php
    $dbAreas = json_decode($dbAreas);
   
@endphp
<style>
           
           .ui-datepicker{
            width:100%;
            height: 100%;
           }
           .ui-widget-header{
            border:none;
            background:#ffffff;
            font-weight: 100;
           }
           .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default{
            border: 1px solid transparent;
            border-radius: 50%;
            width: 39px;
            height: 40px;
            text-align: center;
            box-sizing: border-box;
            font-size: 16px;
            font-family: proxima nova,sans-serif;
            line-height: 2.1;
            word-break: break-word;
            overflow-wrap: break-word;
            -webkit-font-smoothing: antialiased;
           }
           .ui-datepicker .ui-datepicker-buttonpane{
            display:none;
           }
           .select2-container--default .select2-selection--single{
            height: 49px;
            border: 2px solid #a4abc5;
           }
           .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 42px;
            color: #a4abc5;
           }
           .select2-container--default .select2-selection--single .select2-selection__arrow{
            height: 47px;
           }
           .select2-container .select2-selection--single .select2-selection__rendered{
            font-weight: bold;
            font-size: 15px;
           }
           .select2-container{
            width: 100%!important;
           }
           .ocupado {
  position: relative;
  text-align: center;
}

.ocupado:after {
  content: '•';
  position: absolute;
  bottom: -5px;
  left: 40%;
  transform: translateX(-50%);
  font-size: 14px;
  color: red;
}
</style>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-sm-4">
                <div class="row">
                    
                    <div class="col-md-12">
                       
                        <input type="hidden" id="HORA_FECHA">
                    </div>
                </div>
                
            </div>
            <div class=" col-sm-12">
                <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Horario de audencias</h4>                   
                        </div>                                   
                    </div>
                </div>
                <!-- <strong id="FECHA_TEXTO" class="font-18">Horario para la fecha: <a id="HORA_FECHA_TEXTO">00/00/0000</a></strong> -->
                <div class="card-body justify-content-center">
                    <form method="post" id="frmHorarios">
                        <input type="hidden" id="HORA_CODIGO" name="HORA_CODIGO">
                        <input type="hidden" id="HORA_FECHA_FRM" name="HORA_FECHA">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <label class="text-muted">Área:</label>
                                <select name="AREA_CODIGO" id="AREA_CODIGO" class="form-select form-control-lg select2">
                                        <option value="">-- Seleccione Area --</option>
                                        @foreach($dbAreas as $area)
                                            <option value="{{ $area->AREA_CODIGO }}" {{ ($area->AREA_CODIGO==2)?'selected':'' }}>{{ $area->AREA_NOMBRE }}</option>
                                        @endforeach
                                </select>
                            </div>

                            <div id="datepicker"></div>
                        </div>
                        <div class="col-md-8">
                            <div id="dataHorarios"></div>

                            <div class="row mb-2 m-3 justify-content-center">
                                <div class="col-md-4">
                                    <button class="btn btn-primary" type="submit">Guardar Horarios</button>
                                </div>
                            </div>

                        </div>

                        </form>
                    </div>

                 
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>