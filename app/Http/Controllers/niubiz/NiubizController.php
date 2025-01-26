<?php

namespace App\Http\Controllers\niubiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class NiubizController extends Controller
{   
    public function terminosCondiciones(Request $request){

        $page_data['page_title'] = "Terminos y Condiciones";
        return view('niubiz.terminosycondiciones',$page_data);

    }
    public function terminosCondicionesTalleres(Request $request){

        $page_data['page_title'] = "Terminos y Condiciones";
        return view('niubiz.terminosycondicionestalleres',$page_data);

    }
}