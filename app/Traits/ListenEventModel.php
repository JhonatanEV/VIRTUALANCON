<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

trait ListenEventModel
{
    // protected static function bootListenEventModel()
    // {
    //     static::creating(function ($model) {
    //         $model->FEC_USUREG = Carbon::now();
    //         $model->COD_USUREG = Auth::check() ? Auth::user()->COD_USUARIO : 'ADMIN';
    //         $model->COD_EMP = Auth::user()->COD_EMP;
    //     });

    //     static::updating(function ($model) {
    //         $model->FEC_USUMOD = Carbon::now();
    //         $model->COD_USUMOD = Auth::check() ? Auth::user()->COD_USUARIO : 'ADMIN';
    //     });
    // }
}
