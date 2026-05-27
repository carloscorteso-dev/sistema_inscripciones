@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-8 offset-2">
            <div class="card">
                <div class="card-header" style="background-color: #01581b; ">
                    <h3 style="text-align: center; color:white"> Buscador de Alumnos <i class="align-middle"
                            data-feather="search"></i></h3>
                </div>
                <div class="card-body">

                    {{-- SELECT2 reemplaza tu input+form --}}
                    <label class="form-label"><i class="align-middle"></i>Teclear nombre del alumno</label><br>

                    <select id="buscar-alumno" style="width:100%">
                        <option></option>
                    </select>

                    {{-- Aquí aparecen los datos al seleccionar --}}
                    <div id="datos-alumno" class="d-none mt-4">
                        <hr>
                        <h6 class="text-muted mb-3">Datos del alumno encontrado</h6>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="for-label">Fotografia</label>
                                <div class="border p-2 text-center">
                                    <img src="{{ asset('storage/placeholder.jpg') }}" width="150px" height="150px"
                                        alt="Fotografía del alumno" id="alumno-foto" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        {{-- <input type="text" id="modal-alumno-id" class="form-control"> --}}
                                        <label class="fw-bold">Nombre completo</label>
                                        <p id="alumno-nombre" class="mb-1"></p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-bold">Matrícula / Folio</label>
                                        <p id="alumno-folio" class="mb-1"></p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="fw-bold">Carrera</label>
                                        <p id="alumno-carrera" class="mb-1"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="fw-bold">CURP</label>
                                        <p id="alumno-curp" class="mb-1"></p>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        {{-- Botón para abrir el modal --}}
                                        <button type="button" class="btn btn-primary" id="btn-abrir-modal-reinscripcion"
                                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">Reinscribir al alumno
                                        </button>

                                        {{-- Otros botones de tu vista --}}
                                        <a href="#" class="btn btn-success" onclick="editar_alumno()"><i
                                                class="fas fa-edit"></i> Editar
                                            datos del alumno</a>
                                        <a href="" class="btn btn-danger"><i class="fas fa-edit"></i> Salir</a>


                                        {{-- Estructura del Modal --}}
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- Cambiado <p> por <span> para evitar saltos de línea feos --}}
                                                        <h5 class="modal-title" id="staticBackdropLabel">
                                                            Reinscripción del alumno: <strong><span
                                                                    id="alumno-modal_nombre"></span></strong>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{-- Recuerda agregar la ruta y el método POST cuando vayas a procesar --}}
                                                        <form
                                                            action="{{ route('admin.inscripciones.store_reinscripcion') }}"
                                                            method="POST" id="form-reinscribir">
                                                            @csrf

                                                            {{-- Cuerpo del Modal --}}
                                                            <div class="modal-body">
                                                                {{-- Input oculto esencial para mandar el ID del alumno al servidor --}}

                                                                <input type="hidden" name="alumno_id" id="modal-alumno-id">

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Licenciatura:</label>
                                                                    <input type="text" class="form-control"
                                                                        id="modal-alumno-input-carrera" disabled>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Ciclo a
                                                                        Reinscribir:</label>
                                                                    <select class="form-select" name="ciclo_id"
                                                                        id="modal-ciclo-select" required>
                                                                        <option value="" selected disabled>Cargando
                                                                            ciclos...</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            {{-- Pie del Modal --}}
                                                            <div class="modal-footer">
                                                                {{-- Al estar correctamente dentro del <form>, este botón ejecutará el submit en automático --}}
                                                                <button type="submit"
                                                                    class="btn btn-success">Reinscribir</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancelar</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>


                        </div>


                    </div>


                    <!-- Modal -->


                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-10 offset-1">
            <div class="card">
                <div class="card-header" style="background-color:#1b013f;">
                    <h3 class="" style="text-align: center; color:white ">Alumnos Reinscritos</h3>
                </div>
                <div class="card-body">

                    <table id="tabla-reinscripciones" class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Alumno</th>
                                <th>Carrera</th>
                                <th>Ciclo Inscrito</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnos as $alumno)
                                @foreach ($alumno->inscripciones as $inscripcion)
                                    <tr
                                        class="{{ $inscripcion->alumno->carrera_id === 1 ? 'table-success' : 'table-warning' }}">
                                        <td>{{ $inscripcion->folio_comprobante }}</td>
                                        <td>{{ $inscripcion->alumno->nombre . ' ' . $inscripcion->alumno->ap_paterno . ' ' . $inscripcion->alumno->ap_materno }}
                                        </td>
                                        <td>{{ $inscripcion->alumno->carrera->nombre }}</td>
                                        <td>{{ $inscripcion->ciclo->ciclo_letra }}
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">Imprimir constancia</a>
                                            <a href="#" class="btn btn-sm btn-secondary">Editar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            $(document).ready(function() {
                // ✅ Debe estar AQUÍ dentro
                const storageUrl = "{{ asset('storage') }}";

                $('#buscar-alumno').select2({
                    theme: 'bootstrap-5',
                    language: 'es',
                    placeholder: 'Buscar por nombre, folio o CURP...',
                    minimumInputLength: 2,
                    allowClear: true,
                    ajax: {
                        url: '{{ route('admin.inscripciones.buscar') }}',
                        dataType: 'json',
                        delay: 300,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results
                            };
                        },
                        cache: true
                    }
                });

                // Al seleccionar un alumno
                $('#buscar-alumno').on('select2:select', function(e) {
                    const a = e.params.data.data;
                    //pasar el id del alumno al botón de inscribir
                    $('#btn-inscribir').data('alumno-id', a.id);
                    $('#alumno-nombre').text(`${a.nombre} ${a.ap_paterno} ${a.ap_materno}`);
                    $('#alumno-folio').text(a.folio_alumno);
                    $('#alumno-curp').text(a.curp);
                    //obtener el estatus del alumno

                    //verificar el estatus del alumno para mostrar el botón de reinscribir o no
                    const btnReinscribir = document.getElementById('btn-abrir-modal-reinscripcion');
                    if (a.estatus && a.estatus.toUpperCase() === 'REINSCRITO') {
                        btnReinscribir.disabled = true;
                        btnReinscribir.innerText = 'Alumno reinscrito';
                        btnReinscribir.classList.remove('btn-primary');
                        btnReinscribir.classList.add('btn-warning');
                    } else {
                        btnReinscribir.disabled = false;
                        btnReinscribir.innerText = 'Reinscribir al alumno';
                        btnReinscribir.classList.remove('btn-secondary');
                        btnReinscribir.classList.add('btn-primary');
                    }
                    const nombreCompleto = `${a.nombre} ${a.ap_paterno} ${a.ap_materno}`.toUpperCase();

                    // 1. Esto actualiza el título <h5> del modal (lo que ya tenías, pero optimizado)
                    $('#alumno-modal_nombre').text(nombreCompleto);

                    // 2. 🚀 ESTO ES LO QUE TE FALTABA: Inyecta el nombre actual al INPUT deshabilitado del modal
                    $('#modal-alumno-input-carrera').val(a.carrera?.nombre ?? 'Sin carrera');

                    // Id de la carrera para enviar al backend en la reinscripción
                    // $('#modal-alumno-id-carrera').val(a.carrera_id);

                    // 3. 🚀 Guarda el ID del alumno seleccionado en el input oculto para enviarlo al backend
                    $('#modal-alumno-id').val(a.id);

                    // ... el resto de tu código para las fotos y remover la clase d-none ...
                    $('#datos-alumno').removeClass('d-none');
                    $('#alumno-carrera').text(a.carrera?.nombre ?? 'Sin carrera');

                    // ✅ Actualizar foto dinámicamente
                    const fotoUrl = a.foto ?
                        `${storageUrl}/${a.foto}` :
                        `${storageUrl}/placeholder.jpg`;
                    $('#alumno-foto').attr('src', fotoUrl);

                    const baseUrl = "{{ url('admin/inscripciones/create') }}";
                    $('#btn-inscribir').attr('href', `${baseUrl}/${a.id}`);
                    // Genera: /admin/inscripciones/create/1

                    $('#datos-alumno').removeClass('d-none');

                    //consulta ajax para llenar los ciclos disponibles en el select del modal
                    $.ajax({
                        url: '{{ url('admin/inscripciones/obtener_ciclos') }}/' + a
                            .carrera_id, // Enviar el ID de la carrera
                        method: 'GET',
                        dataType: 'json',
                        success: function(ciclos) {
                            const $select = $('#modal-ciclo-select');
                            $select.empty(); // Limpiar opciones anteriores
                            $select.append(
                                '<option value="" disabled selected>Selecciona un ciclo</option>'
                            );
                            ciclos.forEach(function(ciclo) {
                                $select.append(
                                    `<option style="text-align:center;color:#000" value="${ciclo.id}">${ciclo.ciclo_letra}</option>`
                                );
                            });
                        },
                        error: function() {
                            alert('Error al cargar los ciclos disponibles.');
                        }

                    });
                });

                // Si limpia la selección
                $('#buscar-alumno').on('select2:clear', function() {
                    $('#datos-alumno').addClass('d-none');
                });

            });

            $(document).ready(function() {
                $('#tabla-reinscripciones').DataTable({
                    responsive: true,
                    autoWidth: false,
                    order: [
                        [0, 'DESC']
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
                    }
                });
            });

            function editar_alumno() {
                id_alumno = document.getElementById('modal-alumno-id').value;
                window.location.href = '/admin/inscripciones/edit/' + id_alumno;
            }
        </script>
    @endpush
@endsection
