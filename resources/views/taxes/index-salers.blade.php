@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('view_title_name')
Módulo de vehículos
@endsection

@section('nav-cars')
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
                        if (isset($message) && is_null($message)) {
                            $message = Session::get('message') ? Session::get('message') : null;
                            $messageClass = Session::get('messageClass')? Session::get('messageClass') : null;
                        }
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
                            <h3 class="mb-0">Resumen de vehículos</h3>
                        </div>
                        <div class="col-4 text-right">
                            <select class="form-control" name="car_status" id="car_status" onchange="carStatus();">
                                <option {{ ($status === 'ALL') ? 'selected':'' }} value="ALL">MOSTRAR TODOS</option>
                                <option {{ ($status === 1) ? 'selected':'' }} value="1">COMPRADOS</option>
                                <option {{ ($status === 2) ? 'selected':'' }} value="2">VENDIDOS</option>
                                <option {{ ($status === 0) ? 'selected':'' }} value="0">INCOMPLETOS</option>
                                <option {{ ($status === 3) ? 'selected':'' }} value="3">ELIMINADOS</option>
                            </select>
                        </div>
                        <div class="col-4 text-right">
                            <a href="/cars-salers/create" class="btn btn btn-default">Nuevo vehículo</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="carListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Imagen</th>
                                    <th scope="col" class="thTaxationMiddle">Placa</th>
                                    <th scope="col" class="thTaxationMiddle">Marca</th>
                                    <th scope="col" class="thTaxationMiddle">Modelo</th>
                                    <th scope="col" class="thTaxationMiddle">Año</th>
                                    <th scope="col" class="thTaxationMiddle">Color</th>
                                    <th scope="col" class="thTaxationMiddle">Precio venta</th>
                                    <th scope="col" class="thTaxationMiddle">Precio Promoción</th>
                                    <th scope="col" class="thTaxationMiddle">Encargado</th>
                                    <th scope="col" class="thTaxationMiddle">Cliente</th>
                                    <th scope="col" class="thTaxationMiddle">Estado</th>
                                    <th scope="col" class="thTaxationMiddle">Fecha ingreso</th>
                                    <th scope="col" class="thTaxationRight"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carList as $key => $value)
                                @include('layouts.utils.car_status_utils')
                                <tr>
                                    <td>
                                        <a href="/cars/{{ $value->id }}/edit-images" jsonV="{{ json_encode($value->images_json) }}">
                                        @if(!is_null($value->images_json) 
                                            && isset($value->images_json['custom_image1']))
                                            <img style="border-radius: 5px;" src="{{ '/' . $value->images_json['custom_image1'] }}" height="30px">
                                        @else
                                            <img style="border-radius: 5px;" src="/argon/img/not_found.png" height="30px">
                                        @endif
                                        </a>
                                    </td>
                                    <td>{{ $value->number }}</td>
                                    <td>{{ $value->brand }}</td>
                                    <td>{{ $value->model }}</td>
                                    <td>{{ $value->fab_year }}</td>
                                    <td>{{ $value->color }}</td>
                                    <td>{{ number_format($value->price_sale) }} USD</td>
                                    <td>{{ number_format($value->price_promotion) }} USD</td>
                                    <td>{{ isset($value->createdBy) ? $value->createdBy['name'] . " " . $value->createdBy['lastname'] : "" }}</td>
                                    <td>{{ $value->owner }}</td>
                                    <td>{{ $value->status_name }}</td>
                                    <td>{{ $value->register_date }}</td>
                                    @if (is_null($value->created_by))
                                        <td class="">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ni ni-fat-add"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="#" onclick="requestVehicle({{ $value }});">Solicitar vehículo</a>
                                                </div>
                                            </div>
                                        </td>
                                    @elseif ((int)$value->created_by !== (int)$userId)
                                        <td class="">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ni ni-fat-remove"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="#">Usted no tiene a cargo este vehículo</a>
                                                </div>
                                            </div>
                                        </td>
                                    @else
                                        <td class="">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="/cars-salers/{{ $value->id }}/edit">Información general</a>
                                                    <a class="dropdown-item" href="/cars/{{ $value->id }}/edit-details">Características</a>
                                                    <a class="dropdown-item" href="/cars/{{ $value->id }}/edit-images">Administrar fotos</a>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
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
@include('layouts.modals.default')

@endsection

@push('js')
<script src="{{ asset('argon') }}/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('argon') }}/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.ES.js" charset="UTF-8"></script>
<script src="{{ asset('argon') }}/js/default.js"></script>
<script>
    $(document).ready(function() {
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "extract-date-pre": function(value) {
                if (value != "") {
                    date = value.split('/');
                    return Date.parse(date[1] + '/' + date[0] + '/' + date[2]);
                } else {
                    return "";
                }
            },
            "extract-date-asc": function(a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            "extract-date-desc": function(a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
    });
    $('#carListDataTable').DataTable({
        // paging: false
        "lengthChange": false,
        "language": {
            "url": "{{ asset('argon') }}/js/datatables.ES.json"
        },
        'order': [[ 0, "desc" ]],
        "columnDefs": [
            {
                "type": 'extract-date',
                "targets": [11]
            }
        ],
    });
    function carStatus() {
        var status = document.getElementById('car_status');
        if (status != null) {
            window.location.replace('/cars-salers?status=' + status.value);
        }
    }
    function requestVehicle(objVehicle) {
        var confirm = false;
        var status = document.getElementById('car_status');
        var confirm = window.confirm("El vehículo: " + objVehicle.number +" no tiene encargado. ¿Desea solicitar este vehículo?");
        if (confirm && (status != null)) {
            window.location.replace('/cars-salers?status=' + status.value + '&vehicleRequestId=' + objVehicle.id);
        }
    }
</script>
@endpush