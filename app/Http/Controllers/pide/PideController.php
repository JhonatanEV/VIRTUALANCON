<?php

namespace App\Http\Controllers\pide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PideController extends Controller
{   
    public function validarPersona(Request $request){
		$TIPO = $request->get('TIPO');
		$DOCUMENTO = $request->get('DOCUMENTO');		
		$LIMIT = $request->get('LIMIT');		

		$PIDE = ejec_pide_sunat_api($TIPO,$DOCUMENTO);

		$PIDE = json_decode($PIDE,TRUE);

		if($LIMIT==1 && $PIDE['DATA']['STATUS']==1){
			$array = array(
				'APE_MATERNO'=>$PIDE['DATA']['APE_MATERNO'],
				'APE_PATERNO'=>$PIDE['DATA']['APE_PATERNO'],
				'NOMBRE_COMPLETO'=>$PIDE['DATA']['NOMBRE_COMPLETO'],
				'DIRECCION'=>$PIDE['DATA']['DIRECCION'],
			);
			return $array;
		}

		if($PIDE['DATA']['STATUS']==1){
			$FOTO 		= $PIDE['DATA']['FOTO'];

			if(!empty($FOTO)):
				$img = explode(',', $FOTO)[1];
				$imageData = base64_decode($img);   
				$FOTO = $DOCUMENTO.'.png';
				$filePath = public_path('img_datos') . '/'.$FOTO;
				file_put_contents($filePath, $imageData);
			endif;
		}
		
		//var_dump($PIDE['DATA']);
		return $PIDE;
	}
}