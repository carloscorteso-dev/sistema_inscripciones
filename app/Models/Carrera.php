<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    //
    protected $table = 'carreras';
    protected $fillable = [
        'nombre',
        
    ];
    //una carrera tiene muchas generaciones
    public function generaciones()
    {
        return $this->hasMany(Generacion::class);
    }

    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }
}
