@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Catalogo de carreras</h5>
            <p class="card-text">Aquí puedes gestionar las carreras academicas.</p>


        </div>
    </div>
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Catalogo de Carreras</h1>

        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Carreras</h5>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="tabla-carreras" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carreras as $carrera)
                                        <tr>
                                            <td>{{ $carrera->id }}</td>
                                            <td>{{ $carrera->nombre }}</td>
                                            <td>
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
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tabla-carreras').DataTable({
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
