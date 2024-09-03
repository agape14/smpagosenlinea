@extends('layouts.mazer-admin')
@section('heading')
    Confirmación de pago
@endsection
@section('content')

<div class="container mt-5">
    <!-- Alertas -->

    @if(session('alert-danger')['error_code'])
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-{{ session('alert-danger')['error_code'] === '' ? 'success' : 'danger' }} d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                        <use xlink:href="#exclamation-triangle-fill"/>
                    </svg>
                    <div>
                        <strong>{{ session('alert-danger')['error_code'] === '' ? 'Éxito:' : 'Error:' }}</strong> {{ session('alert-danger')['description'] }}
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                                                    @if (session('alert-danger')['error_code'] === '')
                                                        <tr>
                                                            <td class="text-bold-500">{{ $data->order_id }}</td>
                                                            <td>{{ $data->operation_date }}</td>
                                                            <td class="text-bold-500">PAGO DE TRIBUTOS</td>
                                                        </tr>
                                                    @else 
                                                        <tr>
                                                            <td class="text-bold-500"></td>
                                                            <td><?php echo date('Y-m-d H:i:s'); ?></td>
                                                            <td class="text-bold-500">PAGO DE TRIBUTOS</td>
                                                        </tr>
                                                    @endif
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
                                                        @if (session('alert-danger')['error_code'] === '')
                                                            <th>{{ $data->status }}</th>
                                                        @else
                                                            <th>Fallido</th>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <th>Nombre del tarjetahabiente</th>
                                                        @if (session('alert-danger')['error_code'] === '')
                                                            <th>{{ $data->card->holder_name }}</th>
                                                        @else
                                                            <th>{{ Auth::user()->name }}</th>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <th>Número de tarjeta</th>
                                                        @if (session('alert-danger')['error_code'] === '')
                                                            <th>{{ $data->card->card_number }}</th>
                                                        @else
                                                            <th></th>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <th>Importe</th>
                                                        @if (session('alert-danger')['error_code'] === '')
                                                            <th>{{ $data->amount }}</th>
                                                        @else
                                                            <th>{{ Session::get('importe') }}</th>
                                                        @endif
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
        <a href="{{ route('admin.deuda.index') }}" class="btn btn-success mx-2">Inicio</a>
    </div>
</div> <!-- End of container -->

@endsection