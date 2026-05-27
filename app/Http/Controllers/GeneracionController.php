<?php

namespace App\Http\Controllers;

use App\Models\AjusteSistema;
use App\Models\Carrera;
use App\Models\Generacion;
use Illuminate\Http\Request;

class GeneracionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $ajuste = AjusteSistema::first();
        $generaciones = Generacion::all();
        return view('admin.generaciones.index', compact('generaciones','ajuste'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $carreras = Carrera::all();
        return view('admin.generaciones.create',compact('carreras'));

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required|string|max:255',
            'carrera_id' => 'required|exists:carreras,id',//verifiamos que el id de la carrera exista en la tabla carreras
            
        ]);

        $generacion = new Generacion();
        $generacion->nombre = $request->nombre;
        $generacion->carrera_id = $request->carrera_id;
        $generacion->save();
        return redirect()->route('admin.generaciones.index')->with('mensaje', 'Generacion creada exitosamente.')->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Generacion $generacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Generacion $generacion,$id)
    {
        //
        $carreras = Carrera::all();
        $generacion = Generacion::findOrFail($id);
        return view('admin.generaciones.edit', compact('generacion', 'carreras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Generacion $generacion,$id)
    {
        $generacion = Generacion::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:255|'
         ]);

        $generacion->nombre = $request->nombre;
        $generacion->save();
        return redirect()->route('admin.generaciones.index')->with('mensaje', 'Generacion actualizada exitosamente.')->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Generacion $generacion)
    {
        //
    }
}
