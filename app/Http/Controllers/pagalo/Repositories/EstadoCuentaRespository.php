<?php
namespace App\Http\Controllers\pagalo\Repositories;
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
        $query = DB::select("
                SELECT
                    saldos_detalle.cidpers,
                    saldos_detalle.cidpred,
                    saldos_detalle.ctiping,
                    m.vdescri,
                    m.vobserv as tipo_tribu,
                    saldos_detalle.cperanio,
                    saldos_detalle.cperiod,
                    saldos_detalle.dfecven,
                    round(sum(saldos_detalle.imp_insol), 2) AS saldo_fijo,
                    round(sum(saldos_detalle.costo_emis), 2) AS costo_emis,
                    round(sum(saldos_detalle.reajuste), 2) AS reajuste,
                    round(sum(saldos_detalle.mora), 2) AS mora,
                    round(sum(saldos_detalle.imp_insol)+sum(saldos_detalle.costo_emis)+sum(saldos_detalle.reajuste)+sum(saldos_detalle.mora),2) AS total,
                    CONCAT(saldos_detalle.cidpred,saldos_detalle.ctiping,saldos_detalle.cperanio,saldos_detalle.cperiod) AS llave,
                    CURRENT_DATE AS fecha_calculo
                FROM (
                    SELECT 
                        a.cidpers,
                        (CASE WHEN a.ctiping='0000000273' THEN '1' ELSE a.cidpred END) AS cidpred,
                        a.ctiping,
                        a.ctiprec,
                        a.cperanio,
                        a.cperiod,
                        SUM(a.imp_insol) AS imp_insol,
                        SUM(a.costo_emis) AS costo_emis,
                        CAST(b.dfecven AS DATE) AS dfecven,
                        SUM(a.imp_insol * registro.factor_reajuste(a.dfecven::date, a.cperiod, ctiprec)-a.imp_insol) AS reajuste,
                        registro.factor_reajuste(CAST(b.dfecven AS DATE), a.cperiod, a.ctiprec) * 
                        (CASE WHEN round(registro.factor_interes(CAST(b.dfecven AS DATE),CURRENT_DATE), 3) = 0 THEN 0 ELSE registro.factor_interes(CAST(b.dfecven AS DATE),CURRENT_DATE) END) AS factor_mora_d,
                        SUM(a.imp_insol) * registro.factor_reajuste(CAST(b.dfecven AS DATE), a.cperiod, a.ctiprec) * 
                        (CASE WHEN round(registro.factor_interes(CAST(b.dfecven AS DATE),CURRENT_DATE), 3) = 0 THEN 0 ELSE registro.factor_interes(CAST(b.dfecven AS DATE),CURRENT_DATE) END) AS mora
                    FROM tesoreria.mestcta AS a
                    INNER JOIN tesoreria.mreajus AS b ON a.cperanio = b.cperanio AND a.ctiping = b.ctiping AND REPLACE(SUBSTRING(a.cperiod,1,2),'A','')::int = b.cnromes
                    WHERE a.nestado IN ('0','3','B','D','F','I','J','K','N','P','R') 
                    AND a.ctiping IN ('0000000273','0000000278')
                    GROUP BY a.cidpers, a.cidpred, a.ctiping, a.ctiprec, a.cperanio, a.cperiod, b.dfecven
                    HAVING a.cidpers = :cidpers
                ) AS saldos_detalle
                INNER JOIN mconten m ON saldos_detalle.ctiping = m.idsigma
                GROUP BY
                    saldos_detalle.cidpers,
                    saldos_detalle.cidpred,
                    saldos_detalle.ctiping,
                    m.vdescri,
                    m.vobserv,
                    saldos_detalle.cperanio,
                    saldos_detalle.cperiod,
                    saldos_detalle.dfecven
                HAVING SUM(saldos_detalle.imp_insol + saldos_detalle.costo_emis) > 0
                AND saldos_detalle.cidpers = :cidpers
            ", ['cidpers' => $codigo]);

        return $query;
    }
    private function getFormattedData($data)
    {
        try {
            return CuentaResource::collection($data)->toArray(app(Request::class));
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

}
