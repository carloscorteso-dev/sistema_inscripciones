<?php

use App\Http\Controllers\AjusteSistemaController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\GeneracionController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $ajuste = \App\Models\AjusteSistema::first();
    // if ($ajuste && $ajuste->estado_sistema === 'bloqueado') {
    //     return view('sistema_bloqueado');
    // }
    return view('admin.index',compact('ajuste'));
})->name('dashboard')->middleware('auth');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para ajuste del sistema
Route::get('/admin/ajuste_sistema',[AjusteSistemaController::class, 'index'])->name('admin.ajuste_sistema')->middleware('auth');
Route::put('/admin/ajuste_sistema',[AjusteSistemaController::class, 'store'])->name('admin.ajuste_sistema.store')->middleware('auth');

//Rutas para carreras
Route::get('/admin/carreras',[CarreraController::class, 'index'])->name('admin.carreras.index')->middleware('auth');
Route::post('/admin/carreras',[CarreraController::class, 'store'])->name('admin.carreras.store')->middleware('auth');

//rutas para generaciones
Route::get('/admin/generaciones',[GeneracionController::class, 'index'])->name('admin.generaciones.index')->middleware('auth');
Route::get('/admin/generaciones/create',[GeneracionController::class, 'create'])->name('admin.generaciones.create')->middleware('auth');
Route::post('/admin/generacion',[GeneracionController::class, 'store'])->name('admin.generaciones.store')->middleware('auth');
Route::get('/admin/generaciones/edit/{id}',[GeneracionController::class, 'edit'])->name('admin.generaciones.edit')->middleware('auth');
Route::put('/admin/generaciones/edit/{id}',[GeneracionController::class, 'update'])->name('admin.generaciones.update')->middleware('auth');


//rutas para ciclos
Route::get('/admin/ciclos',[CicloController::class, 'index'])->name('admin.ciclos.index')->middleware('auth');
Route::get('/admin/ciclos/create',[CicloController::class, 'create'])->name('admin.ciclos.create')->middleware('auth');
Route::post('/admin/ciclos',[CicloController::class, 'store'])->name('admin.ciclos.store')->middleware('auth');
Route::get('/admin/ciclos/edit/{id}',[CicloController::class, 'edit'])->name('admin.ciclos.edit')->middleware('auth');
Route::put('/admin/ciclos/edit/{id}',[CicloController::class, 'update'])->name('admin.ciclos.update')->middleware('auth');
Route::delete('/admin/ciclos/delete/{id}',[CicloController::class, 'destroy'])->name('admin.ciclos.destroy')->middleware('auth');

//Rutas para inscripciones
Route::get('/admin/inscripciones',[InscripcionController::class, 'index'])->name('admin.inscripciones.index')->middleware('auth');
Route::get('/admin/inscripcion',[InscripcionController::class, 'index_inscripcion'])->name('admin.inscripcion.index_inscripcion')->middleware('auth');
Route::get('/inscripciones/buscar', [InscripcionController::class, 'buscar'])
     ->name('admin.inscripciones.buscar');
Route::get('/admin/inscripcion/create/',[InscripcionController::class, 'create'])->name('admin.inscripcion.nuevo_ingreso')->middleware('auth');
Route::post('/admin/inscripciones',[InscripcionController::class, 'store'])->name('admin.inscripciones.store')->middleware('auth');
Route::get('/admin/inscripciones/obtener_ciclos/{carrera_id}',[InscripcionController::class, 'getCiclosDisponibles'])->name('admin.inscripciones.obtener_ciclos')->middleware('auth');
Route::get('/admin/inscripciones/create/{alumno}',[InscripcionController::class, 'create_reinscripcion'])->name('admin.inscripciones.create_reinscripcion')->middleware('auth');
Route::post('/admin/inscripciones/create/',[InscripcionController::class, 'store_reinscripcion'])->name('admin.inscripciones.store_reinscripcion')->middleware('auth');
Route::get('/admin/inscripciones/edit/{id}',[InscripcionController::class, 'edit'])->name('admin.inscripciones.edit')->middleware('auth');
Route::put('/admin/inscripciones/edit/{id}',[InscripcionController::class, 'update'])->name('admin.inscripciones.update')->middleware('auth');

require __DIR__.'/auth.php';
