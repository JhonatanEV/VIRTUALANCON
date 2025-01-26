<?php

namespace App\Http\Controllers\notificaciones\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Http\Controllers\notificaciones\Models\Sistema;
use App\Http\Controllers\notificaciones\Models\Bandeja;
use App\Http\Controllers\notificaciones\Models\Tipo;
use App\Http\Controllers\notificaciones\Models\Historial;
use App\Http\Controllers\notificaciones\Services\NotificacionService;
use Illuminate\Support\Facades\Log;

class EnviarNotificacion extends Command
{
    protected $signature = 'notificacion:enviar';
    protected $description = 'Alerta de notificaciones';

    protected $NotificacionService;
    public function __construct()
    {
        $this->NotificacionService = new NotificacionService();
        parent::__construct();
    }

    public function handle()
    {   
        try {
            $sistemas = Sistema::OrderBy('SIS_PRIORIDAD','DESC')->get();
            $currentDate = Carbon::now()->format('Y-m-d');

            foreach ($sistemas as $sistema):
                #data correo
                $datosBandejaCorreo = Bandeja::where('SIS_CODIGO', $sistema->SIS_CODIGO)
                                        ->Where('BAND_ENVIADO',NULL)
                                        ->Where('BAND_ESTADO',0)
                                        ->Where('TIPO_CODIGO',9)
                                        ->whereDate('BAND_CREADO', $currentDate)
                                        ->orderBy('BAND_CREADO', 'desc')
                                        ->limit(10)
                                        ->get();
                                        
                foreach ($datosBandejaCorreo as $alerta):

                    $tipoBandeja = Tipo::where('TIPO_CODIGO', $alerta->BAND_TIPO_CODIGO)->first();
                    
                    $resWhatsApp= array();
                    $resWhatsApp['sent'] = 'true';
                    $resWhatsApp['message'] = 'OK';
                    $resWhatsApp['id'] = 0;

                    $paramsUltra = array(
                        'body'      => $alerta->BAND_MENSAJE,
                        'image'     => $alerta->BAND_URL,
                        'caption'   => $alerta->BAND_MENSAJE,
                        'sticker'   => $alerta->BAND_URL,
                        'filename'  => $alerta->BAND_FILENAME,
                        'document'  => $alerta->BAND_URL,
                        'audio'     => $alerta->BAND_URL,
                        'contact'   => $alerta->BAND_MENSAJE,
                        'address'   => $alerta->BAND_MENSAJE,
                        'lat'       => $alerta->BAND_LATITUD,
                        'lng'       => $alerta->BAND_LONGITUD,
                    );

                    $resWhatsApp['sent'] = 'true';
                    $resWhatsApp['message'] = 'success';
                    $resWhatsApp['id'] = 0;
                    $instancia = config('services.ultramsg.instancia');

                    if(filter_var($alerta->BAND_PARA, FILTER_VALIDATE_EMAIL)):

                        $adjuntos = array();
                        if($alerta->BAND_URL!=''):
                            $adjuntos[] = $alerta->BAND_URL;
                        endif;
                        $this->NotificacionService->enviar_correo_notificacion($alerta->BAND_PARA, $alerta->BAND_MENSAJE, $adjuntos);
                        $resWhatsApp['sent'] = 'mail';

                    else:
                        $resWhatsApp['sent'] = 'false';
                        $resWhatsApp['message'] = 'No es un correo válido';
                        Log::error('No es un correo válido'.$alerta->BAND_PARA);
                    endif;
                    //Actualizar el estado de la notificacion
                    $alerta->BAND_ENVIADO = date('Y-m-d H:i:s');
                    $alerta->BAND_ESTADO = 1;
                    $alerta->save();
                        
                    Historial::insert([
                        'HIST_BAND_CODIGO'  => $alerta->BAND_CODIGO,
                        'HIST_MENSAJE'      => $alerta->BAND_MENSAJE,
                        'HIST_FEC_ENVIADO'  => date('Y-m-d H:i:s'),
                        'HIST_SEND'         => isset($resWhatsApp['sent']) ? $resWhatsApp['sent'] : '',
                        'HIST_MESSAGE'      => isset($resWhatsApp['message']) ? $resWhatsApp['message'] : '',
                        'HIST_IDENVIADO'    => isset($resWhatsApp['id']) ? $resWhatsApp['id'] : '',
                    ]);
                endforeach;
            
            endforeach;

        } catch (\Throwable $th) {

            Log::error('Error en el envio de notificaciones: '.$th->getMessage());
        }
        
    }
}