@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('view_title_name')
Módulo de usuarios
@endsection

@section('nav-reports')
active
@endsection
@section('nav-reports-collapse')
show
@endsection
@section('nav-reports-salers')
active
@endsection

@section('content')

@include('layouts.headers.empty')

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    @php 
                        $message = Session::get('message') ? Session::get('message') : null;
                        $messageClass = Session::get('messageClass')? Session::get('messageClass') : null;
                    @endphp
                    @if (isset($message) && isset($messageClass))
                        <div class="alert alert-{{ $messageClass }} alert-dismissible fade show" role="alert">
                            <strong>Notificación:</strong> {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="card-body row">
                    <div class="table-responsive col-md-6">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h3 class="mb-0">Vehículos comprados {{ date("m/Y") }}</h3>
                            </div>
                        </div>
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="purchasedCarsTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Placa</th>
                                    <th scope="col" class="thTaxationMiddle">Año</th>
                                    <th scope="col" class="thTaxationMiddle">Vehículo</th>
                                    <th scope="col" class="thTaxationMiddle">Vendedor</th>
                                    <th scope="col" class="thTaxationRight">Comisión</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive col-md-6">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h3 class="mb-0">Comisiones {{ date("m/Y") }}</h3>
                            </div>
                        </div>
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="comissionsTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Vendedor</th>
                                    <th scope="col" class="thTaxationMiddle">Cantidad vtas</th>
                                    <th scope="col" class="thTaxationMiddle">Total ventas</th>
                                    <th scope="col" class="thTaxationMiddle">Publicaciones</th>
                                    <th scope="col" class="thTaxationMiddle">Compras</th>
                                    <th scope="col" class="thTaxationRight">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
            <br>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="{{ asset('argon') }}/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('argon') }}/js/dataTables.bootstrap4.min.js"></script>
<script>
    $('#purchasedCarsTable').DataTable({
        // paging: false
        "lengthChange": false,
        "searching": false,
        "info":     false,
        "paging":   false,
        "language": {
            "url": "{{ asset('argon') }}/js/datatables.ES.json"
        },
        "columnDefs": [
            {
                "targets": [3,4,5],
                "className": 'dt-body-right'
            }
        ],
        'order': [[ 0, "desc" ]],
    });
    $('#comissionsTable').DataTable({
        // paging: false
        "lengthChange": false,
        "searching": false,
        "info":     false,
        "paging":   false,
        "language": {
            "url": "{{ asset('argon') }}/js/datatables.ES.json"
        },
        "columnDefs": [
            {
                "targets": [3,4,5],
                "className": 'dt-body-right'
            }
        ],
        'order': [[ 0, "desc" ]],
    });

    
</script>
@endpush