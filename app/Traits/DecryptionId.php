<?php
namespace App\Traits;
use App\Helpers\Encryptor;
 
trait DecryptionId
{
    /**
     * Funcion que recupera el id del modelo y lo encripta
    * @param $value valor del id autonumerico
    * @return string con el valor del id encriptado
    */
    public function setIdAttribute($valor)
    {
        $this->attributes['id'] =  Encryptor::decrypt($valor);
    }

    public function decryptId($id)
    {
        return Encryptor::decrypt($id);
    }

}