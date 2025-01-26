<?php
namespace App\Traits;

trait FiltrosReporteTrait {    

    public function getValueOrLike($value){                
        return ($value!='null')?$value:'%';
    }

    public function getValueOrLikeStrPad($value,$str_pad){                
        return ($value!='null')?str_pad($value, $str_pad):'%';
    }

    public function getCondicionLaboral($value){      

        $cod_condicion = '%';
        $like = ' LIKE ';               

        if($value=='ind_cas'){
            $cod_condicion = '02';    
            $like = '=';                             
        }

        if($value=='ind_cas_dif'){
            $cod_condicion = '02';
            $like = '<>';                       
        }

        return $like. "'".$cod_condicion."'";
    }
}