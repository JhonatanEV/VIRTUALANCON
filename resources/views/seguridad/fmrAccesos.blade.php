@php
    //var_dump($dbAcessos);
@endphp
<input type="hidden" id="ACCE_USUA_CODIGO" value="{{ $USUA_CODIGO }}">
<ul class="tree">
    @foreach($dbAcessos as $data)
        @if($data->OPCI_TIPO==1)
            <li>
                <input type="checkbox" onclick="guardarAcceso(this.checked,{{ $data->OPCI_CODIGO }})" {{$data->OPCI_ACCESO==1?'checked':''}}> <span class="badge badge-soft-dark font-11">{{ $data->OPCI_NOMBRE }}</span> <!--PRIMER NIVEL-->
                <span class="badge badge-soft-{{$data->OPCI_ESTADO==1?'success':'danger'}}" style="float:right;">@if($data->OPCI_ESTADO==1) &#x2713; @else &#10006; @endif </span>
                <ul class="tree">
                    @foreach($dbAcessos as $data2)
                        @if($data2->OPCI_TIPO==2 && $data2->OPCI_SUB_CODIGO==$data->OPCI_CODIGO)
                        <li>
                            <input type="checkbox" onclick="guardarAcceso(this.checked,{{ $data2->OPCI_CODIGO }})" {{$data2->OPCI_ACCESO==1?'checked':''}}><span class="badge badge-soft-dark font-11">{{ $data2->OPCI_NOMBRE }}</span> <!--SEGUNDO NIVEL-->
                            <span class="badge badge-soft-{{$data2->OPCI_ESTADO==1?'success':'danger'}}" style="float:right;">@if($data2->OPCI_ESTADO==1) &#x2713; @else &#10006; @endif </span>
                            <ul class="tree">
                                @foreach($dbAcessos as $data3)
                                    @if($data3->OPCI_TIPO==3 && $data3->OPCI_SUB_CODIGO==$data2->OPCI_CODIGO)
                                    <li>
                                        <input type="checkbox" onclick="guardarAcceso(this.checked,{{ $data3->OPCI_CODIGO }})" {{$data3->OPCI_ACCESO==1?'checked':''}}> {{ $data3->OPCI_NOMBRE }} <!--TERCERO NIVEL-->
                                        <span class="badge badge-soft-{{$data3->OPCI_ESTADO==1?'success':'danger'}}" style="float:right;">@if($data3->OPCI_ESTADO==1) &#x2713; @else &#10006; @endif </span>
                                        <ul class="tree">
                                        @foreach($dbAcessos as $data4)
                                            @if($data4->OPCI_TIPO==4 && $data4->OPCI_SUB_CODIGO==$data3->OPCI_CODIGO)
                                            <li>
                                                <input type="checkbox" onclick="guardarAcceso(this.checked,{{ $data4->OPCI_CODIGO }})" {{$data4->OPCI_ACCESO==1?'checked':''}}> {{ $data4->OPCI_NOMBRE }} <!--CUARTO NIVEL-->
                                                <span class="badge badge-soft-{{$data4->OPCI_ESTADO==1?'success':'danger'}}" style="float:right;">@if($data4->OPCI_ESTADO==1) &#x2713; @else &#10006; @endif </span>
                                                <ul class="tree">
                                                @foreach($dbAcessos as $data5)
                                                    @if($data5->OPCI_TIPO==5 && $data5->OPCI_SUB_CODIGO==$data4->OPCI_CODIGO)
                                                    <li>
                                                        <input type="checkbox" onclick="guardarAcceso(this.checked,{{ $data5->OPCI_CODIGO }})" {{$data5->OPCI_ACCESO==1?'checked':''}}> {{ $data5->OPCI_NOMBRE }} <!--QUINTO NIVEL-->
                                                        <span class="badge badge-soft-{{$data5->OPCI_ESTADO==1?'success':'danger'}}" style="float:right;">@if($data5->OPCI_ESTADO==1) &#x2713; @else &#10006; @endif </span>
                                                    </li>
                                                    @endif
                                                @endforeach
                                                </ul>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endif
    @endforeach

</ul>



<style>
    * {margin: 0; padding: 0; list-style: none;}
    ul.tree li {
    margin-left: 15px;
    position: relative;
    padding-left: 5px;
    }
    ul.tree li::before {
    content: " ";
    position: absolute;
    width: 1px;
    background-color: #000;
    top: 5px;
    bottom: -12px;
    left: -10px;
    }
    body > ul.tree > li:first-child::before {top: 12px;}
    ul.tree li:not(:first-child):last-child::before {display: none;}
    ul.tree li:only-child::before {
    display: list-item;
    content: " ";
    position: absolute;
    width: 1px;
    background-color: #000;
    top: 5px;
    bottom: 7px;
    height: 7px;
    left: -10px;
    }
    ul.tree li::after {
    content: " ";
    position: absolute;
    left: -10px;
    width: 10px;
    height: 1px;
    background-color: #000;
    top: 12px;
    }
</style>
<script>
    function guardarAcceso(CHECK,OPCI_CODIGO){
        let CHECKED = getValueChecked(CHECK);
        let USUA_CODIGO = getValue("ACCE_USUA_CODIGO");
        //console.log(CHECKED,OPCI_CODIGO,USUA_CODIGO)
        
        let url = "seguridad/grabar-acceso-usuario?OPCI_CODIGO="+OPCI_CODIGO+"&USUA_CODIGO="+USUA_CODIGO+"&CHECKED="+CHECKED;
        fetchGet(url,function(data){
            showMessage(data.accion,data.smg, "Alerta!");
        });
       
    }
</script>