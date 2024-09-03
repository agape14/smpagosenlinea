@extends('layouts.mazer-admin')
@section('heading')
    Confirmación de pago
@endsection
@section('content')

	<div class="container mt-5">
    <!-- Alertas -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill"/>
                </svg>
                <div>
                    <strong>Error:</strong> El pago no se ha completado, por favor verificar error.
                </div>
            </div>
        </div>
    </div>

    
    
    <div class="d-flex justify-content-center">
        <div class="row w-100">
            <div class="col-xl-12 col-md-6 col-sm-12">
                <div class="card">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <!-- Table with outer spacing -->
                                        <div class="table-responsive">
                                            <table class="table table-lg">
                                                <thead>
                                                    <tr>
                                                        <th>N° Pedido</th>
                                                        <th>Fecha y hora</th>
                                                        <th>Descripción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-bold-500">5214</td>
                                                        <td>15/05/2024</td>
                                                        <td class="text-bold-500">PAGO DE TRIBUTOS</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-lg">
                                                <thead>
                                                    <tr>
                                                        <th>Estado de la operación</th>
                                                        <th>OK</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Nombre del tarjetahabiente</th>
                                                        <th>ALVARADO MERINO RICARDO PEDRO</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Número de tarjeta</th>
                                                        <th>1234 5678 9876 XXXX</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Importe de la transacción</th>
                                                        <th>204.13</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Moneda</th>
                                                        <th>S/</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End of row -->
                </div> <!-- End of card -->
            </div> <!-- End of col -->
        </div> <!-- End of row -->
    </div> <!-- End of d-flex -->

    <!-- Botones centrados -->
    <div class="d-flex justify-content-center mt-4">
        <button type="button" class="btn btn-primary mx-2">Regresar</button>
        <button type="button" class="btn btn-secondary mx-2">Otro Botón</button>
    </div>
</div> <!-- End of container -->

@endsection