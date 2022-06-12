@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('view_title_name')
IGV y RENTA
@endsection

@section('nav-taxes')
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
                            <h3 class="mb-0">Resumen de vehículos e impuestos</h3>
                        </div>
                        <div class="col-4 text-right">
                            <select class="form-control" name="car_status" id="car_status" onchange="carStatus('/report/taxes');">
                                <option {{ ($status === 'ALL') ? 'selected':'' }} value="ALL">MOSTRAR TODOS</option>
                                <option {{ ($status === 1) ? 'selected':'' }} value="1">COMPRADOS</option>
                                <option {{ ($status === 2) ? 'selected':'' }} value="2">VENDIDOS</option>
                                <option {{ ($status === 0) ? 'selected':'' }} value="0">ELIMINADOS</option>
                            </select>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="carListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Marca</th>
                                    <th scope="col" class="thTaxationMiddle">Modelo</th>
                                    <th scope="col" class="thTaxationMiddle">Placa</th>
                                    <th scope="col" class="thTaxationMiddle">P.Compra</th>
                                    <th scope="col" class="thTaxationMiddle">P.Venta</th>
                                    <th scope="col" class="thTaxationMiddle">Gastos</th>
                                    <th scope="col" class="thTaxationMiddle">IGV</th>
                                    <th scope="col" class="thTaxationMiddle">RENTA</th>
                                    <th scope="col" class="thTaxationRight"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carList as $key => $value)
                                    <tr>
                                        <td>{{ $value->brand }}</td>
                                        <td>{{ $value->model }}</td>
                                        <td>{{ $value->number }}</td>
                                        <td>{{ ($value->price_compra) ? number_format($value->price_compra) : 0 }} <br> {{ $value->currency }}</td>
                                        <td>{{ ($value->price_sale) ? number_format($value->price_sale) : 0 }} <br> {{ $value->currency }}</td>                                        
                                        @php
                                            $jsonExpenses = [];
                                            $situationIGV = "INCOMPLETO";
                                            $situationIGVClass = "btn-danger";
                                            $situationIGVStatus = true;
                                            $situationRent = "INCOMPLETO";
                                            $situationRentClass = "btn-danger";
                                            $situationRentStatus = true;
                                            if (!is_null($value->expenses) && !is_null($value->expenses->expenses_json)) {
                                                $jsonExpenses = $value->expenses->expenses_json;
                                            }
                                        @endphp
                                        <td>
                                            <ul>
                                                @foreach ($jsonExpenses as $keyJE => $valueJE)
                                                    <li>
                                                        <ul>
                                                            <li>Nombre: {{ $valueJE['name'] }}</li>
                                                            <li>Detalle: {{ $valueJE['detail'] }}</li>
                                                            <li>Fecha: {{ $valueJE['date'] }}</li>
                                                            <li>Monto: {{ $valueJE['value'] }}</li>
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td> <button class="btn btn-sm {{ $situationIGVClass }}" onClick="openModalTaxes({{ $value }}, 'IGV', {{ $situationIGVStatus }})"> {{ $situationIGV }} </button> </td>
                                        <td> <button class="btn btn-sm {{ $situationRentClass }}" onClick="openModalTaxes({{ $value }}, 'RENT', {{ $situationRentStatus }})"> {{ $situationRent }} </button> </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="/cars/{{ $value->id }}/edit-expenses">Administrar gastos</a>
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
@include('layouts.modals.default')

<div class="modal fade"  id="modal_IGV"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="h5_title_IGV">{{ __('INGRESAR IGV DE VEHICULO: ') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <label for="">Monto de IGV</label>
            <input type="hidden" name="cars_id" value="" id="input_cars_id_IGV">
            <input type="number" name="value_IGV" class="form-control" value="0.00" placeholder="Ingrese valor de IGV">
        </div>
        <div class="modal-footer">
            <button type="button" onClick="submitForm('deleteForm');" class="btn btn-success">{{ __('GUARDAR') }}</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('REGRESAR') }}</button>
        </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="{{ asset('argon') }}/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('argon') }}/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.ES.js" charset="UTF-8"></script>
