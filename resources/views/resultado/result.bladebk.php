@extends('layouts.mazer-admin')
@section('heading')
    Confirmación de pago
@endsection
@section('content')

    <section id="content-types">
        <div class="card-header mt-2 mb-2">
            <div class="buttons">
                <a href="{{ route('admin.dashboard.index') }}" class="btn btn-danger"><i class="cart-plus"></i> Inicio</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-6 col-sm-12">
                <div class="card">
                    
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
                        <div class="card-content">
                            <div class="card-body">
                                <p class="card-text"></p>
                                <!-- Table with outer spacing -->
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
            </div>
        </div>
    </section>


@endsection