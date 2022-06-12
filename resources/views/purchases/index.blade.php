@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('view_title_name')
Módulo de compras
@endsection

@section('nav-purchases')
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
                            <h3 class="mb-0">Resumen de compras</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/purchases/create" class="btn btn btn-default">Nueva compra</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="carListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Marca</th>
                                    <th scope="col" class="thTaxationMiddle">Modelo</th>
                                    <th scope="col" class="thTaxationMiddle">Placa</th>
                                    <th scope="col" class="thTaxationMiddle">Año Fab.</th>
                                    <th scope="col" class="thTaxationMiddle">Titular</th>
                                    <th scope="col" class="thTaxationMiddle">Dueño</th>
                                    <th scope="col" class="thTaxationMiddle">Precio compra</th>
                                    <th scope="col" class="thTaxationMiddle">Notaria</th>
                                    <th scope="col" class="thTaxationMiddle">Fecha de compra</th>
                                    <th scope="col" class="thTaxationMiddle">Estado del vehículo</th>
                                    <th scope="col" class="thTaxationRight"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseList as $key => $value)
                                @include('layouts.utils.car_status_utils')
                                <tr>
                                    <td>{{ $value->brand }}</td>
                                    <td>{{ $value->model }}</td>
                                    <td>{{ $value->number }}</td>
                                    <td>{{ $value->fab_year }}</td>
                                    <td>{{ $value->holder }}</td>
                                    <td>{{ $value->owner }}</td>
                                    <td>{{ ($value->price_compra) ? number_format($value->price_compra) : 0 }} {{ $value->currency }}</td>
                                    <td>{{ $value->notary }}</td>
                                    <td>{{ $value->register_date }}</td>
                                    <td>{{ $value->status_name }}</td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="/purchases/{{ $value->id }}/edit">Información general</a>
                                                <a class="dropdown-item" href="#">Administrar archivos</a>
                                                <a class="dropdown-item" href="#" onClick="openDeletePurchaseModal({{ $value }});">Dar de baja</a>
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

<!-- modals -->
<div class="modal fade"  id="deletePurchaseModal"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('¿Desea dar de baja a la compra? ') }} <b id="idDeletePurchaseForm"></b> </h5>
            </div>
            <div class="modal-body">
                <form method="post" action="" autocomplete="off" id="deletePurchaseForm">
                    @csrf
                    @method('delete')
                    <label for="">Ingrese el motivo para dar de baja</label>
                    <input type="text" class="form-control"
                        name="commentary" id="commentaryDeletePurchaseForm"
                        placeholder="Comentario opcional para dar de baja">
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">{{ __('ELIMINAR') }}</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('REGRESAR') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="{{ asset('argon') }}/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('argon') }}/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "extract-purchase-date-pre": function(value) {
                if (value != "") {
                    date = value.split('/');
                    return Date.parse(date[1] + '/' + date[0] + '/' + date[2]);
                } else {
                    return "";
                }
            },
            "extract-purchase-date-asc": function(a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            "extract-purchase-date-desc": function(a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        $('#carListDataTable').DataTable({
            // paging: false
            "lengthChange": false,
            "language": {
                "url": "{{ asset('argon') }}/js/datatables.ES.json"
            },
            "columnDefs": [
                {
                    "targets": [6,7,8],
                    "className": 'dt-body-right'
                },
                {
                    "type": 'extract-purchase-date',
                    "targets": [8]
                },
            ],
            'order': [[ 0, "desc" ]],
        });
    });
    function openDeletePurchaseModal(purchase) {
        var purchaseId = purchase.id + "";
        document.getElementById('idDeletePurchaseForm').innerHTML = "Código: " + purchaseId.padStart(6, "0");
        document.getElementById("deletePurchaseForm").action = "/purchases/" + purchase.id;
        $('#deletePurchaseModal').modal();
    }
</script>
@endpush