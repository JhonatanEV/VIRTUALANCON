<?php
namespace App\Models\Casilla;

use Illuminate\Database\Eloquent\Model;
use App\Models\Casilla\Categoria;
use App\Models\Casilla\Tipo;
use App\Models\Casilla\Adjunto;
use App\Models\General\Persona;

class Bandeja extends Model
{
    protected $table = 'CASILLA.BANDEJA';

    protected $primaryKey = 'BAND_CODIGO';

    public $keyType = 'int';

    public $timestamps = false;

    public $incrementing = true;
    protected $fillable = [
        'TIPO_CODIGO',
        'CATE_CODIGO',
        'BAND_ASUNTO',
        'BAND_DETALLE',
        'BAND_EMISOR',
        'BAND_DESTINO',
        'BAND_ADJUNTO',
        'BAND_FEC_NOTIFICA',
        'BAND_FEC_REGISTRO',
        'BAND_FEC_LEIDO',
        'BAND_LEIDO',
        'BAND_IDENTIFICADOR',
        'BAND_OPERADOR',
        'BAND_ESTACION',
        'BAND_ESTADO',
    ];
    protected static function boot()
    {
        parent::boot();
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class, 'CATE_CODIGO', 'CATE_CODIGO');
    }
    public function tipo(){
        return $this->belongsTo(Tipo::class, 'TIPO_CODIGO', 'TIPO_CODIGO');
    }
    public function adjunto(){
        return $this->hasMany(Adjunto::class, 'BAND_CODIGO', 'BAND_CODIGO');
    }
    public function persona(){
        return $this->belongsTo(Persona::class, 'BAND_DESTINO', 'PERS_DOCUMENTO');
    }
    public function getFormatFecRegistroAttribute(){
        return date('d/m h:i a', strtotime($this->BAND_FEC_REGISTRO));
    }
}