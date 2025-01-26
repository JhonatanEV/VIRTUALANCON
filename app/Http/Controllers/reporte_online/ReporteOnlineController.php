<?php
namespace App\Http\Controllers\reporte_online;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReporteOnlineController extends Controller
{   

    public function selectCanchas(Request $request){
        try {
            unset($parametros);
            $parametros[] = array('@ACCION',1);
            $parametros[] = array('@FEC_INI',$request->fec_ini);
            $parametros[] = array('@FEC_FIN',$request->fec_hasta);
            $AllEcuenta = ejec_store_procedure_sql("REPORTE.REPORTES_ONLINE",$parametros);
        } catch (\Throwable $th) {
            return response()->json(['data' => [],'error' => $th->getMessage()]);
        }

        return response()->json(['data' => $AllEcuenta]);
    }

    public function selectTalleres(Request $request){
        try {
            unset($parametros);
            $parametros[] = array('@ACCION',2);
            $parametros[] = array('@FEC_INI',$request->fec_ini);
            $parametros[] = array('@FEC_FIN',$request->fec_hasta);
            $AllEcuenta = ejec_store_procedure_sql("REPORTE.REPORTES_ONLINE",$parametros);
        } catch (\Throwable $th) {
            return response()->json(['data' => [],'error' => $th->getMessage()]);
        }

        return response()->json(['data' => $AllEcuenta]);
    }
}