<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generacion extends Model
{
    //
    protected $table = 'generacions';
    protected $fillable = [
        'carrera_id',
        'nombre',
        
    ];
    //una generacion pertenece a una carrera
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
    //un generacion tiene muchos ciclos
    public function ciclos()
    {
        return $this->hasMany(Ciclo::class);
    }
}
