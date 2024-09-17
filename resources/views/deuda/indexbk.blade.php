@extends('layouts.mazer-admin')
@section('heading')
    Deuda corriente
@endsection
@section('content')    
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
                            @if (count($WSPredial) > 0)
                                @if(count($WSPredial) !== Session::get('Cpredial'))
                                    @foreach ($WSPredial as $predial)
                                        @if(!in_array($predial->ID, Session::get('Arrsession')))
                                            <tr>
                                                <td class="text-center"><input type="checkbox" data-cbx="{{ str_replace(',', '', $predial->AMNISTIA) }}" class='checkboxclick' name="payment[]" value="{{ $predial->ID }}" ></td>
                                                <td>{{ $predial->ANNODEUDA }} - {{ $predial->PERIODO }}</td>
                                                <td>{{ $predial->DESCTRIBUTO }}</td>
                                                <td class="text-right">{{ $predial->INSOLUTO }}</td>
                                                <td class="text-right">{{ $predial->COSTO }}</td>
                                                <td class="text-right">{{ $predial->MONTO_AJUSTADO }}</td>
                                                <td class="text-right">{{ $predial->INTERES }}</td>
                                                <td>{{ $predial->FECHA_VENCIMIENTO }}</td>
                                                <!-- <td>{{ $predial->ESTADODEUDA }}</td> -->
                                                <td class="text-right">{{ $predial->TOTAL }}</td>
                                                <td class="text-right">{{ $predial->AMNISTIA }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="alert alert-success">
                                        <strong>Posee deudas en el Carrito de Pagos</strong>
                                    </div>
                                @endif
                            @endif

                            @if(count($WSArbitrios) > 0)
                                @if(count($WSArbitrios) !== session::get('Carbitrio'))
                                    @foreach ($WSArbitrios as $arbitrios)
                                        @if(!in_array($arbitrios->ID, Session::get('Arrsession')))
                                        <tr >
                                          <td class="text-center"><input type="checkbox" data-cbx="{{ str_replace(',', '', $arbitrios->AMNISTIA) }}" class='checkboxclick' name="payment[]" value="{{ $arbitrios->ID }}" ></td>
                                            <td>{{ $arbitrios->ANNODEUDA }} - {{ $arbitrios->PERIODO }}</td>
                                            <td>{{ $arbitrios->DESCTRIBUTO }}</td>
                                            <td class="text-right">{{ $arbitrios->INSOLUTO }}</td>
                                            <td class="text-right">{{ $arbitrios->COSTO }}</td>
                                            <td class="text-right">{{ $arbitrios->MONTO_AJUSTADO }}</td>
                                            <td class="text-right">{{ $arbitrios->INTERES }}</td>
                                            <td>{{ $arbitrios->FECHA_VENCIMIENTO }}</td>
                                            <!-- <td>{{ $arbitrios->ESTADODEUDA }}</td> -->
                                            <td class="text-right">{{ $arbitrios->TOTAL }}</td>
                                            <td class="text-right">{{ $arbitrios->AMNISTIA }}</td>
                                        </tr>
                                      @endif
                                    @endforeach
                                @endif
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
		var tabPredial, tabArbitr, tabCostasGastos, tabMultas, tabCoactiv, security;
		var cticn = 0;

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
                cticn = 0;
                var rows = dataTable.rows({
                    'search': 'applied'
                }).nodes();

                if (this.checked) {
                    $('input[type="checkbox"]', rows).each(function() {
                        var coactivo = $(this).data('catv');
                        if(coactivo > 0){
                            cticn++;
                            if(cticn === 1){
                                //$.Notification.autoHideNotify('success', 'top right', 'La deuda selecionada posee Costas y Gastos')
                                alert('La deuda selecionada posee Costas');
                            }

                            $('.costGast-select-all2').prop("checked", true);
                            $(".costGast-select-all2").attr("disabled", true);
                            $('input[type="hidden"]', tabCoactiv).each(function() {
                                if (arrayvalues.indexOf($(this).val()) == -1) {
                                    var objeto = $(this).data('cbx');
                                    if(objeto.toString().indexOf(',') != -1){
                                      total += parseFloat(objeto.replace(',',""));
                                    }else{
                                      total += parseFloat(objeto);
                                    }
                                    arrayvalues.push($(this).val());
                                }
                            });
                        }

                        if (arrayvalues.indexOf($(this).val()) == -1) {
                            var objeto = $(this).data('cbx');
                            total += parseFloat(objeto);
                            arrayvalues.push($(this).val());
                        }
                    });
                } else {
                    $('input[type="checkbox"]:checked', rows).each(function() {
                        var coactivo = $(this).data('catv');
                        cticn = 0;
                        if(cticn == 0){
                            $('.costGast-select-all2').prop("checked", false);
                            $(".costGast-select-all2").removeAttr("disabled");
                            $('input[name=token]').attr('value','');
                            $('input[type="hidden"]', tabCoactiv).each(function() {
                            if (arrayvalues.indexOf($(this).val()) != -1) {
                              var objeto = $(this).data('cbx');
                              if(objeto.toString().indexOf(',') != -1){
                                total -= parseFloat(objeto.replace(',',""));
                              }else{
                                total -= parseFloat(objeto);
                              }
                              arrayvalues.splice(arrayvalues.indexOf($(this).val()), 1);
                            }
                            });
                        }

                        if (arrayvalues.indexOf($(this).val()) != -1) {
                            var objeto = $(this).data('cbx');
                            total -= parseFloat(objeto);
                            arrayvalues.splice(arrayvalues.indexOf($(this).val()), 1);
                        }
                    });
                }

                $('input[type="checkbox"]', rows).prop('checked', this.checked);
                total = Math.round(total * 1000) / 1000;
                $("#pago").text(" S/. " + total);
            })

            tabPredial = dataTable.rows({
                'search': 'applied'
            }).nodes();

		})
	</script>

    <script type="text/javascript">
        var total = 0.0;
        var arrayvalues = [];
        var band = [];
        security = 'SECURITY-COSTAS.GASTOS';

        $(".checkboxclick").click( function () {
            var objeto = $(this).data('cbx');
            var coactivo = $(this).data('catv');

            if(coactivo > 0){
                if ($(this).is(':checked')) {
                    cticn++;
                    //$.Notification.autoHideNotify('success', 'top right', 'La deuda selecionada posee Costas y Gastos')
                    alert('La deuda selecionada posee Costas y Gastos')

                    $('.costGast-select-all2').prop("checked", true);
                    $(".costGast-select-all2").attr("disabled", true);
                    $('input[name=token]').attr('value',security);
                    $('input[type="checkbox"]', tabCoactiv).each(function() {
                        if (arrayvalues.indexOf($(this).val()) == -1) {
                            var objeto = $(this).data('cbx');
                            if(objeto.toString().indexOf(',') != -1){
                                total += parseFloat(objeto.replace(',',""));
                            }else{
                                total += parseFloat(objeto);
                            }
                            arrayvalues.push($(this).val());
                        }
                    });
              } else {
                cticn--;
                if(cticn == 0){
                  $('.costGast-select-all2').prop("checked", false);
                  $(".costGast-select-all2").removeAttr("disabled");
                  $('input[name=token]').attr('value','');
                  $('input[type="checkbox"]', tabCoactiv).each(function() {
                    if (arrayvalues.indexOf($(this).val()) != -1) {
                      var objeto = $(this).data('cbx');
                      if(objeto.toString().indexOf(',') != -1){
                        total -= parseFloat(objeto.replace(',',""));
                      }else{
                        total -= parseFloat(objeto);
                      }
                      arrayvalues.splice(arrayvalues.indexOf($(this).val()), 1);
                    }
                  });
                }
              }
            }

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