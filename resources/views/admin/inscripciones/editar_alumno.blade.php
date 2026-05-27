@extends('layouts.admin')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="formAlumno" enctype="multipart/form-data">
        @csrf

        <div class="container-fluid p-0">
            {{-- <h1 class="h3 mb-3">Configuración del Sistema</h1> --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Datos del Alumno</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="mb-3 col-md-7">
                                            <label for="carrera" class="form-label">Nombre de la carrera</label>
                                            <input type="text"
                                                class="form-control @error('carrera') is-invalid @enderror" id="carrera"
                                                name="carrera" value="{{ old('carrera', $alumno->carrera->nombre) }}"
                                                placeholder="EJ: Ingeniería en Software" readonly>
                                            @error('carrera')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-2">
                                            <label for="folio_alumno" class="form-label">Folio alumno</label>
                                            <input type="text"
                                                class="form-control @error('folio_alumno', $alumno->folio_alumno) is-invalid @enderror"
                                                id="folio_alumno" name="folio_alumno"
                                                value="{{ old('folio_alumno', $alumno->folio_alumno) }}"
                                                placeholder="EJ AES20240001">
                                            @error('folio_alumno')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label for="curp" class="form-label">CURP</label>
                                            <input type="text" class="form-control @error('curp') is-invalid @enderror"
                                                id="curp" name="curp" value="{{ old('curp', $alumno->curp) }}">
                                            @error('curp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="mb-3 col-md-3">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                                id="nombre" name="nombre" value="{{ old('nombre', $alumno->nombre) }}">
                                            @error('nombre')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="ap_paterno" class="form-label">Apellido paterno</label>
                                            <input type="text"
                                                class="form-control @error('ap_paterno') is-invalid @enderror"
                                                id="ap_paterno" name="ap_paterno"
                                                value="{{ old('ap_paterno', $alumno->ap_paterno) }}">
                                            @error('ap_paterno')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="ap_materno" class="form-label">Apellido materno</label>
                                            <input type="text"
                                                class="form-control @error('ap_materno') is-invalid @enderror"
                                                id="ap_materno" name="ap_materno"
                                                value="{{ old('ap_materno', $alumno->ap_materno) }}">
                                            @error('ap_materno')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label for="calle" class="form-label">Calle</label>
                                            <input type="text" class="form-control @error('calle') is-invalid @enderror"
                                                id="calle" name="calle" value="{{ old('calle', $alumno->calle) }}">
                                            @error('calle')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="mb-3 col-md-1">
                                            <label for="codigo_postal" class="form-label">CP</label>
                                            <input type="text"
                                                class="form-control @error('codigo_postal') is-invalid @enderror"
                                                id="codigo_postal" name="codigo_postal"
                                                value="{{ old('codigo_postal', $alumno->codigo_postal) }}">
                                            @error('codigo_postal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-2">
                                            <label for="numero" class="form-label">No casa</label>
                                            <input type="text" class="form-control @error('numero') is-invalid @enderror"
                                                id="numero" name="numero" value="{{ old('numero', $alumno->numero) }}">
                                            @error('numero')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="colonia" class="form-label">Colonia</label>
                                            <input type="text"
                                                class="form-control @error('colonia') is-invalid @enderror" id="colonia"
                                                name="colonia" value="{{ old('colonia', $alumno->colonia) }}">
                                            @error('colonia')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-2">
                                            <label for="municipio" class="form-label">Municipio</label>
                                            <input type="text"
                                                class="form-control @error('municipio') is-invalid @enderror"
                                                id="municipio" name="municipio"
                                                value="{{ old('municipio', $alumno->municipio) }}">
                                            @error('municipio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-2">
                                            <label for="entidad_federativa" class="form-label">Entidad federativa</label>
                                            <input type="text"
                                                class="form-control @error('entidad_federativa') is-invalid @enderror"
                                                id="entidad_federativa" name="entidad_federativa"
                                                value="{{ old('entidad_federativa', $alumno->entidad_federativa) }}">
                                            @error('entidad_federativa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-2">
                                            <label for="celular" class="form-label">Telefono</label>
                                            <input type="text"
                                                class="form-control @error('celular') is-invalid @enderror"
                                                id="celular" name="celular"
                                                value="{{ old('celular', $alumno->celular) }}">
                                            @error('celular')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="mb-3 col-md-3">
                                            <label for="correo_electronico" class="form-label">Correo Electronico</label>
                                            <input type="text"
                                                class="form-control @error('correo_electronico') is-invalid @enderror"
                                                id="correo_electronico" name="correo_electronico"
                                                value="{{ old('correo_electronico', $alumno->correo_electronico) }}">
                                            @error('correo_electronico')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 border-start">
                                    <div class="text-center">

                                        <div class="mb-3">
                                            <label for="logotipo" class="form-label">Selecciona Fografia</label>
                                            <img src="{{ asset('storage/' . $alumno->foto) }}" alt=""
                                                max-width="80%" class="img-fluid mb-2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Datos del Tutor</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label for="nombre_contacto" class="form-label">Nombrel contacto de emergencia</label>
                                    <input class="form-control" type="text" name="nombre_contacto"
                                        value="{{ old('nombre_contacto', $alumno->nombre_contacto) }}">
                                    @error('nombre_contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-2">
                                    <label for="parentesco_contacto" class="form-label">Parentesco</label>
                                    <input type="text"
                                        class="form-control @error('parentesco_contacto') is-invalid @enderror"
                                        id="parentesco_contacto" name="parentesco_contacto"
                                        value="{{ old('parentesco_contacto', $alumno->parentesco_contacto) }}"
                                        placeholder="EJ Padre, Madre, Tío, etc.">
                                    @error('parentesco_contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="calle_contacto" class="form-label">Calle</label>
                                    <input type="text"
                                        class="form-control @error('calle_contacto') is-invalid @enderror"
                                        id="calle_contacto" name="calle_contacto"
                                        value="{{ old('calle_contacto', $alumno->calle_contacto) }}"
                                        placeholder="EJ Principal.">
                                    @error('calle_contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-1">
                                    <label for="numero_contacto" class="form-label">No</label>
                                    <input type="text"
                                        class="form-control @error('numero_contacto') is-invalid @enderror"
                                        id="numero_contacto" name="numero_contacto"
                                        value="{{ old('numero_contacto', $alumno->numero_contacto) }}"
                                        placeholder="EJ 123.">
                                    @error('numero_contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="colonia_contacto" class="form-label">Colonia contacto</label>
                                    <input type="text"
                                        class="form-control @error('colonia_contacto') is-invalid @enderror"
                                        id="colonia_contacto" name="colonia_contacto"
                                        value="{{ old('colonia_contacto', $alumno->colonia_contacto) }}"
                                        placeholder="EJ Vicente guerrero.">
                                    @error('colonia_contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label for="municipio_contacto" class="form-label">Municipio</label>
                                    <input type="text"
                                        class="form-control @error('municipio_contacto') is-invalid @enderror"
                                        id="municipio_contacto" name="municipio_contacto"
                                        value="{{ old('municipio_contacto', $alumno->municipio_contacto) }}"
                                        placeholder="EJ 123.">
                                    @error('municipio_contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="entidad_federativa_contacto" class="form-label">Estado</label>
                                    <input type="text"
                                        class="form-control @error('entidad_federativa_contacto') is-invalid @enderror"
                                        id="entidad_federativa_contacto" name="entidad_federativa_contacto"
                                        value="{{ old('entidad_federativa_contacto', $alumno->entidad_federativa_contacto) }}"
                                        placeholder="EJ Baja California.">
                                    @error('entidad_federativa_contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="mb-3 col-md-1">
                                    <label for="codigo_postal_contacto" class="form-label">CP</label>
                                    <input type="text"
                                        class="form-control @error('codigo_postal_contacto') is-invalid @enderror"
                                        id="codigo_postal_contacto" name="codigo_postal_contacto"
                                        value="{{ old('codigo_postal_contacto', $alumno->codigo_postal_contacto) }}"
                                        placeholder="EJ 22920.">
                                    @error('codigo_postal_contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-2">
                                    <label for="celular_contacto" class="form-label">Telefono </label>
                                    <input type="text"
                                        class="form-control @error('celular_contacto') is-invalid @enderror"
                                        id="celular_contacto" name="celular_contacto"
                                        value="{{ old('celular_contacto', $alumno->celular_contacto) }}"
                                        placeholder="EJ 5512345678.">
                                    @error('celular_contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="correo_electronico_contacto" class="form-label">Correo Electronico
                                    </label>
                                    <input type="text"
                                        class="form-control @error('correo_electronico_contacto') is-invalid @enderror"
                                        id="correo_electronico_contacto" name="correo_electronico_contacto"
                                        value="{{ old('correo_electronico_contacto', $alumno->correo_electronico_contacto) }}"
                                        placeholder="EJ ejemplo@dominio.com.">
                                    @error('correo_electronico_contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <div class="text-end">
                                <a href="javascript:history.go({{ $errors->any() ? -1 : -1 }})"
                                    class="btn btn-secondary">Salir</a>
                                <button type="submit" class="btn btn-danger">Actulizar datos del alumno</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const formulario = document.getElementById('formAlumno');

                formulario.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const formData = new FormData(formulario);

                    try {
                        const response = await fetch(
                            '{{ route('admin.inscripciones.update', $alumno->id) }}', {
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },

                                body: formData
                            });

                        const data = await response.json();
                        if (data.success) {
                            Swal.fire({
                                position: "top-end",
                                icon: data.icono,
                                title: data.message,
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
                    } catch (error) {
                        console.error(error);
                    }
                })
            });
        </script>
    @endpush
@endsection
