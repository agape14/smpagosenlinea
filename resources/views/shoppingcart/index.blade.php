@extends('layouts.mazer-admin')
@section('heading')
    Carrito de pagos
@endsection
@section('content')


    <section class="section">

        <div class="card-header mt-2 mb-2">
            <div class="buttons">
                <a href="{{ route('admin.deuda.index') }}" class="btn btn-secondary"><i class="cart-plus"></i> Regresar</a>
                <a href="{{ route('admin.viewer.postPayments') }}" class="btn btn-success" ><i class="metismenu-icon pe-7s-check"></i>Pagar</a>
            </div>
        </div>

        <form method="post" action="{{ route('admin.confirm.deleteitem') }}" onsubmit="setarray()">
            {{ csrf_field() }}

            <div class="card">
                <div class="card-header">
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Total a pagar</h6>
                        <h6 id="pago" class="font-extrabold mb-0 badge bg-danger">S/. 204.13</h6>
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
                                <th>Fecha Ven.</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><input type="checkbox" data-cbx="" class='checkboxclick' name="payment[]" value="" ></td>
                                <td>2024 - 02</td>
                                <td>IMP. PREDIAL</td>
                                <td class="text-right">68.04</td>
                                <td class="text-right">0.00</td>
                                <td class="text-right">0.00</td>
                                <td class="text-right">0.00</td>
                                <td>31/05/2024</td>
                                <td class="text-right">68.04</td>
                            </tr>
                            <tr>
                                <td class="text-center"><input type="checkbox" data-cbx="" class='checkboxclick' name="payment[]" value="" ></td>
                                <td>2024 - 03</td>
                                <td>IMP. PREDIAL</td>
                                <td class="text-right">68.04</td>
                                <td class="text-right">0.00</td>
                                <td class="text-right">0.00</td>
                                <td class="text-right">0.00</td>
                                <td>31/05/2024</td>
                                <td class="text-right">68.04</td>
                            </tr>
                            <tr>
                                <td class="text-center"><input type="checkbox" data-cbx="" class='checkboxclick' name="payment[]" value="" ></td>
                                <td>2024 - 04</td>
                                <td>IMP. PREDIAL</td>
                                <td class="text-right">68.05</td>
                                <td class="text-right">0.00</td>
                                <td class="text-right">0.00</td>
                                <td class="text-right">0.00</td>
                                <td>31/05/2024</td>
                                <td class="text-right">68.05</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="card-header">
                        <div class="buttons">
                            <button class="btn btn-danger"><i class="cart-plus"></i> Eliminar seleccionados</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/pages/datatables.min.js') }}"></script>
    <script src="{{ asset('js/pages/datatables.js') }}"></script>

    <script>
        var tabGeneral, security;
        var cticn = 0;
        $(function () {

            var dataTable = $('#datadatable').DataTable({
                "bLengthChange": false,
                "responsive": false,
                "info": false,
                "paging": false,
                "ordering": false,
                // "scrollCollapse": true,
                // "fixedColumns": true,
                "scrollX" : false,
            })

            $("#datadatable_filter").hide();

            $(".checkboxclick:checked").each(function(){});

            $('#select-all').on('click', function() {
              var rows = dataTable.rows({
                'search': 'applied'
              }).nodes();

              if (this.checked) {
                $('input[type="checkbox"]', rows).each(function() {
                  if (arrayvalues.indexOf($(this).val()) == -1) {
                    var objeto = $(this).data('cbx');
                    total += parseFloat(objeto);
                    arrayvalues.push($(this).val());
                  }
                });
              } else {
                $('input[type="checkbox"]:checked', rows).each(function() {
                  if (arrayvalues.indexOf($(this).val()) != -1) {
                    var objeto = $(this).data('cbx');
                    total -= parseFloat(objeto);
                    arrayvalues.splice(arrayvalues.indexOf($(this).val()), 1);
                  }
                });
              }

              $('input[type="checkbox"]', rows).prop('checked', this.checked);
                console.log("Total: " + total);
                console.log(arrayvalues);
                total = Math.round(total * 1000) / 1000;
              $("#pago").text(" S/. " + total);
            });

            tabGeneral = dataTable.rows({
              'search': 'applied'
            }).nodes();

        });
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