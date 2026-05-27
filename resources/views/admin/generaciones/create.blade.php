@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Crear nueva generacion</h5>
            <p class="card-text">Aquí puedes crear las generaciones.</p>


        </div>
    </div>
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Crear Nueva Generacion</h1>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Generaciones</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.generaciones.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                                id="nombre" name="nombre" value="{{ old('nombre') }}"
                                                placeholder="Ej. Generacion 2023-1">
                                            @error('nombre')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="carrera_id" class="form-label">Licenciatura </label>
                                            <select class="form-control @error('carrera_id') is-invalid @enderror"
                                                id="carrera_id" name="carrera_id">
                                                <option value="">Seleccionar Licenciatura</option>
                                                @foreach ($carreras as $carrera)
                                                    <option value="{{ $carrera->id }}"
                                                        {{ old('carrera_id') == $carrera->id ? 'selected' : '' }}>
                                                        {{ $carrera->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('carrera_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                    </div>

                                </div>

                            </div>

                            <hr>
                            <div class="text-end">
                                <a href="{{ route('admin.generaciones.index') }}" class="btn btn-secondary">Salir</a>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
