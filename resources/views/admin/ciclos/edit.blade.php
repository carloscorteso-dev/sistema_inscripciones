@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Eidtar el ciclo : {{ $ciclo->ciclo_letra }}</h5>
            <p class="card-text">Aquí puedes crear los ciclos academicos.</p>


        </div>
    </div>
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Editar Ciclo</h1>

        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ciclos</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.ciclos.update', $ciclo->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="ciclo_letra" class="form-label">Ciclo nombre</label>
                                            <input type="text" class="form-control @error('ciclo_letra') is-invalid @enderror"
                                                id="ciclo_letra" name="ciclo_letra" value="{{ old('ciclo_letra',$ciclo->ciclo_letra) }}"
                                                placeholder="Ej. PRIMERO , SEGURNDO , TERCERO ...">
                                            @error('ciclo_letra')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                    </div>

                                </div>

                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="ciclo_numero" class="form-label">Ciclo numerico</label>
                                            <input type="number" class="form-control @error('ciclo_numero') is-invalid @enderror" min="1" max="12"
                                                id="ciclo_numero" name="ciclo_numero" value="{{ old('ciclo_numero',$ciclo->ciclo_numero) }}"
                                                placeholder="Ej. 1, 2, 3 ...">
                                            @error('ciclo_numero')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                    </div>

                                </div>
                                 <div class="col-md-6">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="carrera_id" class="form-label">Generacion y carrera asociada </label>
                                                <p>{{ $ciclo->generacion->nombre }} - {{ $ciclo->generacion->carrera->nombre }}</p>
                                           
                                        </div>


                                    </div>

                                </div>

                                

                            </div>

                            <hr>
                            <div class="text-end">
                                <a href="{{ route('admin.ciclos.index') }}" class="btn btn-secondary">Salir</a>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
