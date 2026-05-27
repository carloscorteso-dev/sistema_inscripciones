<?php

namespace App\Http\Controllers;

use App\Models\AjusteSistema;
use App\Models\Ciclo;
use App\Models\Genaracion;
use App\Models\Generacion;
use Illuminate\Http\Request;

class CicloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $ajuste = AjusteSistema::first();

        $ciclos = Ciclo::with('generacion.carrera')->get();
        return view('admin.ciclos.index', compact('ciclos', 'ajuste'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        //si la generacion ya tiene un ciclo asociado no se muestra en el select
        $ciclos_asociados = Ciclo::pluck('generacion_id')->toArray();

        $gereracion_carreras = Generacion::with('carrera')->whereNotIn('id', $ciclos_asociados)->get();
        // return $gereracion_carrera;
        return view('admin.ciclos.create', compact('gereracion_carreras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'ciclo_letra' => 'required|string|max:255',
            'ciclo_numero' => 'required|integer|min:1|max:12',
            'carrera_id' => 'required|exists:generacions,id',
        ]);

        $ciclo = new Ciclo();
        $ciclo->ciclo_letra = $request->ciclo_letra;
        $ciclo->ciclo_numero = $request->ciclo_numero;
        $ciclo->generacion_id = $request->carrera_id;
        $ciclo->save();

        return redirect()->route('admin.ciclos.index')->with('mensaje', 'Ciclo creado exitosamente.')->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ciclo $ciclo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ciclo $ciclo, $id)
    {
        //

        $ciclo = Ciclo::findOrFail($id);
        return view('admin.ciclos.edit', compact('ciclo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ciclo $ciclo,$id)
    {
        //
        $request->validate([
            'ciclo_letra' => 'required|string|max:255',
            'ciclo_numero' => 'required|integer|min:1|max:12',
        ]);
        $ciclo = Ciclo::findOrFail($id);
        $ciclo->ciclo_letra = $request->ciclo_letra;
        $ciclo->ciclo_numero = $request->ciclo_numero;
        $ciclo->save();
        return redirect()->route('admin.ciclos.index')->with('mensaje', 'Ciclo actualizado exitosamente.')->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ciclo $ciclo, $id)
    {
        //
        //echo "Eliminar ciclo con id: " . $id;
        try {
            $ciclo = Ciclo::findOrFail($id);
            $ciclo->delete();
            return redirect()->route('admin.ciclos.index')->with('mensaje', 'Ciclo eliminado exitosamente.')->with('icono', 'success');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            return redirect()->route('admin.ciclos.index')->with('mensaje', 'Error al eliminar el ciclo.')->with('icono', 'error');
        }
    }
}
