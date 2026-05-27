@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Crear nueva carrera</h5>
            <p class="card-text">Aquí puedes gestionar las carreras academicas.</p>


        </div>
    </div>
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Crear Nueva Carrera</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Carreras</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.carreras.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                                id="nombre" name="nombre"
                                                value="{{ old('nombre') }}"
                                                placeholder="Ej. Lic. en Informatica">
                                            @error('nombre')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                      
                                    </div>

                                </div>

                            </div>

                            <hr>
                            <div class="text-end">
                                <a href="{{ route('admin.carreras.index') }}" class="btn btn-secondary">Salir</a>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
