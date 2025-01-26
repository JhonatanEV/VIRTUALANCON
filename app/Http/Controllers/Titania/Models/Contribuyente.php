<?php

namespace App\Http\Controllers\Titania\Models;
use Illuminate\Database\Eloquent\Model;

class Contribuyente extends Model
{
    protected $table = 'public.mperson';

    protected $primaryKey = 'idsigma';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}