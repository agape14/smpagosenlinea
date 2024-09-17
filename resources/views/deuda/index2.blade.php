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
                    <div id="divDeuda" class="ms-3" >
                        <h6 class="text-muted font-semibold">Deuda total</h6>
                        <h6 id="pago" class="font-extrabold mb-0">S/. </h6>
                    </div>

                    <!-- Sección del medio: Costa -->
                    <div id="divCostas" class="ms-3" style="display: none;">
                        <h6 class="text-muted font-semibold">Costa (10%)</h6>
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
        var tabPredial, tabArbitr, tabCostasGastos, tabMultas, tabCoactiv, security;
        var cticn = 0;

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
                },
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

    <style type="text/css">
        table.dataTable thead th {
            position: sticky;
            top: 0;
            background: #f0f0f0;
        }
    </style>
@endsection