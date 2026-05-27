<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    //
    protected $guarded =[];
    protected $fillable = [
        'carrera_id',
        'folio_alumno',
        'curp',
        'nombre',
        'ap_paterno',
        'ap_materno',
        'foto',
        'calle',
        'numero',
        'colonia',
        'municipio',
        'entidad_federativa',
        'codigo_postal',
        'celular',
        'correo_electronico',
        //datos del contacoto de emergencia
        'nombre_contacto',
        'parentesco_contacto',
        'calle_contacto',
        'numero_contacto',
        'colonia_contacto',
        'municipio_contacto',
        'entidad_federativa_contacto',
        'codigo_postal_contacto',
        'celular_contacto',
        'correo_electronico_contacto'
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }
}
