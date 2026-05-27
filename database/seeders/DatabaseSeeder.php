<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\User;
use App\Models\Generacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
        ]);

        Carrera::create([
            'nombre' => 'Licenciatura en Medicina Integral y Salud Comunitaria',
        ]);
        Carrera::create([
            'nombre' => 'Ingeniería en Pesca, Acuacultura y Ciencias de la Atmósfera',
        ]);

        Generacion::create([
            'carrera_id' => 1,
            'nombre' => 'GENERACION 2023-1',
        ]);

        Generacion::create([
            'carrera_id' => 1,
            'nombre' => 'GENERACION 2023-2',
        ]);
        Generacion::create([
            'carrera_id' => 1,
            'nombre' => 'GENERACION 2024-2',
        ]);
        Generacion::create([
            'carrera_id' => 1,
            'nombre' => 'GENERACION 2025-2',
        ]);
        Generacion::create([
            'carrera_id' => 1,
            'nombre' => 'GENERACION 2026-2',
        ]);

        

      
    }
}
