<div class="row">
	<div class="col-12">
        <form action="" id="fmrImprimir" method="post" target="_blank"> <!--target="_blank"-->
            <input type="hidden" name="codigo" value="{{Session::get('SESS_CODIGO')}}">
            <input type="hidden" name="nom_contri" value="{{Session::get('SESS_NOMBRE_COMPLETO')}}">
            <input type="hidden" name="direccion" value="{{Session::get('SESS_PERS_DIRECCION')}}">

            <input type="hidden" name="txtMontoSeleccion" id="txtMontoSeleccion" value="0">
                <input type="hidden" name="CTAC_chCODBAN" 	id="txtcod_recibo" value="0">
                <input type="hidden" name="txtjson_deta_cta" id="txtjson_deta_cta" value="{{base64_encode($json_deta_cta)}}">
                <input type="hidden" name="txtjson_agr_cta" 	id="txtjson_agr_cta" value="{{base64_encode($json_agr_cta)}}">
            </form>
            <div class="">
                <table id="row_callback" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead style="background-color: #6464644f;">
                    <tr>
                        <th></th>
                        <th class="text-center fw-bold">MATERIA</th>
                        <th class="text-center fw-bold">AÑO</th>
                        <th class="text-center fw-bold">PER.</th>
                        <th class="text-center fw-bold">F. VENC</th>
                        <th class="text-center fw-bold">INSOLUTO</th>
                        <th class="text-center fw-bold">EMISION</th>
                        <th class="text-center fw-bold">REAJUSTE</th>
                        <th class="text-center fw-bold">INTERES</th>
                        <th class="text-center fw-bold">DSCTO</th>
                        <th class="text-center fw-bold">TOTAL</th>
                        <th class="text-center fw-bold">REFERENCIA</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($cta_agrupado as $resul)
                   
                    <tr>
                        <td class="dtr-control"></td>
                        <td>{{trim(substr($resul['CCOR_chDESAUX'], 0,70))}}</td>
                        <td>{{$resul['ANIO_P_chCODANO']}}</td>
                        <td>{{$resul['CTAC_chPERCTA']}}</td>
                        <td>{{date("d/m/Y",strtotime($resul['CTAC_chFECVEN']))}}</td>
                        <td class="text-end">{{number_format($resul['CTAC_deMONINS'],2)}}</td>
                        <td class="text-end">{{number_format($resul['CTAC_deMONEMI'],2)}}</td>
                        <td class="text-end">{{number_format($resul['CTAC_deMONREA'],2)}}</td>
                        <td class="text-end">{{number_format($resul['CTAC_deMONIAC']+$resul['CTAC_deMONINT']+$resul['CTAC_deMONOTR'],2)}}</td>
                        <td class="text-end">{{number_format($resul['CTAC_deMONDSC'],2)}}</td>
                        <td class="text-end">{{number_format($resul['CTAC_deMONTOT'],2)}}</td>
                        <td>{{$resul['CTAC_chDOCREF']}}</td>
                    </tr>
                    @endforeach
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
                                <th class="text-lg-center">TOTAL</th>
                                <th class="text-end" id="thTotal">0.00</th>
                                <th></th>
                            </tr>
                        </tfoot>
                </table> 
            </div>       
</div>
<style>

  	#row_callback tr.dtrg-group td{
    	background-color: #3e3e3e08 !important;
	   color: #1d2c48 !important;
	   padding: 0 5px 0;
   }
   .btn-outline-primary:hover{
    	background-color: #5b8ffd73!important;
   }
   .btn-check:checked+.btn-outline-primary, .btn-check:active+.btn-outline-primary, .btn-outline-primary:active, .btn-outline-primary.active, .btn-outline-primary.dropdown-toggle.show{
    	background-color: #3576fd!important;
    	border-color: #0a4ad1!important;
   }
   #row_callback{
   	/*table-layout: fixed !important;*/
    word-wrap:break-word;
   }

   table.dataTable.nowrap th, table.dataTable.nowrap td{
   	white-space: unset;
   }
</style>

<script>
    $(document).ready(function(){

        let columna = [10];
        var table = $("#row_callback").DataTable({
                        "ordering": false,   	
                    //"scrollY":        "700px",
                    //"scrollCollapse": true,
                    "paging":true,
                    "searching": false,
                    "columnDefs": [
                        { "visible": false, "targets": [1,2] }
                    ],
                    displayLength:10,
                    bAutoWidth:false,
                    aoColumns: [
                        { "sWidth": "0%",  "targets": [0]},
                        { "sWidth": "5%",  "targets": [1]},
                        { "sWidth": "5%",  "targets": [2]},
                        { "sWidth": "5%",  "targets": [3]},
                        { "sWidth": "10%", "targets": [4] },
                        { "sWidth": "10%", "targets": [5] },
                        { "sWidth": "10%", "targets": [6] },
                        { "sWidth": "10%", "targets": [7] },
                        { "sWidth": "10%", "targets": [8]},
                        { "sWidth": "10%", "targets": [9]},
                        { "sWidth": "10%" ,  "targets": [10]},
                        { "sWidth": "20%",  "targets": [11] }
                    ],
                    rowGroup:{
                        dataSrc: [1,2],
                        endRender: function ( rows, group ) {
                            var result = 0;
                            columna.forEach(function(column) {
                                var ageAvg = rows
                                    .data()
                                    .pluck(column)
                                    .reduce(function(a, b) {
                                    
                                    return a + b.replace(',', '') * 1;
                                    }, 0);
                                result +=  ageAvg ;

                            });
                            var sub_total = $.fn.dataTable.render.number(',', '.', 2).display( result );
                            return $(`<tr/>`)
                            .append( `<td colspan="10" class="text-end">
                                    <div class="row">
                                        <div class="col-md-9">SUB TOTAL</div>
                                        <div class="col-md-3 text-start">${sub_total}</div>
                                    </div></td>`);

                            // return $('<tr/>')
                            // .append( '<td colspan="7" class="text-end">SUB TOTAL  '+group+'</td>' )
                            // .append( '<td/>' )
                            // .append( '<td class="text-end">S/ '+sub_total+'</td>' )
                            // .append( '<td></td>' );

                        }
                    },
                    createdRow:function(row, data, dataIndex){
                        if(data[0]=="1"){
                            $('td:eq(0)', row).attr('colspan', 0);
                            this.api().cell($('td:eq(0)', row))
                        }
                    },
                    footerCallback: function (row, data, start, end, display) { 
                            var totalAmount = 0;
                            for (var i = 0; i < data.length; i++) {
                                totalAmount += parseFloat(data[i][10]);
                            }
                            totalAmount = number_format(totalAmount,2,'.',',');
                            $("#thTotal").html("S/ "+totalAmount);
                        }
            });
        });
</script>