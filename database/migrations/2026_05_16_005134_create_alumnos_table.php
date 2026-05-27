<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('cascade');
            $table->string('folio_alumno')->unique();
            $table->string('curp')->unique();
            $table->string('nombre');
            $table->string('ap_paterno');
            $table->string('ap_materno');
            $table->string('foto')->nullable();
            $table->string('calle');
            $table->string('numero');
            $table->string('colonia');
            $table->string('municipio');
            $table->string('entidad_federativa');
            $table->string('codigo_postal');
            $table->string('celular');
            $table->string('correo_electronico');
            //datos del contacoto de emergencia
            $table->string('nombre_contacto');
            $table->string('parentesco_contacto');
            $table->string('calle_contacto');
            $table->string('numero_contacto');
            $table->string('colonia_contacto');
            $table->string('municipio_contacto');
            $table->string('entidad_federativa_contacto');
            $table->string('codigo_postal_contacto');
            $table->string('celular_contacto');
            $table->string('correo_electronico_contacto');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
