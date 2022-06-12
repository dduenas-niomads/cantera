@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">

@endpush

@section('view_title_name')
Tasación vehicular
@endsection

@section('nav-taxations')
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
                        <div class="col-4">
                            <h3 class="mb-0">Listado de tasaciones vehiculares</h3>
                        </div>
                        <div class="col-4 text-right">
                            <select class="form-control" name="taxation_status" id="taxation_status" onchange="taxationStatus();">
                                <option {{ ((int)$status === 0) ? 'selected':'' }} value="0">MOSTRAR TODOS</option>
                                <option {{ ((int)$status === 1) ? 'selected':'' }} value="1">PENDIENTE</option>
                                <option {{ ((int)$status === 2) ? 'selected':'' }} value="2">COMPRADO</option>
                                <option {{ ((int)$status === 3) ? 'selected':'' }} value="3">RECHAZADO</option>
                            </select>
                        </div>
                        <div class="col-4 text-right">
                            <a href="/taxations/create" class="btn btn btn-default">Nueva tasación vehicular</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="taxationListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Titular</th>
                                    <th scope="col" class="thTaxationMiddle">Dueño</th>
                                    <th scope="col" class="thTaxationMiddle">Placa</th>
                                    <th scope="col" class="thTaxationMiddle">Marca/Modelo</th>
                                    <th scope="col" class="thTaxationMiddle">Color</th>
                                    <th scope="col" class="thTaxationMiddle">Monto Cliente</th>
                                    <th scope="col" class="thTaxationMiddle">Monto ofrecido</th>
                                    <th scope="col" class="thTaxationMiddle">Estado</th>
                                    <th scope="col" class="thTaxationMiddle">Fecha</th>
                                    <th scope="col" class="thTaxationRight"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($taxationList as $key => $value)
                                <tr>
                                    <td>{{ $value->car_holder }}</td>
                                    <td>{{ $value->car_owner }} <br> <i class="ni ni-mobile-button text-default"></i> {{ $value->phone }}</td>
                                    <td>{{ $value->car_number }}</td>
                                    <td>{{ $value->car_brand }} {{ $value->car_model }}</td>
                                    <td>{{ $value->car_color }}</td>
                                    <td>17000.00 {{ $value->currency }}</td>
                                    <td>15000.00 {{ $value->currency }}</td>
                                    <td>
                                        {{ ((int)$value->status === 1) ? 'PENDIENTE':'' }}
                                        {{ ((int)$value->status === 2) ? 'COMPRADO':'' }}
                                        {{ ((int)$value->status === 3) ? 'TERMINADO':'' }}
                                    </td>
                                    <td>{{ $value->taxation_date }}</td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                @if((int)$value->status === 1)
                                                    <a class="dropdown-item" href="/taxations/{{ $value->id }}/edit">Actualizar información</a>
                                                    <a class="dropdown-item" href="/taxations/{{ $value->id }}/edit-images">Administrar fotos</a>
                                                    <a class="dropdown-item forbidden" href="#">Dar de baja</a>
                                                @else
                                                    <a class="dropdown-item forbidden" href="#">Actualizar información</a>
                                                    <a class="dropdown-item forbidden" href="#">Administrar fotos</a>
                                                    <a class="dropdown-item forbidden" href="#">Dar de baja</a>
                                                @endif
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

@endsection

@push('js')
<script src="{{ asset('argon') }}/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('argon') }}/js/dataTables.bootstrap4.min.js"></script>
<script>
    $('#taxationListDataTable').removeAttr('width').DataTable({
        // paging: false
        "lengthChange": false,
        "language": {
            "url": "{{ asset('argon') }}/js/datatables.ES_taxations.json",
        },
        "scrollX": false,
        "fixedColumns": true
    });
    function taxationStatus() {
        var status = document.getElementById('taxation_status');
        if (status != null) {
            window.location.replace('/taxations?status=' + status.value);
        }
    }
</script>
@endpush