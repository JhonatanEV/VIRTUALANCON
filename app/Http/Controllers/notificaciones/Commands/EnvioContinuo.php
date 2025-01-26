<?php

namespace App\Http\Controllers\notificaciones\Commands;

use Illuminate\Console\Command;
#use App\Http\Controllers\notificaciones\Services\NotificacionService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class EnvioContinuo extends Command
{
    protected $signature = 'notificacion:programacion';
    protected $description = 'Control de envio de bandeja a Ultramsg';

    public function handle()
    {   
        while (true) {

            #$notificacionService = new NotificacionService;

            /*$params=array(
                'page' => '1',
                'limit' => '1',
                'status' => 'queue', //en cola
                'sort' => 'desc'
            );*/

            #if($envio):
            #$res =$notificacionService->get_respuesta_ultramsg($params);
            #$res = json_decode($res, true);

            #if(!empty($res['messages'])):

                #Log::channel('notificacion')->debug('Hay notificaciones en cola: '.json_encode($res['messages']));
            #else:

                #Artisan::call('notificacion:descargarultra');

                Artisan::call('notificacion:enviar');

                #Log::channel('notificacion')->debug('No hay notificaciones en cola');

            #endif;
            #endif;
            
            sleep(10);
        }
    }
}
