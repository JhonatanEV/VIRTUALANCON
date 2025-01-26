<?php

namespace App\Http\Controllers\Contribuyente;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContribuyenteController extends ApiController
{
    public function cuponera(){

       # $page_data['url_file'] = public_path('/storage/cuponera/2025/16712.pdf');
        $page_data['url_file'] = Storage::disk('cuponera')->url('2025/16712.pdf');
        $page_data['titulo_principal'] = 'Cuponera Virtual';
        $page_data['page_directory'] = 'contribuyente';
        $page_data['page_name'] = 'viewCuponera';
        $page_data['page_title'] = 'Cuponera Virtual';
        $page_data['breadcrumbone'] = 'Págalo Ancón';
        $page_data['breadcrumb'] = 'Cuponera Virtual';
        return view('index',$page_data);
    }
}