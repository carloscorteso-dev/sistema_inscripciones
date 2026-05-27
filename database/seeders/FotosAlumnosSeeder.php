<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FotosAlumnosSeeder extends Seeder
{
    /**
     * Llena el campo "foto" de cada alumno con la ruta alumnos/CURP.jpg
     * basándose en su CURP registrada en la base de datos.
     */
    public function run(): void
    {
        $alumnos = DB::table('alumnos')->whereNotNull('curp')->get();

        foreach ($alumnos as $alumno) {
            DB::table('alumnos')
                ->where('id', $alumno->id)
                ->update([
                    'foto' => 'alumnos/' . $alumno->curp . '.jpg',
                ]);
        }

        $this->command->info('✅ Fotos sembradas correctamente para ' . $alumnos->count() . ' alumnos.');
    }
}
