<?php

namespace App\Http\Controllers\pagalo;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\pagalo\Services\PdfReciboServices;

class ReciboPdfController extends Controller
{   
    protected $pdfService;
    public function __construct()
    {
        $this->pdfService = new PdfReciboServices();
    }
    public function index()
    {
    }

    public function generatePdf(Request $request, $nrorecibo)
    {   
       return $this->pdfService->generateRecibo($nrorecibo, 'I');
    }
}
