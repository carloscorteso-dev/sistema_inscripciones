@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Catalogo de Generaciones</h5>
            <p class="card-text">Aquí puedes gestionar las generaciones.</p>


        </div>
    </div>
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Catalogo de Generaciones</h1>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Generaciones</h5>
                        <div class="d-flex justify-content-end"><a href="{{ route('admin.generaciones.create') }}"
                                class="btn btn-primary btn-sm"><i class="bi bi-plus" aria-hidden="true"></i> Agregar
                                Generación</a></div>

                    </div>
                    <div class="card-body">

                        <table id="tabla-generaciones" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre de la generacion </th>
                                    <th>Carrera</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($generaciones as $generacion)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $generacion->nombre }}</td>
                                        <td>{{ $generacion->carrera->nombre }}</td>
                                        <td>
                                            <a href="{{ route('admin.generaciones.edit',$generacion->id) }}" class="btn btn-warning btn-sm"><i></i>Actualizar</a>
                                            <!-- Aquí puedes agregar botones para editar o eliminar -->
                                            <form action="#" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    disabled>Eliminar</button>
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
            $(document).ready(function() {
                $('#tabla-generaciones').DataTable({
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
