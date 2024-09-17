@extends('layouts.mazer-admin')
@section('heading')
    Constancia de pagos
@endsection
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover mb-0 " id="datadatable">
                    <thead>
                        <tr>
                            <th class="text-left">Nro Orden</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-left">Importe</th>
                            <th class="text-right">Estado</th>
                            <th class="text-right">Recibo</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($results)>0)
                            @foreach($results as $item)
                                <?php
                                    $originalDate = $item['FECLIQUIDACION'];
                                    $date = new DateTime($originalDate);
                                    $formattedDate = $date->format('d/m/Y');
                                ?>
                                <tr>
                                    <td class="text-left">{{$item['NUMORDEN']}}</td>
                                    <td class="text-center">{{$formattedDate}}</td>
                                    <td class="text-left">{{$item['NUMIMPORTE']}}</td>
                                    <td class="text-right">{{$item['TXTRESPUESTA']}}</td>
                                    <td class="text-right">{{$item['CODRECIBOPAGO']}}</td>
                                    <td class="text-right"><button style="margin-top: 0px !important;" type="button" class="btn btn-icon waves-effect waves-light btn-danger m-b-5 openPopup"
                                        data-codcontribuyente="{{ $item['CODCONTRIBUYENTE'] }}"
                                        data-txtcontribuyente="{{ $item['TXTCONTRIBUYENTE'] }}"
                                        data-codliquidacion="{{ $item['CODLIQUIDACION'] }}"
                                        ><i class="fa fa-search" aria-hidden="true"></i></button></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td  colspan="6"  style="text-align: center">No existen pagos realizados</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Indicador de carga -->
        <div id="loadingOverlay" class="d-none">
            <div class="loading-container">
                <i class="fa fa-download fa-spin"></i> Cargando...
            </div>
        </div>

        <!-- Popup -->
        <div id="contribuyentePopup" class="popup">
            <div class="popup-content">
                <div class="popup-header">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Código:</strong> <span id="codigoContribuyente"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Contribuyente:</strong> <span id="nombreContribuyente"></span>
                        </div>
                    </div>
                </div>

                <!-- Fila de 3 columnas: Nro Recibo, Nro Pedido, Fecha, Importe, Nro Tarjeta, Descripción -->
                <div class="row mt-3">
                    <div class="col-md-4"><strong>Nro Recibo:</strong> </div>
                    <div class="col-md-4"><strong>Nro Pedido:</strong> </div>
                    <div class="col-md-4"><strong>Fecha:</strong> </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4"><strong>Importe:</strong> </div>
                    <div class="col-md-4"><strong>Nro Tarjeta:</strong> </div>
                    <div class="col-md-4"><strong>Descripción:</strong> </div>
                </div>
                
                <!-- Aquí se cargará la tabla -->
                <div class="popup-body mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Periodo</th>
                                <th>Insoluto</th>
                                <th>Emisión</th>
                                <th>Reajuste</th>
                                <th>Interés</th>
                                <th>Total</th>
                                <th>Descuento</th>
                            </tr>
                        </thead>
                        <tbody id="popupTableBody">
                            <!-- Los detalles del tributo se cargarán aquí -->
                        </tbody>
                    </table>
                </div>

                <!-- Botón para cerrar el popup -->
                <div class="popup-footer text-center">
                    <button id="closePopup" class="btn btn-secondary"><i class="fa fa-times"></i>Cerrar</button>
                    <button id="printPopup" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</button>
                </div>
            </div>
        </div>


    </section> 

    <style type="text/css">
        .popup {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .popup-content {
            position: relative;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            width: 80%;
            max-width: 1200px;
            top: 10%;
        }

        .popup-header, .popup-body, .popup-footer {
            padding: 10px;
        }

        .table {
            width: 100%;
        }

        #popupTableBody {
            max-height: 300px; /* Ajusta el tamaño según sea necesario */
            overflow-y: auto;
        }

        #loadingMessage {
            text-align: center;
            margin: 20px;
        }

        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999; /* Asegúrate de que esté por encima de otros elementos */
        }

        .loading-container {
            text-align: center;
        }

        .loading-container i {
            font-size: 2rem; /* Tamaño del ícono */
            margin-bottom: 1rem; /* Espacio debajo del ícono */
        }

        .popup-footer {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px; /* Espacio entre los botones */
        }

        .popup-footer .btn {
            margin: 0 5px; /* Espacio adicional alrededor de los botones */
        }

        table.dataTable thead th {
            position: sticky;
            top: 0;
            background: #f0f0f0;
        }

    </style>

    <script src="{{ asset('extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/pages/datatables.min.js') }}"></script>
    <script src="{{ asset('js/pages/datatables.js') }}"></script>


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

        })
    </script>

    <script type="text/javascript">
        document.querySelectorAll('.openPopup').forEach(button => {
            button.addEventListener('click', function() {
                let codigo = this.getAttribute('data-codcontribuyente');
                let nombre = this.getAttribute('data-txtcontribuyente');
                let codliquidacion = this.getAttribute('data-codliquidacion');

                let url = "{{ url('/admin/listar_liquidacion_detalle/:codliquidacion') }}".replace(':codliquidacion', codliquidacion);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {

                        let popupContent = `
                            <html>
                            <head>
                                <title>Confirmación de pago</title>
                                <style>
                                    body { font-family: Arial, sans-serif; margin: 20px; }
                                    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                                    th, td { border: 1px solid #000; padding: 8px; text-align: right; }
                                    th { background-color: #f2f2f2; color: #000; }
                                    tr:nth-child(even) { background-color: #f9f9f9; }
                                    .highlight { background-color: #f2f2f2; font-weight: bold; }
                                    .total-row { background-color: #f2f2f2; color: red; font-weight: bold; }
                                    .text-center { text-align: center; }
                                    .text-end { text-align: right; }
                                    .text-green { color: green; }
                                    .badge { padding: 0.5em 0.75em; border-radius: 0.25rem; font-size: 1rem; }
                                    .text-bg-success { background-color: #28a745; color: #fff; }
                                    .icon-check { font-size: 24px; vertical-align: middle; margin-right: 10px; }
                                    .mt-3 { margin-top: 20px; }
                                    .row { display: flex; justify-content: space-between; }
                                    .col-md-4 { flex: 0 0 32%; }
                                    .print-button { background-color: #f2f2f2; color: black; border: 2px solid #28a745; padding: 10px 20px; cursor: pointer; border-radius: 5px; }
                                    .print-button:hover { background-color: #ddd; }
                                    .print-button:focus { outline: none; }
                                    .print-icon { margin-right: 5px; }
                                </style>
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                            </head>
                            <body>
                                <h1>Confirmación de pago</h1>
                                <p class="badge text-bg-success">
                                    <i class="fas fa-check icon-check"></i>
                                    El pago se ha completado con éxito. Gracias por usar este servicio.
                                </p>
                                <p><strong>Código:</strong> ${codigo}</p>
                                <p><strong>Nombre:</strong> ${nombre}</p>
                                <div class="row mt-3">
                                    <div class="col-md-4"><strong>Nro Recibo:</strong> </div>
                                    <div class="col-md-4"><strong>Nro Pedido:</strong> </div>
                                    <div class="col-md-4"><strong>Fecha:</strong> </div>                    
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-4"><strong>Importe:</strong> </div>
                                    <div class="col-md-4"><strong>Nro Tarjeta:</strong> </div>
                                    <div class="col-md-4"><strong>Descripción:</strong> </div>
                                </div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Periodo</th>
                                            <th>Insoluto</th>
                                            <th>Emisión</th>
                                            <th>Reajustes</th>
                                            <th>Interés</th>
                                            <th>Total</th>
                                            <th>Descuento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        `;

                        let direccionMostrada = false;
                        let tributosMostrados = new Set();

                        let totalInsoluto = 0;
                        let totalEmision = 0;
                        let totalReajuste = 0;
                        let totalInteres = 0;
                        let totalTotal = 0;
                        let totalDescuento = 0;

                        let subtotalInsoluto = 0;
                        let subtotalEmision = 0;
                        let subtotalReajuste = 0;
                        let subtotalInteres = 0;
                        let subtotalTotal = 0;
                        let subtotalDescuento = 0;

                        let currentTributo = null;

                        data.tributos.forEach(tributo => {
                            if (currentTributo && currentTributo !== tributo.CODTRIBUTO) {
                                popupContent += `
                                    <tr class="highlight">
                                        <td class="text-end" colspan="1"><strong>Subtotal:</strong></td>
                                        <td>${subtotalInsoluto.toFixed(2)}</td>
                                        <td>${subtotalEmision.toFixed(2)}</td>
                                        <td>${subtotalReajuste.toFixed(2)}</td>
                                        <td>${subtotalInteres.toFixed(2)}</td>
                                        <td>${subtotalTotal.toFixed(2)}</td>
                                        <td>${subtotalDescuento.toFixed(2)}</td>
                                    </tr>
                                `;

                                subtotalInsoluto = 0;
                                subtotalEmision = 0;
                                subtotalReajuste = 0;
                                subtotalInteres = 0;
                                subtotalTotal = 0;
                                subtotalDescuento = 0;
                            }

                            if (!tributosMostrados.has(tributo.CODTRIBUTO)) {
                                popupContent += `
                                    <tr class="highlight">
                                        <td colspan="7"><strong>Tributo:</strong> ${tributo.TXTTRIBUTO}</td>
                                    </tr>
                                `;
                                tributosMostrados.add(tributo.CODTRIBUTO);
                            }

                            if (tributo.TXTTRIBUTO === 'ARBITRIOS MUNICIPALES' && !direccionMostrada) {
                                popupContent += `
                                    <tr>
                                        <td colspan="7"><strong>Dirección:</strong> ${tributo.TXTPREDIO}</td>
                                    </tr>
                                `;
                                direccionMostrada = true;
                            }

                            subtotalInsoluto += parseFloat(tributo.MONTOINSOLUTO);
                            subtotalEmision += parseFloat(tributo.MONTOEMITIDO);
                            subtotalReajuste += parseFloat(tributo.MONTOAJUSTE);
                            subtotalInteres += parseFloat(tributo.MONTOMORA);
                            subtotalTotal += parseFloat(tributo.MONTOTOTAL);
                            subtotalDescuento += parseFloat(tributo.DSCTOBENEFICIO);

                            totalInsoluto += parseFloat(tributo.MONTOINSOLUTO);
                            totalEmision += parseFloat(tributo.MONTOEMITIDO);
                            totalReajuste += parseFloat(tributo.MONTOAJUSTE);
                            totalInteres += parseFloat(tributo.MONTOMORA);
                            totalTotal += parseFloat(tributo.MONTOTOTAL);
                            totalDescuento += parseFloat(tributo.DSCTOBENEFICIO);

                            popupContent += `
                                <tr>
                                    <td class="text-center">${tributo.TXTPERIODO}</td>
                                    <td>${tributo.MONTOINSOLUTO}</td>
                                    <td>${tributo.MONTOEMITIDO}</td>
                                    <td>${tributo.MONTOAJUSTE}</td>
                                    <td>${tributo.MONTOMORA}</td>
                                    <td>${tributo.MONTOTOTAL}</td>
                                    <td>${tributo.DSCTOBENEFICIO}</td>
                                </tr>
                            `;

                            currentTributo = tributo.CODTRIBUTO;
                        });

                        popupContent += `
                            <tr class="highlight">
                                <td class="text-end" colspan="1"><strong>Subtotal:</strong></td>
                                <td>${subtotalInsoluto.toFixed(2)}</td>
                                <td>${subtotalEmision.toFixed(2)}</td>
                                <td>${subtotalReajuste.toFixed(2)}</td>
                                <td>${subtotalInteres.toFixed(2)}</td>
                                <td>${subtotalTotal.toFixed(2)}</td>
                                <td>${subtotalDescuento.toFixed(2)}</td>
                            </tr>
                            <tr class="total-row">
                                <td class="text-end" colspan="1"><strong>Total General:</strong></td>
                                <td>${totalInsoluto.toFixed(2)}</td>
                                <td>${totalEmision.toFixed(2)}</td>
                                <td>${totalReajuste.toFixed(2)}</td>
                                <td>${totalInteres.toFixed(2)}</td>
                                <td>${totalTotal.toFixed(2)}</td>
                                <td>${totalDescuento.toFixed(2)}</td>
                            </tr>
                        `;

                        popupContent += `
                                     </tbody>
                                </table>
                                <div class="text-center">
                                    <button class="print-button" onclick="window.print()">
                                        <i class="fas fa-print print-icon"></i> Imprimir
                                    </button>
                                </div>
                            </body>
                            </html>
                        `;

                        let popupWindow = window.open('', '_blank', 'width=800,height=600');
                        popupWindow.document.write(popupContent);
                        popupWindow.document.close();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

    </script>
@endsection