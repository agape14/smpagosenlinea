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
        <form method="POST" action="{{ route('admin.confirm.generar_liquidacion') }}" onsubmit="setarray()">
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
                    <div>
                        <h6 class="text-muted font-semibold">Monto total a pagar</h6>
                        <h6 id="pago" class="font-extrabold mb-0">S/. </h6>
                    </div>

                    <!-- Sección del medio: Costa -->
                    <div id="div_costas" class="ms-3" style="display: none;">
                        <h6 class="text-muted font-semibold">Costa (10%)</h6>
                        <h6 id="id_costas" class="font-extrabold mb-0">S/. 126.85</h6>
                    </div>

                    <!-- Sección derecha: Total a pagar -->
                    <div id="div_pago_total" class="ms-3 text-end" style="display: none;">
                        <h6 class="text-muted font-semibold">Total a pagar</h6>
                        <h6 id="id_pago_total" class="font-extrabold mb-0">S/. 1395.39</h6>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover mb-0 " id="datadatable">
                        <thead>
                            <tr>
                            	<th class="text-center"><input id="imp-select-all" type="checkbox"></th>
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
                                        <td class="text-center"><input type="checkbox" data-situacion="{{ $item->SITUACION }}" data-cbx="{{ str_replace(',', '', $item->TOTAL) }}" class='checkboxclick' name="payment[]" value="{{ $item->ID }}" ></td>
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

        let montoMinimo = 10.0;
        let montoMaximo = 650.0;
        //SITUACION

		$(function () {

			var dataTable = $('#datadatable').DataTable({
                "bLengthChange": false,
                "responsive": true,
                "info": false,
                "paging": false,
                "ordering": false,
                "language": {
                    "emptyTable": "No hay datos disponibles en la tabla"
                }
                /*"columnDefs": [
                    {
                        "searchable": true,
                        "targets": [8],
                        "visible": false
                    }
                ],*/
            });

            $('.dataTables_filter').hide()

            $(".checkboxclick:checked").each(function(){});

            $('#imp-select-all').on('click', function() {
                var rows = dataTable.rows({ 'search': 'applied' }).nodes();
                var isChecked = this.checked;

                // Reiniciar valores
                total = 0;
                arrayvalues = [];

                // Seleccionar o deseleccionar todos los checkboxes
                $('input[type="checkbox"]', rows).each(function() {
                    var $checkbox = $(this);
                    var val = $checkbox.val();
                    var objeto = $checkbox.data('cbx');

                    if ($checkbox.closest('tr').find('input[type="checkbox"]').length > 0) { // Asegurarse de que la fila tenga un checkbox
                        $checkbox.prop('checked', isChecked);

                        if (!isNaN(parseFloat(objeto))) {
                            if (isChecked) {
                                if (arrayvalues.indexOf(val) === -1) {
                                    total += parseFloat(objeto);
                                    arrayvalues.push(val);
                                }
                            } else {
                                if (arrayvalues.indexOf(val) !== -1) {
                                    total -= parseFloat(objeto);
                                    arrayvalues.splice(arrayvalues.indexOf(val), 1);
                                }
                            }
                        } else {
                            console.log("Valor no numérico detectado:", objeto);
                        }
                    }
                });

                // Mostrar el total actualizado
                total = Math.round(total * 1000) / 1000;
                $("#pago").text(" S/. " + total);
            });

            // Manejo de checkboxes individuales
            $('#datadatable').on('change', 'input[type="checkbox"]', function() {
                var $checkbox = $(this);
                var val = $checkbox.val();
                var objeto = $checkbox.data('cbx');

                if ($checkbox.closest('tr').find('input[type="checkbox"]').length > 0) { // Asegurarse de que la fila tenga un checkbox
                    if (!isNaN(parseFloat(objeto))) {
                        if ($checkbox.is(':checked')) {
                            if (arrayvalues.indexOf(val) === -1) {
                                total += parseFloat(objeto);
                                arrayvalues.push(val);
                            }
                        } else {
                            if (arrayvalues.indexOf(val) !== -1) {
                                total -= parseFloat(objeto);
                                arrayvalues.splice(arrayvalues.indexOf(val), 1);
                            }
                        }
                    } else {
                        console.log("Valor no numérico detectado:", objeto);
                    }

                    // Actualizar el total
                    total = Math.round(total * 1000) / 1000;
                    $("#pago").text(" S/. " + total);
                }
            });

		})
	</script>

    <script type="text/javascript">
        var total = 0.0;
        var arrayvalues = [];

        var totalCoactivo = 0.0;

        let totalCostas = 0;
        let totalPagar = 0;
        const topeCostas = 650; // Máximo de 650 soles

        // Función para actualizar las vistas
        function actualizarVista() {
            $('#id_costas').text(totalCostas.toFixed(2));
            $('#id_pago_total').text(totalPagar.toFixed(2));

            // Mostrar u ocultar la sección de costas solo si totalCostas es mayor a 0
            if (totalCostas > 0) {
                $('#div_costas').show();
                $('#div_pago_total').show();
            } else {
                $('#div_costas').hide();
                $('#div_pago_total').hide();
            }
        }

        $(".checkboxclick").change( function () {
            var total = parseFloat($(this).data('cbx'));
            var situacion = parseFloat($(this).data('situacion'));
            console.log(situacion)
            if (situacion === 6) {
                if ($(this).is(':checked')) {
                    // Calcular el 10% del total
                    let costas = total * 0.10;

                    // Aplicar el mínimo de 10 soles si el 10% es menor a 10
                    if (costas < 10) {
                        costas = 10;
                    }

                    // Solo sumar costas si el total acumulado no ha alcanzado el tope de 650
                    if (totalCostas < topeCostas) {
                        totalCostas += costas;

                        // Verificar si el total acumulado de costas supera el tope
                        if (totalCostas > topeCostas) {
                            totalCostas = topeCostas; // Limitar el total de costas al tope de 650
                        }

                        totalPagar += total + costas;
                    } else {
                        totalPagar += total; // Si ya alcanzó el tope, solo sumar el total de la deuda
                    }
                } else {
                    // Si se deselecciona, restar los valores calculados
                    let costas = total * 0.10;

                    if (costas < 10) {
                        costas = 10;
                    }

                    // Si el total de costas ya es 650, no restar más
                    if (totalCostas <= topeCostas) {
                        totalCostas -= costas;

                        // Evitar que las costas sean negativas
                        if (totalCostas < 0) {
                            totalCostas = 0;
                        }

                        totalPagar -= total + costas;
                    } else {
                        totalPagar -= total; // Si el total de costas está en el tope, solo restar la deuda
                    }
                }
            }

            // Actualizar la vista con los valores recalculados
            actualizarVista();

            /*if($(this).is(':checked')) {
                total+= parseFloat(objeto);
                arrayvalues.push($(this).val());
            }else{
                total-= parseFloat(objeto);
                if(arrayvalues.indexOf($(this).val())!=-1){
                    arrayvalues.splice(arrayvalues.indexOf($(this).val()),1);
                }
            }*/

            total = Math.round(total * 1000) / 1000;
            $("#pago").text(" S/. "+total);
            var text = "";
            for(var i=0;i<arrayvalues.length;i++){
                text+=arrayvalues[i]+",";
            }
        });

        function mostrarSiSituacion6(registroSeleccionado) {
            //const checkbox = document.getElementById('situacionCheck');
            
            // Verificar si la situación es 6
            if (registroSeleccionado === 6) {

                const total = $(this).data('cbx');
                console.log(total)
                const costa = total * 0.10

                // Actualizar el contenido en HTML
                document.getElementById('id_costas').textContent = `S/. ${costa.toFixed(2)}`;
                document.getElementById('id_pago_total').textContent = `S/. ${(total + costa).toFixed(2)}`;



                // Mostrar los elementos si la situación es 6
                document.getElementById('div_costas').style.display = 'block';
                document.getElementById('div_pago_total').style.display = 'block';

                totalCoactivo = Math.round(totalCoactivo * 1000) / 1000;

            } else {
                // Ocultar los elementos en caso contrario
                document.getElementById('div_costas').style.display = 'none';
                document.getElementById('div_pago_total').style.display = 'none';
            }
        }

        function setarray(){
            document.getElementById("arrayv").value = arrayvalues;
        }
    </script>

@endsection