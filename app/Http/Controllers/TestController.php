<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

class TestController extends Controller
{ 
    protected $pdfService;

    public function __construct()
    {
    }
    public function index(){
        $mensaje = "Estimado(a) <b></b>,<br>Bienvenido a la Plataforma Virtual de la Municipalidad.<br><br>Para acceder a la plataforma, por favor ingrese con los siguientes datos:<br><br>Usuario: <br>Contraseña: ";
		enviar_correo('juctan.espinoza@gmail.com', $mensaje);
    }
}