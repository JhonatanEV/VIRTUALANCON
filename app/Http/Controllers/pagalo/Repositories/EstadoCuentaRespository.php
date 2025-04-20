<?php
namespace App\Http\Controllers\pagalo\Repositories;

use App\Http\Controllers\pagalo\Models\RegistroPago;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Pagalo\Resources\CuentaResource;
use Illuminate\Http\Request;

class EstadoCuentaRespository
{
    public function getData($codigo)
    {
        try {
            $data = $this->getQuery($codigo);
            return $this->getFormattedData($data);
        } catch (\Exception $e) {
            return  response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
        
    }

    public function getQuery($codigo)
    {
        $CODIGO_OPERACION = date('YmdHis') . rand(1000, 9999);
        try {

            RegistroPago::whereNull('pushernumber')
            ->where('cidpers', $codigo)
            ->delete();

            $query_detalle = DB::select("
                    INSERT INTO virtual.\"REGISTRO_PAGO\"(CIDPERS, CIDPRED, CTIPING, CTIPREC, CPERANIO, CPERIOD, IDSIGMA, IMP_INSOL, COSTO_EMIS, DFECVEN, REAJUSTE, FACTOR_MORA_D, MORA_D,DESCUENTO, CODIGO_OPERACION)                        
                        SELECT 
                            a.cidpers,
                            (CASE WHEN a.ctiping='0000000273' THEN '1' ELSE a.cidpred END) AS cidpred,
                            a.ctiping,
                            a.ctiprec,
                            a.cperanio,
                            a.cperiod,
                            a.idsigma,
                            SUM(a.imp_insol) AS imp_insol,
                            SUM(a.costo_emis) AS costo_emis,
                            CAST(b.dfecven AS DATE) AS dfecven,
                            SUM(a.imp_insol * registro.factor_reajuste(a.dfecven::date, a.cperiod, ctiprec)-a.imp_insol) AS reajuste,
                            registro.factor_reajuste(CAST(b.dfecven AS DATE), a.cperiod, a.ctiprec) * 
                            (CASE WHEN round(registro.factor_interes(CAST(b.dfecven AS DATE),CURRENT_DATE), 3) = 0 THEN 0 ELSE registro.factor_interes(CAST(b.dfecven AS DATE),CURRENT_DATE) END) AS factor_mora_d, 
                            SUM(a.imp_insol) * registro.factor_reajuste(CAST(b.dfecven AS DATE), a.cperiod, a.ctiprec) * 
                            (CASE WHEN round(registro.factor_interes(CAST(b.dfecven AS DATE),CURRENT_DATE), 3) = 0 THEN 0 ELSE registro.factor_interes(CAST(b.dfecven AS DATE),CURRENT_DATE) END) AS mora,
                            0 descuento,
                            :codigo_operacion
                        FROM tesoreria.mestcta AS a
                        INNER JOIN tesoreria.mreajus AS b ON a.cperanio = b.cperanio AND a.ctiping = b.ctiping AND REPLACE(SUBSTRING(a.cperiod,1,2),'A','')::int = b.cnromes
                        WHERE a.nestado IN ('0','3','B','D','F','I','J','K','N','P','R') 
                        AND a.ctiping IN ('0000000273','0000000278')
                        GROUP BY a.cidpers, a.cidpred, a.ctiping, a.ctiprec, a.cperanio, a.cperiod, b.dfecven, a.idsigma
                        HAVING a.cidpers = :cidpers
                ", ['cidpers' => $codigo, 'codigo_operacion' => $CODIGO_OPERACION]);

                $query = DB::select("
                                SELECT
                                    rp.cidpers,
                                    rp.cidpred,
                                    rp.ctiping,
                                    m.vdescri,
                                    m.vobserv AS tipo_tribu,
                                    rp.cperanio,
                                    rp.cperiod,
                                    rp.dfecven,
                                    round(sum(rp.imp_insol), 2) AS saldo_fijo,
                                    round(sum(rp.costo_emis), 2) AS costo_emis,
                                    round(sum(rp.reajuste), 2) AS reajuste,
                                    round(sum(rp.mora_d), 2) AS mora,
                                    round(sum(rp.descuento), 2) AS descuento,
                                    round(sum(rp.imp_insol) + sum(rp.costo_emis) + sum(rp.reajuste) + sum(rp.mora_d), 2) AS total,
                                    CONCAT(rp.cidpred, rp.ctiping, rp.cperanio, rp.cperiod) AS llave,
                                    STRING_AGG(rp.idsigma::text, ',') AS idsigma_agrupados,
                                    CURRENT_DATE AS fecha_calculo,
                                    rp.codigo_operacion
                                FROM virtual.\"REGISTRO_PAGO\" AS rp
                                INNER JOIN mconten m ON rp.CTIPING = m.idsigma
                                WHERE rp.cidpers = :cidpers
                                AND rp.codigo_operacion = :codigo_operacion
                                GROUP BY
                                    rp.cidpers,
                                    rp.cidpred,
                                    rp.ctiping,
                                    m.vdescri,
                                    m.vobserv,
                                    rp.cperanio,
                                    rp.cperiod,
                                    rp.dfecven,
                                    rp.codigo_operacion
                                HAVING SUM(rp.imp_insol + rp.costo_emis) > 0
                                ORDER BY rp.ctiping, rp.cperanio desc, rp.cperiod
                                ", ['cidpers' => $codigo, 'codigo_operacion' => $CODIGO_OPERACION]);
        
            return $query;
        } catch (\Exception $th) {
            \Log::error($th->getMessage());
            return response()->json($th->getMessage(), 500);
        }
    }
    private function getFormattedData($data)
    {
        try {
            return CuentaResource::collection($data)->toArray(app(Request::class));
        } catch (\Exception $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

}
