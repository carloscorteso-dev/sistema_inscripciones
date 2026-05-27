@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Catalogo de carreras</h5>
            <p class="card-text">Aquí puedes gestionar los ciclos academicos.</p>


        </div>
    </div>
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Catalogo de Ciclos para la carreras de Medicina y Acuacultura</h1>

        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ciclos</h5>
                        <div class="d-flex justify-content-end"><a href="{{ route('admin.ciclos.create') }}"
                                class="btn btn-primary btn-sm"><i class="bi bi-plus" aria-hidden="true"></i> Crear nuevo
                                ciclo</a></div>
                    </div>
                    <div class="card-body">

                        <table class="table table-striped"id="tabla-ciclos">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del ciclo </th>
                                    <th>Numero ciclo</th>
                                    <th>Generacion y carrera</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ciclos as $ciclo)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ciclo->ciclo_letra }}</td>
                                        <td>{{ $ciclo->ciclo_numero }}</td>
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
                                        </td>
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
                $('#tabla-ciclos').DataTable({
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
