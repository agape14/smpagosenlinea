@extends('layouts.mazer-admin')
@section('heading')
    Deuda corriente
@endsection
@section('content')
    {{Session::forget('alert-danger')}}

    @if(session()->has('liquidacion') && session()->has('importe'))
        <?php session()->forget('liquidacion'); ?>
        <?php session()->forget('importe'); ?>
    @endif

    <section class="section">
        <form method="POST" action="{{ route('admin.confirm.generar_liquidacion', ['from' => 'deuda']) }}" onsubmit="setarray()">
            {{ csrf_field() }}

            <div class="card-header mt-2 mb-2 d-flex justify-content-between align-items-center">
                <div class="buttons">
                    <button id="top-center" type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Generar Liquidación de deuda
                    </button>
                </div>
                <div class="buttons">
                    <button id="refresh-button" class="btn btn-secondary ml-2">                        
                        <i class="fas fa-sync"></i> Actualizar
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <!-- Sección izquierda: Monto total a pagar -->
                    <div id="divDeuda" class="ms-3" style="display: none;">
                        <h6 class="text-muted font-semibold">Deuda total</h6>
                        <h6 id="pago" class="font-extrabold mb-0">S/. </h6>
                    </div>

                    <!-- Sección del medio: Costa -->
                    <div id="divCostas" class="ms-3" style="display: none;">
                        <h6 class="text-muted font-semibold">Gastos (10%)</h6>
                        <h6 id="valorCostas" class="font-extrabold mb-0">S/. </h6>
                    </div>

                    <!-- Sección derecha: Total a pagar -->
                    <div id="divTotalPagar" class="ms-3 text-end" >
                        <h6 class="text-muted font-semibold">Total a pagar</h6>
                        <h6 id="valorTotalPagar" class="font-extrabold mb-0">S/. </h6>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover mb-0 display" id="datadatable">
                        <thead>
                            <tr>
                            	<th class="text-center"><input id="select-all" type="checkbox"></th>
                                <th>Año Trim.</th>
                                <th>Tributo</th>
                                <th class="text-right">Insoluto</th>
                                <th class="text-right">G. Admin.</th>
                                <th class="text-right">Reajuste</th>
                                <th class="text-right">Interes</th>
                                <th>Fecha Venc.</th>
                                <th>Situación</th>
                                <th class="text-right">Total</th>
                                <th class="text-right">Amnistia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($WSCombined) > 0)
                                @foreach ($WSCombined as $item)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" data-situacion="{{ $item->SITUACION }}" data-cbx="{{ str_replace(',', '', $item->TOTAL) }}" class='checkboxclick' name="payment[]" data-id="{{ $item->ID }}" value="{{ $item->ID }}" ></td>
                                        <td>{{ $item->ANNODEUDA }} - {{ $item->PERIODO }}</td>
                                        <td>{{ $item->DESCTRIBUTO }}</td>
                                        <td class="text-right">{{ $item->INSOLUTO }}</td>
                                        <td class="text-right">{{ $item->COSTO }}</td>
                                        <td class="text-right">{{ $item->MONTO_AJUSTADO }}</td>
                                        <td class="text-right">{{ $item->INTERES }}</td>
                                        <td>{{ $item->FECHA_VENCIMIENTO }}</td>
                                        <td>{{ $item->SITUACION }}</td>
                                        <td class="text-right">{{ $item->TOTAL }}</td>
                                        <td class="text-right">{{ $item->AMNISTIA }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" name="arrayv" id="arrayv" value="">
        </form>
    </section>

    <link rel="stylesheet" href="{{ asset('js/toastify/css/toastify.css') }}">
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('js/toastify.js') }}"></script>    
    
	<script src="{{ asset('extensions/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('js/pages/datatables.min.js') }}"></script>
	<script src="{{ asset('js/pages/datatables.js') }}"></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var message = "{{ session('alert-liquidacion') }}";
            console.log(message)
            if (message) {
                Toastify({
                    text: message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#157347",
                }).showToast()
            }
        })
    </script>


    <script type="text/javascript">
        $(function () {
            var dataTable = $('#datadatable').DataTable({
                    "scrollY": 500, // Altura del contenedor con scroll
                    "scrollCollapse": true,
                    "bLengthChange": false,
                    "responsive": true,
                    "info": false,
                    "paging": false,
                    "ordering": false,
                    "language": {
                        "emptyTable": "No hay datos disponibles en la tabla"
                    }
                });

            $('.dataTables_filter').hide();

            $(".checkboxclick:checked").each(function(){});
        })
    </script>

    <script type="text/javascript">
        var tabCoactiv, security;
        let totalCostas = 0;
        let totalPagar = 0;
        let deudaTotal = 0;
        const topeCostas = 650;
        let registrosSeleccionados = [];
        let situacionCoactivo = new Set();
        let idsSeleccionados = new Set(); // Para rastrear IDs y evitar duplicados

        // Método para actualizar el campo hidden con el array de registros seleccionados
        function setarray() {
            console.log("Registros seleccionados:", registrosSeleccionados);
            document.getElementById("arrayv").value = JSON.stringify(registrosSeleccionados);
        }

        // Manejar la selección de todos los checkboxes
        $('#select-all').on('click', function() {
            var isChecked = $(this).is(':checked');
            $('input.checkboxclick').prop('checked', isChecked);
            calculateTotals(isChecked);
        });

        // Manejar la selección/desselección individual de checkboxes
        $('input.checkboxclick').on('change', function() {
            calculateTotals(false); // False indica que no es selección general
        });

        function calculateTotals(isSelectAll) {
            totalCostas = 0;
            totalPagar = 0;
            deudaTotal = 0;
            registrosSeleccionados = [];
            situacionCoactivo.clear();
            idsSeleccionados.clear(); // Limpiar el conjunto de IDs seleccionados
            let showToast = false; // Para controlar si mostramos el mensaje Toastify

            $('input.checkboxclick:checked').each(function() {
                var $checkbox = $(this);
                var id = $checkbox.data('id');
                var total = parseFloat($checkbox.data('cbx'));
                var situacion = parseInt($checkbox.data('situacion'), 10);

                deudaTotal += total;

                let costas = 0;
                if (situacion === 6) {
                    costas = total * 0.10;
                    if (costas < 10) costas = 10;
                    if (totalCostas + costas > topeCostas) {
                        costas = topeCostas - totalCostas;
                    }
                    totalCostas += costas;
                    totalPagar += total + costas;

                    // Marcar que debemos mostrar el mensaje Toastify si es selección general
                    if (isSelectAll) {
                        showToast = true;
                    } else {
                        // Si es selección individual, mostrar mensaje para situación 6
                        Toastify({
                            text: 'La deuda seleccionada posee Costas',
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "center",
                            style: {
                                background: "#157347"
                            },
                        }).showToast();
                    }

                    situacionCoactivo.add(id); // Añadir id al set de situaciones 6
                } else {
                    totalPagar += total;
                }

                // Agregar el registro al array de seleccionados para todas las situaciones
                if (!idsSeleccionados.has(id)) {
                    registrosSeleccionados.push({
                        id: id,
                        situacion: situacion,
                        valorRegistro: total,
                        costas: situacion === 6 ? costas : 0
                    });
                    idsSeleccionados.add(id); // Añadir el ID al conjunto de IDs seleccionados
                } else {
                    // Actualizar el registro existente si ya está en el arreglo
                    let existingRecord = registrosSeleccionados.find(record => record.id === id);
                    if (existingRecord) {
                        existingRecord.valorRegistro = total;
                        existingRecord.costas = situacion === 6 ? costas : 0;
                    }
                }
            });

            // Mostrar el mensaje Toastify una sola vez si es selección general
            if (isSelectAll && showToast) {
                Toastify({
                    text: 'Algunas deudas seleccionadas poseen Costas',
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    style: {
                        background: "#157347"
                    },
                }).showToast();
            }

            // Mostrar los resultados
            deudaTotal = Math.round(deudaTotal * 1000) / 1000;
            totalCostas = Math.round(totalCostas * 1000) / 1000;
            totalPagar = Math.round(totalPagar * 1000) / 1000;
            $('#pago').text("S/. " + deudaTotal);
            $('#valorCostas').text("S/. " + totalCostas);
            $('#valorTotalPagar').text("S/. " + totalPagar);

            // Ocultar los divs si no hay costas
            if (totalCostas === 0) {
                $('#divCostas').hide();
                $('#divDeuda').hide();
            } else {
                $('#divCostas').show();
                $('#divDeuda').show();
            }

            // Actualizar el campo con el array de registros seleccionados
            setarray();
        }
    </script>



    <style type="text/css">
        table.dataTable thead th {
            position: sticky;
            top: 0;
            background: #f0f0f0;
        }
    </style>
@endsection