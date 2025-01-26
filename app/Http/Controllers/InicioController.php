<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Url;
use Session;

class InicioController extends Controller
{
    public function redirectToInicio(){
        return redirect()->route('inicio');
    }
    public function index(){

        $page_data['page_title'] = config('app.SISTEMA');
        return view('inicio/inicio',$page_data);
    }
}
