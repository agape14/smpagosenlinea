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
            <div class="card-header mt-2 mb-2">
                <div class="buttons">
                    <button id="top-center" type="submit" class="btn btn-success"><i class="cart-plus"></i> Generar Liquidación de deuda</button>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Monto total a pagar</h6>
                        <h6 id="pago" class="font-extrabold mb-0">S/. </h6>
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
                                <!-- <th>Estado</th> -->
                                <th class="text-right">Total</th>
                                <th class="text-right">Amnistia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $currentYear = null;
                                $currentTributo = null;
                            @endphp
                            @if (count($WSCombined) > 0)
                                @foreach ($WSCombined as $item)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" data-cbx="{{ str_replace(',', '', $item->AMNISTIA) }}" class='checkboxclick' name="payment[]" value="{{ $item->ID }}" ></td>
                                        <td>{{ $item->ANNODEUDA }} - {{ $item->PERIODO }}</td>
                                        <td>{{ $item->DESCTRIBUTO }}</td>
                                        <td class="text-right">{{ $item->INSOLUTO }}</td>
                                        <td class="text-right">{{ $item->COSTO }}</td>
                                        <td class="text-right">{{ $item->MONTO_AJUSTADO }}</td>
                                        <td class="text-right">{{ $item->INTERES }}</td>
                                        <td>{{ $item->FECHA_VENCIMIENTO }}</td>
                                        <!-- <td>{{ $item->ESTADODEUDA }}</td> -->
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

		$(function () {

			var dataTable = $('#datadatable').DataTable({
                "bLengthChange": false,
                "responsive": true,
                "info": false,
                "paging": false,
                "ordering": false,
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

        $(".checkboxclick").click( function () {
            var objeto = $(this).data('cbx');

            if($(this).is(':checked')) {
                total+= parseFloat(objeto);
                arrayvalues.push($(this).val());
            }else{
                total-= parseFloat(objeto);
                if(arrayvalues.indexOf($(this).val())!=-1){
                    arrayvalues.splice(arrayvalues.indexOf($(this).val()),1);
                }
            }

            total = Math.round(total * 1000) / 1000;
            $("#pago").text(" S/. "+total);
            var text = "";
            for(var i=0;i<arrayvalues.length;i++){
                text+=arrayvalues[i]+",";
            }
        });

        function setarray(){
            document.getElementById("arrayv").value = arrayvalues;
        }
    </script>

@endsection