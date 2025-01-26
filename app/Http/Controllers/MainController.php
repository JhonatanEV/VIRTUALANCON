<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Url;
use Illuminate\Support\Facades\DB;
use Session;

class MainController extends Controller
{   
    public function __construct()
    {
        #$this->middleware('auth');
    }
    public function index(){
        
        $page_data['page_directory'] = 'home';
    	$page_data['page_name'] = 'content';
    	$page_data['page_title'] = 'Inicio ';
        $page_data['breadcrumb'] = 'dashboard';
        return view('index',$page_data);
    }
}