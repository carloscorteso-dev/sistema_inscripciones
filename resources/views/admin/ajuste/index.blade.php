@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ajuste del Sistema</h5>
            <p class="card-text">Aquí puedes configurar los ajustes generales del sistema, como el nombre, logotipo, correo,
                teléfono y dirección.</p>


        </div>
    </div>
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Configuración del Sistema</h1>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Información General</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.ajuste_sistema.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="nombre" class="form-label">Nombre de la
                                                Institución/Empresa</label>
                                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                                id="nombre" name="nombre"
                                                value="{{ old('nombre', $ajuste->nombre ?? '') }}"
                                                placeholder="Ej. Universidad UBBJ">
                                            @error('nombre')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="correo" class="form-label">Correo Electrónico</label>
                                            <input type="email" class="form-control @error('correo') is-invalid @enderror"
                                                id="correo" name="correo"
                                                value="{{ old('correo', $ajuste->correo ?? '') }}"
                                                placeholder="contacto@ejemplo.com">
                                            @error('correo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="telefono" class="form-label">Teléfono de Contacto</label>
                                            <input type="text"
                                                class="form-control @error('telefono') is-invalid @enderror" id="telefono"
                                                name="telefono" value="{{ old('telefono', $ajuste->telefono ?? '') }}">
                                            @error('telefono')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="direccion" class="form-label">Dirección Física</label>
                                            <input type="text"
                                                class="form-control @error('direccion') is-invalid @enderror" id="direccion"
                                                name="direccion" value="{{ old('direccion', $ajuste->direccion ?? '') }}">
                                            @error('direccion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 border-start">
                                    <div class="text-center">
                                        <label class="form-label d-block">Logotipo Actual</label>
                                        <div class="mb-3">
                                            @if (isset($ajuste->logotipo))
                                                <img src="{{ asset('storage/' . $ajuste->logotipo) }}" alt="Logo"
                                                    class="img-fluid rounded mb-2" style="max-height: 150px;">
                                            @else
                                                <img src="{{ asset('assets/img/photos/no-image.png') }}" alt="Sin logo"
                                                    class="img-fluid rounded mb-2" style="max-height: 150px;">
                                            @endif


                                        </div>
                                        <div class="mb-3">
                                            <label for="logotipo" class="form-label">Cambiar Logotipo</label>
                                            <input type="file" class="form-control" name="logotipo"
                                                onchange="mostrarImagen(event)" accept="image/*">
                                            <small class="text-muted">Formatos recomendados: PNG o JPG</small>
                                            @error('logotipo')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror


                                            <br>
                                            <img id="preview" style="max-width: 300px; margin-top: 10px;">
                                            <script>
                                                const mostrarImagen = e =>
                                                    document.getElementById('preview').src = URL.createObjectURL(e.target.files[0]);
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
