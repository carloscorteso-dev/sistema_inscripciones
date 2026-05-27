<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    //
    protected $guarded =[];
    protected $fillable = [
        'alumno_id',
        'ciclo_id',
        'folio_comprobante',
        'estatus',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class,'ciclo_id');
    }
}