<script src="{{ asset('argon') }}/js/default.js"></script>
<script>
    $('#carListDataTable').DataTable({
        // paging: false
        "lengthChange": false,
        "language": {
            "url": "{{ asset('argon') }}/js/datatables.ES.json"
        },
        "columnDefs": [
        ],
        'order': [[ 0, "desc" ]],
    });

    function showExpensesDetail(car) {
        var carExpensesAhref = document.getElementById("carExpensesAhref");
        if (carExpensesAhref != null) {
            carExpensesAhref.innerHTML = " Agregar gastos";
            carExpensesAhref.href = "/cars/" + car.id + "/edit-expenses";
        }
        var utilityAmount = 0;
        document.getElementById("em_carName").innerHTML = car.brand + ' ' + car.model + ' (' + car.number + ')';
        document.getElementById("expenses_pc").innerHTML = parseFloat(car.price_compra  + 0).toFixed(0);
        document.getElementById("expenses_pv").innerHTML = parseFloat(car.price_sale  + 0).toFixed(0);
        document.getElementById("expenses_gd").innerHTML = parseFloat(car.costPerDay).toFixed(0);
        document.getElementById("expenses_days").innerHTML = car.dateDiff + ' días';
        document.getElementById("expenses_days_x_gd").innerHTML = parseFloat(car.dateDiff*car.costPerDay).toFixed(0)
        document.getElementById("expenses_amount").innerHTML = parseFloat(car.expensesAmount).toFixed(0);
        utilityAmount = (car.price_sale - car.price_compra) - car.totalExpensesAmount;
        document.getElementById("total_expenses").innerHTML = parseFloat(car.totalExpensesAmount).toFixed(0) + ' ' + car.currency;
        document.getElementById("total_utility").innerHTML = parseFloat(utilityAmount).toFixed(0) + ' ' + car.currency;
        if (car.expenses != null) {
            var tbodyExpensesDetail = document.getElementById('tbodyExpensesDetail');
            if (tbodyExpensesDetail != null) {
                tbodyExpensesDetail.innerHTML = "";
                var stringHtml = '';
                var obj = car.expenses.expenses_json;
                if (obj != null) {
                    Object.keys(obj).forEach(key => {
                        stringHtml += '<tr><td>'+ ((obj[key].name) ? obj[key].name : '--') +'</td>' +
                                    '<td>'+ ((obj[key].detail) ? obj[key].detail : '--') +'</td>' +
                                    '<td>'+ ((obj[key].date) ? obj[key].date : '--') +'</td>' +
                                    '<td>'+ ((obj[key].value) ? obj[key].value : '--') +' '+ obj[key].currency +'</td>' +
                                    '<td>'+ (parseFloat((obj[key].exchange_rate) ? obj[key].exchange_rate : 1)).toFixed(0) +'</td>' +
                                    '<td>'+ (parseFloat(obj[key].value)/parseFloat((obj[key].exchange_rate) ? obj[key].exchange_rate : 1)).toFixed(0) + ' USD</td></tr>';
                    });
                    tbodyExpensesDetail.insertAdjacentHTML('beforeend', stringHtml);   
                }
            }
        }        
        $('#expensesModal').modal();
    }
    function openWebStatusModal(car) {
        if (parseInt(car.for_sale) === 0) {
            document.getElementById('idPublishCarModalB').innerHTML = car.brand + " " + car.model + " " + car.number;
            document.getElementById("publishCarModalForm").action = "/cars/" + car.id;
            $('#publishCarModal').modal();
        } else {
            document.getElementById('idUnpublishCarModalB').innerHTML = car.brand + " " + car.model + " " + car.number;
            document.getElementById("unpublishCarModalForm").action = "/cars/" + car.id;
            $('#unpublishCarModal').modal();
        }
    }
    function carStatus(uri = "") {
        var status = document.getElementById('car_status');
        if (status != null) {
            window.location.replace('/cars'+ uri +'?status=' + status.value);
        }
    }
    function openModalTaxes(car, modal, status) {
        if (status == 1) {
            $('#modal_IGV').modal();
        }
        // console.log(car, modal, status);
    }
</script>
@endpush