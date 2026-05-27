<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    //
    protected $table = 'ciclos';
    protected $fillable = [
        'nombre',
        'generacion_id'
    ];
    //un ciclo pertenece a una generacion
    public function generacion()
    {
        return $this->belongsTo(Generacion::class);     
    }
}
