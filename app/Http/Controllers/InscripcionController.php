<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Ciclo;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $alumnos = Alumno::with('carrera', 'inscripciones.ciclo')
            ->whereHas('inscripciones', function ($q) {
                $q->where('estatus', '!=', 'INSCRITO');
            })
            ->join('inscripcions', 'alumnos.id', '=', 'inscripcions.alumno_id')
            ->orderBy('inscripcions.folio_comprobante', 'DESC')
            ->select('alumnos.*')
            ->get();
        //return $alumnos;
        return view('admin.inscripciones.index', compact('alumnos'));
    }

    public function index_inscripcion(Request $request)
    {
        $alumnos = Alumno::with('carrera', 'inscripciones')
            ->whereHas('inscripciones', function ($q) {
                $q->where('estatus', 'INSCRITO');
            })
            ->get();
        //return $alumnos;

        $totalInscripciones = $alumnos->pluck('inscripciones')->collapse()->count();
        return view('admin.inscripciones.index_inscripcion', compact('alumnos', 'totalInscripciones'));
    }

    public function buscar(Request $request)
    {
        $query = $request->get('q');

        $alumnos = Alumno::with('carrera', 'inscripciones') // 👈 trae la carrera y las inscripciones en la misma consulta

            //no fitrar los alumnos que en su estatus por defecto tengan inscrito  pero si filtrar los alumnos que tengan una inscripcion con estatus diferente a inscrito o reinscrito
            ->whereDoesntHave('inscripciones', function ($q) {
                $q->where(function ($sub) {
                    $sub->where('estatus', '=', 'INSCRITO');
                });
            })
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('nombre', 'like', "%$query%")
                        ->orWhere('ap_paterno', 'like', "%$query%")
                        ->orWhere('ap_materno', 'like', "%$query%")
                        ->orWhere('folio_alumno', 'like', "%$query%")
                        ->orWhere('curp', 'like', "%$query%");
                });
            })
            ->limit(10)
            ->get();

        return response()->json([
            'results' => $alumnos->map(function ($a) {
                // 1. Aquí sí podemos declarar variables limpiamente antes de retornar el array
                $estatusAlumno = $a->inscripciones->isNotEmpty() ? 'REINSCRITO' : 'REGULAR';

                return [
                    'id' => $a->id,
                    'text' => "{$a->folio_alumno} - {$a->nombre} {$a->ap_paterno} {$a->ap_materno}",
                    // 2. Mapeamos los datos manuales dentro de 'data' para asegurarnos de que 'estatus' viaje adentro
                    'data' => [
                        'id' => $a->id,
                        'nombre' => $a->nombre,
                        'ap_paterno' => $a->ap_paterno,
                        'ap_materno' => $a->ap_materno,
                        'folio_alumno' => $a->folio_alumno,
                        'curp' => $a->curp,
                        'foto' => $a->foto,
                        'carrera_id' => $a->carrera_id,
                        'carrera' => $a->carrera, // Enviamos la relación de la carrera
                        'estatus' => $estatusAlumno, // 👈 Así JS lo lee directo desde 'a.estatus'
                    ],
                ];
            }),
        ]);
    }

    public function getCiclosDisponibles($carreraID)
    {
        //traer ciclos diferente de PRIMERO y ademas asociar a la carrera del alumno para mostrar solo los ciclos disponibles para esa carrera
        $carreraID = (int) $carreraID; // Aseguramos que sea un entero
        $ciclos = Ciclo::where('ciclo_letra', '!=', 'PRIMERO')
            ->whereHas('generacion.carrera', function ($q) use ($carreraID) {
                $q->where('id', $carreraID);
            })
            //->orderBy('ciclo_letra', 'desc')
            ->orderByRaw("FIELD(ciclo_letra, 'PRIMERO', 'SEGUNDO', 'TERCERO', 'CUARTO', 'QUINTO', 'SEXTO','SEPTIMO','OCTAVO','NOVENO','DECIMO') ASC")
            ->get();
        //$ciclos = Ciclo::where('ciclo_letra', '!=', 'PRIMERO')->get();
        // return $ciclos;
        return response()->json($ciclos);
    }

    //Metodo para realizar reinscripcion
    public function store_reinscripcion(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'ciclo_id' => 'required|exists:ciclos,id',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $alumno = Alumno::findOrFail($request->input('alumno_id'));
                $carreraID = $alumno->carrera_id;
                //$carreraID = $request->carrera_id;

                //obtenr ultimo folio de inscripcion con formato que inicia en 00001
                // 2. OBTENER ÚLTIMO FOLIO (Controlando si es el primero del sistema)
                //$ultimoFolio = Inscripcion::max('folio_comprobante');
                $ultimoFolio = Inscripcion::whereHas('alumno', function ($q) use ($alumno) {
                    $q->where('carrera_id', $alumno->carrera_id);
                })
                    ->lockForUpdate()
                    ->max('folio_comprobante');

                if ((int) $carreraID === 1 || (int) $carreraID === 2) {
                    if (!$ultimoFolio) {
                        $nuevoFolio = '00001';
                    } else {
                        // Si ya existen, convertimos a entero, sumamos 1 y rellenamos con ceros
                        $numeroSiguiente = (int) $ultimoFolio + 1;
                        $nuevoFolio = str_pad($numeroSiguiente, 5, '0', STR_PAD_LEFT);
                    }

                    Inscripcion::create([
                        'alumno_id' => $alumno->id,
                        'ciclo_id' => $request->input('ciclo_id'),
                        'folio_comprobante' => $nuevoFolio,
                        'estatus' => 'REINSCRITO',
                    ]);
                }
            });
            return redirect()->back()->with('mensaje', 'Alumno reinscrito exitosamente.')->with('icono', 'success');
        } catch (\Exception $th) {
            dd($th);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //ontener carreras  donde la generacion sea igual a 2026-2
        $carreras = Carrera::whereHas('generaciones', function ($q) {
            $q->where('nombre', 'GENERACION 2026-2');
        })
            ->with([
                'generaciones' => function ($query) {
                    //tremos solo los datos de la generacion 2026-2
                    $query->where('nombre', 'GENERACION 2026-2');

                    $query->with('ciclos'); //tremos los ciclos de la generacion 2026-2
                },
            ])
            ->get();

        //return $carreras;

        return view('admin.inscripciones.nuevo_ingreso', compact('carreras'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'carrera' => 'required',
            'folio_alumno' => 'required|unique:alumnos,folio_alumno',
            'curp' => 'required|unique:alumnos,curp',
            'nombre' => 'required',
            'ap_paterno' => 'required',
            'ap_materno' => 'required',
            'calle' => 'required',
            'codigo_postal' => 'required',
            'numero' => 'required',
            'colonia' => 'required|string',
            'municipio' => 'required|string',
            'entidad_federativa' => 'required|string',
            'celular' => 'required',
            'correo_electronico' => 'required|email',
            'nombre_contacto' => 'required|string',
            'parentesco_contacto' => 'required|string',
            'calle_contacto' => 'required|string',
            'numero_contacto' => 'required',
            'colonia_contacto' => 'required|string',
            'municipio_contacto' => 'required|string',
            'entidad_federativa_contacto' => 'required|string',
            'codigo_postal_contacto' => 'required',
            'celular_contacto' => 'required|digits:10',
            'correo_electronico_contacto' => 'required|email',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $valores = explode('-', $request->input('carrera'));

        $carreraID = $valores[0];
        //$generacionID = $valores[1];
        $cicloID = $valores[2];

        try {
            //code...
            DB::transaction(function () use ($request, $carreraID, $cicloID) {
                $alumno = Alumno::create([
                    'carrera_id' => $carreraID,
                    'folio_alumno' => $request->input('folio_alumno'),
                    'curp' => $request->input('curp'),
                    'nombre' => $request->input('nombre'),
                    'ap_paterno' => $request->input('ap_paterno'),
                    'ap_materno' => $request->input('ap_materno'),
                    'calle' => $request->input('calle'),
                    'codigo_postal' => $request->input('codigo_postal'),
                    'numero' => $request->input('numero'),
                    'colonia' => $request->input('colonia'),
                    'municipio' => $request->input('municipio'),
                    'entidad_federativa' => $request->input('entidad_federativa'),
                    'celular' => $request->input('celular'),
                    'correo_electronico' => $request->input('correo_electronico'),
                    'nombre_contacto' => $request->input('nombre_contacto'),
                    'parentesco_contacto' => $request->input('parentesco_contacto'),
                    'calle_contacto' => $request->input('calle_contacto'),
                    'numero_contacto' => $request->input('numero_contacto'),
                    'colonia_contacto' => $request->input('colonia_contacto'),
                    'municipio_contacto' => $request->input('municipio_contacto'),
                    'entidad_federativa_contacto' => $request->input('entidad_federativa_contacto'),
                    'codigo_postal_contacto' => $request->input('codigo_postal_contacto'),
                    'celular_contacto' => $request->input('celular_contacto'),
                    'correo_electronico_contacto' => $request->input('correo_electronico_contacto'),
                ]);

                //obtenr ultimo folio de inscripcion con formato que inicia en 00001
                // 2. OBTENER ÚLTIMO FOLIO (Controlando si es el primero del sistema) ademas de controlar el folio por carrera
                $ultimoFolio = Inscripcion::whereHas('alumno', function ($q) use ($carreraID) {
                    $q->where('carrera_id', $carreraID);
                })
                    ->lockForUpdate()
                    ->max('folio_comprobante');

                //generar folio con respecto a la carrera si es medicina inicia en 00001 y si es ingenieria en pesca Inicia en 00001 y asi sucesivamente para cada carrera
                //se sabe que medicina el id es igual a 1 , y la carrera de ingenieria en pesca es igual a 2
                if ((int) $carreraID === 1 || (int) $carreraID === 2) {
                    if (!$ultimoFolio) {
                        // Si la tabla está vacía, el primer folio será "00001"
                        $nuevoFolio = '00001';
                    } else {
                        // Si ya existen, convertimos a entero, sumamos 1 y rellenamos con ceros
                        $numeroSiguiente = (int) $ultimoFolio + 1;
                        $nuevoFolio = str_pad($numeroSiguiente, 5, '0', STR_PAD_LEFT);
                    }
                    $inscripcion = Inscripcion::create([
                        'alumno_id' => $alumno->id,
                        'ciclo_id' => $cicloID,
                        'folio_comprobante' => $nuevoFolio,
                        'estatus' => 'INSCRITO',
                    ]);
                }
            });

            return redirect()->route('admin.inscripcion.nuevo_ingreso')->with('mensaje', 'Alumno inscrito exitosamente.')->with('icono', 'success');
        } catch (\Exception $th) {
            //throw $th;
            dd($th);
        }
        //echo "carreraID: $carreraID, generacionID: $generacionID, cicloID: $cicloID";
    }

    public function create_reinscripcion(Request $request, Alumno $alumno) {}

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inscripcion $inscripcion, $id)
    {
        //editar datos del alumno para reinscripcion
        $alumno = Alumno::findOrFail($id);
        //return $alumno;
        return view('admin.inscripciones.editar_alumno', compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inscripcion $inscripcion, $id)
    {
        $alumno = Alumno::findOrFail($id);
        //Actualizar datos del alumno
        $request->validate([
            //'carrera' => 'required',
            'folio_alumno' => 'required|unique:alumnos,folio_alumno,' . $alumno->id,
            'curp' => 'required|unique:alumnos,curp,' . $alumno->id,
            'nombre' => 'required',
            'ap_paterno' => 'required',
            'ap_materno' => 'required',
            'calle' => 'required',
            'codigo_postal' => 'required',
            'numero' => 'required',
            'colonia' => 'required|string',
            'municipio' => 'required|string',
            'entidad_federativa' => 'required|string',
            'celular' => 'required',
            'correo_electronico' => 'required|email',
            'nombre_contacto' => 'required|string',
            'parentesco_contacto' => 'required|string',
            'calle_contacto' => 'required|string',
            'numero_contacto' => 'required',
            'colonia_contacto' => 'required|string',
            'municipio_contacto' => 'required|string',
            'entidad_federativa_contacto' => 'required|string',
            'codigo_postal_contacto' => 'required',
            'celular_contacto' => 'required|digits:10',
            // 'correo_electronico_contacto' => 'required|email',
        ]);
        $alumno->folio_alumno = $request->input('folio_alumno');
        $alumno->curp = $request->input('curp');
        $alumno->nombre = $request->input('nombre');
        $alumno->ap_paterno = $request->input('ap_paterno');
        $alumno->ap_materno = $request->input('ap_materno');
        $alumno->calle = $request->input('calle');
        $alumno->codigo_postal = $request->input('codigo_postal');
        $alumno->numero = $request->input('numero');
        $alumno->colonia = $request->input('colonia');
        $alumno->municipio = $request->input('municipio');
        $alumno->entidad_federativa = $request->input('entidad_federativa');
        $alumno->celular = $request->input('celular');
        $alumno->correo_electronico = $request->input('correo_electronico');
        $alumno->nombre_contacto = $request->input('nombre_contacto');
        $alumno->parentesco_contacto = $request->input('parentesco_contacto');
        $alumno->calle_contacto = $request->input('calle_contacto');
        $alumno->numero_contacto = $request->input('numero_contacto');
        $alumno->colonia_contacto = $request->input('colonia_contacto');
        $alumno->municipio_contacto = $request->input('municipio_contacto');
        $alumno->entidad_federativa_contacto = $request->input('entidad_federativa_contacto');
        $alumno->codigo_postal_contacto = $request->input('codigo_postal_contacto');
        $alumno->celular_contacto = $request->input('celular_contacto');
        $alumno->correo_electronico_contacto = $request->input('correo_electronico_contacto');

        $alumno->save();

        //solo actualizar los datos del alumno
        // return redirect()->back()->with('mensaje', 'Alumno actualizado exitosamente.')->with('icono', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Alumno actualizado exitosamente.',
            'icono' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inscripcion $inscripcion)
    {
        //
    }
}
