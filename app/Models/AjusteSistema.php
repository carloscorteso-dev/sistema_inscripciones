<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AjusteSistema extends Model
{
    //
    protected $fillable = [
        'nombre',
        'logotipo',
        'correo',
        'telefono',
        'direccion',
    ];
}
