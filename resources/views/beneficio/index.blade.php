@extends('layouts.mazer-admin')
@section('heading')
    Deuda con Beneficio
@endsection
@section('content')    

    @php
        $alert = session()->pull('alert-danger');
    @endphp


    @if ($alert)
        <div class="alert alert-danger">
            {{ $alert }}
        </div>
    @endif

    @if(session()->has('liquidacion') && session()->has('importe'))
        <?php session()->forget('liquidacion'); ?>
        <?php session()->forget('importe'); ?>
    @endif

    <section class="section">
        <form method="POST" action="{{ route('admin.confirmBeneficio.generar_liquidacion_beneficio', ['from' => 'beneficio']) }}" onsubmit="setarray()">
            {{ csrf_field() }}

            @if (!$alert)
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
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <!-- Sección izquierda: Monto total a pagar -->
                    <div id="divDeuda" class="ms-3">
                        <h6 class="text-muted font-semibold">Deuda</h6>
                        <h6 id="pago" class="font-extrabold mb-0">S/. </h6>
                    </div>

                    <!-- Sección del medio: Costa -->
                    <div id="divDescuento" class="ms-3" >
                        <h6 class="text-muted font-semibold">Descuento</h6>
                        <h6 id="valorDescuento" class="font-extrabold mb-0">S/. </h6>
                    </div>

                    <!-- Sección derecha: Total a pagar -->
                    <div id="divTotalPagar" class="ms-3 text-end" >
                        <h6 class="text-muted font-semibold">Total a pagar</h6>
                        <h6 id="valorTotalPagar" class="font-extrabold mb-0">S/. </h6>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover mb-0" id="datadatableBeneficio">
                        <thead>
                            <tr>
                            	<th class="text-center"><input id="select-all" type="checkbox"></th>
                                <th>Año</th>
                                <th>Tributo</th>
                                <th class="text-center">Periodo</th>
                                <th class="text-right">Total sin<br>Beneficio</th>
                                <th class="text-right">Total con<br>Beneficio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($WSCombined) > 0)
                                @foreach ($WSCombined as $item)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" 
                                            data-beneficio="{{ str_replace(',', '', $item->BENEFICIO) }}" 
                                            data-total="{{ str_replace(',', '', $item->TOTAL) }}" 
                                            data-codconpago="{{ $item->CODCONPAGO }}"
                                            data-annodeuda="{{ $item->ANNODEUDA }}"
                                            class='checkboxclick' name="payment[]" 
                                            value="{{ $item->ID }}" ></td>
                                        <td>{{ $item->ANNODEUDA }}</td>
                                        <td>{{ $item->DESCRIPCION }}</td>
                                        <td class="text-center">{{ $item->PERIODO }}</td>
                                        <td class="text-right">{{ $item->TOTAL }}</td>
                                        <td class="text-right">{{ $item->BENEFICIO }}</td>
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
            if (message) {
                Toastify({
                    text: message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#4fbe87",
                }).showToast()
            }
        })
    </script>

	<script type="text/javascript">
		var tabCoactiv, security;
        var cticn = 0;

        var arrayvalues = [];
        var total = 0;

		$(function () {

			var dataTable = $('#datadatableBeneficio').DataTable({
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

            $('.dataTables_filter').hide()

            $(".checkboxclick:checked").each(function(){});


		})
	</script>

    <script type="text/javascript">
        var totalArray = [];
        var beneficioArray = [];
        var registrosSeleccionados = [];

        // Función para actualizar las sumas a partir de los arreglos
        function updateSum() {
            let sumaTotal = totalArray.reduce((a, b) => a + b, 0);
            let sumaBeneficio = beneficioArray.reduce((a, b) => a + b, 0);
            let sumaDescuento = sumaTotal - sumaBeneficio;

            // Actualizar los valores en el HTML
            $('#pago').text(sumaTotal.toFixed(2)); // Suma de total
            $('#valorDescuento').text(sumaDescuento.toFixed(2)); // Descuento = Total - Beneficio
            $('#valorTotalPagar').text(sumaBeneficio.toFixed(2)); // Suma de beneficio
        }

        function setarray(){
            document.getElementById("arrayv").value = JSON.stringify(registrosSeleccionados);
        }

        // Evento para manejar la selección de filas
        $('#datadatableBeneficio tbody').on('change', '.checkboxclick', function() {
            let row = $(this).closest('tr');
            let codConPago = $(this).data('codconpago'); // Obtener el CODCONPAGO de la fila
            let annoDeuda = $(this).data('annodeuda');
            let total = parseFloat($(this).data('total')) || 0;
            let beneficio = parseFloat($(this).data('beneficio')) || 0;

            // Obtener el ID del registro para el arreglo de registros seleccionados
            let id = $(this).val();

            if ($(this).is(':checked')) {
                // Si el checkbox está marcado, agregar los valores al arreglo
                totalArray.push(total);
                beneficioArray.push(beneficio);

                registrosSeleccionados.push({
                    id: id,
                    total: total,
                    beneficio: beneficio,
                    codConPago: codConPago
                });

                // Si el CODCONPAGO es 2, marcar todos los checkboxes con el mismo valor
                if (annoDeuda === 2024 && (codConPago === 1 || codConPago === 2)) {
                    $('#datadatableBeneficio tbody .checkboxclick').each(function() {
                        if ($(this).data('annodeuda') === 2024) {
                            if (($(this).data('codconpago') === 1 || $(this).data('codconpago') === 2) && !$(this).is(':checked')) {
                                $(this).prop('checked', true).trigger('change');
                            }
                        }
                    });
                } else if (annoDeuda < 2024) {
                    $('#datadatableBeneficio tbody .checkboxclick').each(function() {
                        if ($(this).data('annodeuda') < 2024 && !$(this).is(':checked')) {
                            $(this).prop('checked', true).trigger('change');
                        }
                    });
                }
            } else {
                // Si el checkbox está desmarcado, eliminar los valores del arreglo
                totalArray = totalArray.filter(value => value !== total);
                beneficioArray = beneficioArray.filter(value => value !== beneficio);
                registrosSeleccionados = registrosSeleccionados.filter(item => item.id !== id);

                // Desmarcar todos los checkboxes con el mismo codconpago si el checkbox marcado con codconpago=2 se desmarca
                if (annoDeuda === 2024 && (codConPago === 1 || codConPago === 2)) {
                    $('#datadatableBeneficio tbody .checkboxclick').each(function() {
                        if ($(this).data('annodeuda') === 2024) {
                            if (($(this).data('codconpago') === 1 || $(this).data('codconpago') === 2) && $(this).is(':checked')) {
                                $(this).prop('checked', false).trigger('change');
                            }
                        }
                    });
                } else if (annoDeuda < 2024) {
                    $('#datadatableBeneficio tbody .checkboxclick').each(function() {
                        if ($(this).data('annodeuda') < 2024 && $(this).is(':checked')) {
                            $(this).prop('checked', false).trigger('change');
                        }
                    });
                }
            }

            // Actualizar las sumas
            updateSum();
            setarray();
        });

        // Evento para seleccionar o deseleccionar todos los checkboxes
        $('#select-all').on('change', function() {
            let isChecked = $(this).is(':checked');
            totalArray = [];
            beneficioArray = [];

            $('#datadatableBeneficio tbody .checkboxclick').prop('checked', isChecked);

            if (isChecked) {
                // Agregar todos los valores al arreglo cuando se seleccionan todos
                $('#datadatableBeneficio tbody tr').each(function() {
                    let checkbox = $(this).find('.checkboxclick');

                    // Capturar los valores de los atributos data-* del checkbox
                    let total = parseFloat(checkbox.data('total')) || 0;
                    let beneficio = parseFloat(checkbox.data('beneficio')) || 0;

                    totalArray.push(total);
                    beneficioArray.push(beneficio);
                    registrosSeleccionados.push({
                        id: checkbox.val(),
                        total: total,
                        beneficio: beneficio,
                        codConPago: checkbox.data('codconpago')
                    });
                });
            }

            // Actualizar las sumas
            updateSum();
            setarray();
        });

        // Asegurar que el checkbox de la cabecera se actualice cuando todos los registros estén seleccionados o deseleccionados
        $('#datadatableBeneficio tbody').on('change', '.checkboxclick', function() {
            if ($('#datadatableBeneficio tbody .checkboxclick:checked').length === $('#datadatableBeneficio tbody .checkboxclick').length) {
                $('#select-all').prop('checked', true);
            } else {
                $('#select-all').prop('checked', false);
            }

            // Actualizar las sumas
            updateSum();
            setarray();
        });

    </script>

    <style type="text/css">
        table.dataTable thead th {
            position: sticky;
            top: 0;
            background: #f0f0f0;
        }
    </style>

@endsection