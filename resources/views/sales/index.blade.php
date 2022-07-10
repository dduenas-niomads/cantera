@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('view_title_name')
Módulo de ventas
@endsection

@section('nav-sales')
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
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0">Resumen de ventas</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/sales/create" class="btn btn btn-default">Nueva venta</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="saleListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Tipo</th>
                                    <th scope="col" class="thTaxationMiddle">Ticket</th>
                                    <th scope="col" class="thTaxationMiddle">Cliente</th>
                                    <th scope="col" class="thTaxationMiddle">Total venta</th>
                                    <th scope="col" class="thTaxationMiddle">Canal de pagos</th>
                                    <th scope="col" class="thTaxationMiddle">Estado</th>
                                    <th scope="col" class="thTaxationMiddle">Comentarios</th>
                                    <th scope="col" class="thTaxationMiddle">Fecha</th>
                                    <th scope="col" class="thTaxationRight"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($saleList as $sale)
                                <tr>
                                    <td>{{ $sale->type_document }}</td>
                                    <td>{{ $sale->document->document_number }} <br> {{ $sale->serie }}-{{ str_pad($sale->correlative, 6, "0", STR_PAD_LEFT) }}</td>
                                    <td>{{ $sale->client->name }} ({{ $sale->client->document_number }})</td>
                                    <td>{{ number_format($sale->total_amount, 2) }}</td>
                                    <td>{{ !is_null($sale->gateway) ? $sale->gateway->name : "" }}</td>
                                    @include('layouts.utils.sunat_status')
                                    <td>{{ $sale->sunatStatus }}</td>
                                    <td>{{ $sale->commentary }}</td>
                                    <td>{{ $sale->created_at }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <button class="dropdown-item" onclick="openSaleInfo({{ $sale->id }});">Información general</button>
                                                @if (!is_null($sale->fe_url_pdf))
                                                    <a class="dropdown-item" href="{{ $sale->fe_url_pdf }}">Ver documento</a>
                                                @else
                                                    <button class="dropdown-item" onclick="feResend({{ $sale->id }});">Sin documento - Volver a emitir</button>
                                                @endif
                                                <button class="dropdown-item" onclick="feDelete({{ $sale->id }});">Anular venta</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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

<div class="modal fade" id="feResendModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h2 class="modal-title" id="sales_modal_code">Emitiendo documento de venta. Por favor, espere un momento...</h2>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="feDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h2 class="modal-title" id="sales_modal_code">Eliminando documento de venta. Por favor, espere un momento...</h2>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="salesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body" style="height: 250px; overflow-y: auto;">
                <table class="table table-sm table-striped table-responsive" style="width: 100%;">
                    <thead class="thead-dark">
                        <th>Información de venta</th>
                        <th>Productos vendidos</th>
                    </thead>
                    <tbody id="tbodySalesModal"></tbody>
                </table>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">{{ __('VOLVER') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="{{ asset('argon') }}/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('argon') }}/js/dataTables.bootstrap4.min.js"></script>
<script>
    function openSaleInfo(saleId) {
        $('#salesModal').modal();       
        $.ajax({
            url: "/api/sale-by-id/" + saleId,
            type: 'GET',
            success: function(result) {
                printReservationSales(result.result);
            },
            error: function(result, status) {
                alert(result.responseJSON.message);
            }
        });
    }
    function printReservationSales(sales_ = []) {
        var tbodySalesModal = document.getElementById('tbodySalesModal');
        if (tbodySalesModal) {
            tbodySalesModal.innerHTML = "";
			sales_.forEach(item => {
                ulProducts = '';
                items_ = item.items;
                count_ = 1;
                items_.forEach(element => {
                    ulProducts += '<ul class="simple_ul"><li><b>N°: </b>' + count_ + '</li>' +
                        '<li><b>Código: </b>' + element.code + '</li>' +
                        '<li><b>Nombre: </b>' + element.name + '</li>' +
                        '<li><b>Cantidad: </b>' + element.quantity + '</li>' +
                        '<li><b>Precio: </b>' + element.price + '</li></ul><br>';
                    count_++;
                });
                url_ = "";
                if (item.fe_url_pdf) {
                    url_ = '<a target="_blank" href="'+ item.fe_url_pdf +'">Abrir documento</a>';
                }
                var statusName = "Ok";
                if (parseInt(item.flag_active) == 0) {
                    statusName = "Anulado";
                }
                codString = item.correlative.toString();
                ulDocument = '<ul class="simple_ul"><li><b>Ruc: </b>' + item.document.document_number + '</li>' +
                    '<li><b>Doc: </b>' + item.serie + '-' + codString.padStart(6, "0") + '</li>' +
                    '<li><b>Tipo: </b>' + item.type_document + '</li>' +
                    '<li><b>Total: </b>S/ ' + (parseFloat(item.total_amount)).toFixed(2) + '</li>' +
                    '<li><b>Fecha: </b>' + item.created_at + '</li>' +
                    '<li><b>Estado: </b>' + statusName + '</li>' +
                    '<li><b>' + url_ + '</b></li></ul>';
				b = document.createElement("TR");
				b.innerHTML += '<td>' + ulDocument + '</td>' +
					'<td>' + ulProducts + '</td>'; 
                tbodySalesModal.appendChild(b);
			});
        }
    }
    function feResend(saleId) {
        $('#feResendModal').modal();
        $.get("/api/sales/fe-resend/" + saleId, function(data, status) {
            window.location.replace("/sales");
		}).fail(function(data, status) {
            alert("No se pudo emitir el comprobante electrónicamente. Inténtelo más tarde.");
            $('#feResendModal').modal('hide');
		});
    }
    function feDelete(saleId) {
        //$('#feDeleteModal').modal();
        $.get("/api/sales/delete/" + saleId, function(data, status) {
            window.location.replace("/sales");
		}).fail(function(data, status) {
            alert("No se pudo eliminar el comprobante electrónicamente. Inténtelo más tarde.");
            //$('#feDeleteModal').modal('hide');
		});
    }
    $(document).ready(function() {
        $('#saleListDataTable').DataTable({
            // paging: false
            'order': [[ 7, "desc" ]],
            "lengthChange": false,
            "language": {
                "url": "{{ asset('argon') }}/js/datatables.ES.json"
            }
        });
    });
</script>
@endpush