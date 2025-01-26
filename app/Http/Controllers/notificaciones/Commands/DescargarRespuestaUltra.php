<?php

namespace App\Http\Controllers\Api\Notificacion\Commands;

use App\Http\Controllers\Api\Notificacion\Services\NotificacionService;
use Illuminate\Console\Command;
use App\Http\Controllers\Api\Notificacion\Models\UltraSmg;
use App\Http\Controllers\Api\Notificacion\Models\Bandeja;

class DescargarRespuestaUltra extends Command
{
    protected $signature = 'notificacion:descargarultra';
    protected $description = 'Descargar respuesta de WhatsApp de Ultramsg';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        try {
            $notificacionService = new NotificacionService;
            $params=array(
                'page' => '1',
                'limit' => '100',
                'status' => 'all',
                'sort' => 'desc',
                'id' => '',
                'referenceId' => '',
                'from' => '',
                'to' => '',
                'ack' => '',
                'msgId' => '',
                'start_date' => '',
                'end_date' => ''
            );
            $res =$notificacionService->get_respuesta_ultramsg($params);
            $res = json_decode($res, true);
            $instancia = config('services.ultramsg.instancia');

            foreach ($res['messages'] as $value):

                $caption = !empty($value['metadata']['caption']) ? $value['metadata']['caption'] : '';
                
                if(UltraSmg::where('ID', $value['id'])
                    ->where('INSTANCIA',$instancia)
                    ->where('STATUS',$value['status'])
                    ->exists()
                ){
                    return;
                }else{
                    UltraSmg::insert([
                        'ID' => $value['id'],
                        'REFERENCEID' => $value['referenceId'],
                        'FROM' => $value['from'],
                        'TO' => $value['to'],
                        'BODY' => $value['body'],
                        'PRIORITY' => $value['priority'],
                        'STATUS' => $value['status'],
                        'ACK' => $value['ack'],
                        'TYPE' => $value['type'],
                        'CREATED_AT' => $value['created_at'],
                        'SENT_AT' => $value['sent_at'],
                        'METADATA' => $caption,
                        'INSTANCIA' => $instancia
                    ]);
                }

                Bandeja::where('BAND_IDULTRA', $value['id'])
                ->where('BAND_INSTANCIA',$instancia)
                ->update(['BAND_ESTADOULTRA' => $value['status']]);
                
            endforeach;
        } catch (\Exception $e) {
            \Log::channel('notificacion')->debug('EROROR EN DESCARGA DE ULTRMSG '.$e->getMessage());
        }
    }
}
