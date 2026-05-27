@extends('layouts.admin')

@section('content')
    <div class="card">

    </div>
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Seccion Inscripciones</h1>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Inscibir nuevos alumnos</h5>
                        <div class="d-flex justify-content-end"><a href="{{ route('admin.inscripcion.nuevo_ingreso') }}"
                                class="btn btn-primary"><i class="align-middle" data-feather="plus" aria-hidden="true"></i> Agregar a nuevo
                                alumno</a></div>
                    </div>
                    <div class="card-body">

                        <table class="table table-striped table-hover"id="tabla-alumnos">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre </th>
                                    <td>Carrera</td>
                                    <td>Acciones</td>
                                    {{-- <th>Numero ciclo</th>
                                    <th>Generacion y carrera</th>
                                    <th>Acciones</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alumnos as $alumno)
                                    <tr class="{{ (int)$alumno->carrera_id === 1 ? 'table-success' : 'table-warning' }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $alumno->nombre }} {{ $alumno->ap_paterno }} {{ $alumno->ap_materno }}</td>
                                        <td>
                                            {{ optional($alumno->carrera)->nombre }}
                                        </td>
                                       
                                        <td>
                                            {{-- <a href="" class="btn btn-danger">Ver datos</a> --}}
                                            <a href="#" class="btn btn-info" ><i class="align-middle" data-feather="printer"></i> Constancia de reinscripcion</a>
                                            <a href="{{ route('admin.inscripciones.edit', $alumno->id) }}" class="btn btn-success">Actualizar datos</a>
                                        </td>
                                        {{-- <td>{{ $ciclo->ciclo_numero }}</td>
                                        <td>
                                            {{ optional($ciclo->generacion)->nombre }} -
                                            {{ $ciclo->generacion->carrera->nombre }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.ciclos.edit', $ciclo->id) }}"
                                                class="btn btn-primary btn-sm">Editar</a>
                                            <!-- Aquí puedes agregar botones para editar o eliminar -->
                                            <form id="miFormulario{{ $ciclo->id }}"
                                                action="{{ route('admin.ciclos.destroy', $ciclo->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="preguntar(event,{{ $ciclo->id }})">Eliminar</button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function preguntar(event, id) {
                event.preventDefault();

                Swal.fire({
                    title: '¿Desea eliminar este registro?',
                    text: 'Recuerda que al eliminar un ciclo, se eliminaran todos los registros relacionados a este ciclo.',
                    icon: 'question',
                    showDenyButton: true,
                    confirmButtonText: 'Eliminar',
                    confirmButtonColor: '#a5161d',
                    denyButtonColor: '#270a0a',
                    denyButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // JavaScript puro para enviar el formulario
                        document.getElementById('miFormulario' + id).submit();
                    }
                });
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#tabla-alumnos').DataTable({
                    responsive: true,
                    autoWidth: false,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
                    }
                });
            });
        </script>
    @endpush
@endsection
