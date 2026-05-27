<?php

namespace App\Http\Controllers;

use App\Models\AjusteSistema;
use Illuminate\Http\Request;

class AjusteSistemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $ajuste = AjusteSistema::first();

        return view('admin.ajuste.index', compact('ajuste'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
       // return $request->all();
       // Validar los datos
       $request->validate([
        'nombre' => 'required|string|max:255',
        'correo' => 'required|email|max:255',
        'telefono' => 'required|string|max:20',
        'direccion' => 'required|string|max:255',
        'logotipo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
     //si existe ya informacion de ajuste del sistema, actualizarla, sino crear una nueva
     $ajuste = AjusteSistema::first();
     if ($ajuste) {
        $ajuste->update([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);
       
        // Si se subió un logo, guardarlo
        if ($request->hasFile('logotipo')) {
            $logoPath = $request->file('logotipo')->store('logos', 'public');
            //Eliminar el logo anterior si existe
            if ($ajuste->logotipo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($ajuste->logotipo);
            }
            $ajuste->update(['logotipo' => $logoPath]);
        }
         $ajuste->save();
       // return dd($request->file('logotipo'));
        // Redirigir con mensaje de éxito
        return redirect()->route('admin.ajuste_sistema')->with('mensaje', 'Ajuste del sistema actualizado correctamente.')->with('icono', 'success');

     } else {
        $ajuste = AjusteSistema::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]); 
       
        // Si se subió un logo, guardarlo
        if ($request->hasFile('logotipo')) {
            $logoPath = $request->file('logotipo')->store('logos', 'public');
            $ajuste->update(['logotipo' => $logoPath]); 
        }  
         $ajuste->save(); 
        // Redirigir con mensaje de éxito
        return redirect()->route('admin.ajuste_sistema')->with('mensaje', 'Ajuste del sistema actualizado correctamente.')->with('icono', 'success');
     }
    
    }

    /**
     * Display the specified resource.
     */
    public function show(AjusteSistema $ajusteSistema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AjusteSistema $ajusteSistema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AjusteSistema $ajusteSistema)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AjusteSistema $ajusteSistema)
    {
        //
    }
}
