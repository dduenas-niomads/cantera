@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('view_title_name')
Reporte de ventas
@endsection

@section('nav-reports')
active
@endsection
@section('nav-reports-collapse')
show
@endsection
@section('nav-reports-sales')
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
                    <div class="row">
                        <div class="col-md-4">
                            <h3 >Cierre de ventas por día en: {{ $cancha_name }}</h3>
                        </div>
                        <div class="col-md-8">
                            <form action="{{ route('sales.showReport') }}" method="get">
                                <div class="row">
                                    <div class="col-md-3 mt-1">
                                        <input type="date" name="date" class="form-control" value="{{ $selectedDate }}"  placeholder="Escriba la fecha">
                                    </div>
                                    <div class="col-md-3 mt-1">
                                        <select name="document_id" class="form-control">
                                            <option value="">TODOS LOS RUCS</option>
                                            @foreach ($taxes as $tax)
                                                <option value="{{ $tax->id }}">{{ $tax->document_number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-1">
                                        <select name="type_document" class="form-control">
                                            <option value="">TODOS LOS DOCUMENTOS</option>
                                            <option value="00">TICKET INTERNO</option>
                                            <option value="03">BOLETA</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-1">
                                        <button class="btn btn-success">Filtrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="saleListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Tipo</th>
                                    <th scope="col" class="thTaxationMiddle">Ruc</th>
                                    <th scope="col" class="thTaxationMiddle">Serie</th>
                                    <th scope="col" class="thTaxationMiddle">Correlativo</th>
                                    <th scope="col" class="thTaxationMiddle">Cliente</th>
                                    <th scope="col" class="thTaxationMiddle">Monto total</th>
                                    <th scope="col" class="thTaxationMiddle">Canal de pago</th>
                                    <th scope="col" class="thTaxationMiddle">Estado</th>
                                    <th scope="col" class="thTaxationRight">Fecha comprobante</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalAmount = 0;
                                    $gateways = [];
                                @endphp
                                @foreach ($saleList as $key => $sale)
                                    @php
                                        if ($sale->flag_active === 1 && !is_null($sale->gateway)) {
                                            $totalAmount = $totalAmount + $sale->total_amount;
                                            if (!isset($gateways[$sale->gateway->id])) {
                                                $gateways[$sale->gateway->id] = [
                                                    "name" => $sale->gateway->name,
                                                    "value" => 0
                                                ];
                                            }
                                            $gateways[$sale->gateway->id]['value'] = $gateways[$sale->gateway->id]['value'] + $sale->total_amount;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $sale->type_document }}</td>
                                        <td>{{ $sale->document->document_number }}</td>
                                        <td>{{ $sale->serie }}</td>
                                        <td>{{ $sale->correlative }}</td>
                                        <td>{{ $sale->client->name }}</td>
                                        <td>{{ number_format($sale->total_amount, 2) }}</td>
                                        <td>{{ !is_null($sale->gateway) ? $sale->gateway->name : "" }}</td>
                                        @include('layouts.utils.sunat_status')
                                        <td>{{ $sale->sunatStatus }}</td>
                                        <td>{{ $sale->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="8">
                                        <h3>Monto total emitido en {{ $selectedDate }}: S/ {{ number_format($totalAmount, 2) }}</h3>
                                        <label for="">Desglose por canales de pago</label>
                                        <ul>
                                            @foreach ($gateways as $gatewayInfo)
                                                <li><b> {{ $gatewayInfo['name'] }} : </b> S/ {{ number_format($gatewayInfo['value'], 2) }} </li>
                                            @endforeach
                                        </ul>
                                    </th>
                                </tr>
                            </tfoot>
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

<script src="{{ asset('argon') }}/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('argon') }}/js/jszip.min.js"></script>
<script src="{{ asset('argon') }}/js/buttons.html5.min.js"></script>
<script src="{{ asset('argon') }}/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#saleListDataTable').DataTable({
            // paging: false
            "searching": false,
            "lengthChange": false,
            "language": {
                "url": "{{ asset('argon') }}/js/datatables.ES.json"
            },
        });
    });
</script>
@endpush