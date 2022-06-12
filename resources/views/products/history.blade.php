@extends('layouts.app', ['class' => 'bg-dark', 'titleName' => 'JC Ugarte - Reporte de stock ' . date("d/m/Y")])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('view_title_name')
Módulo de vehículos
@endsection

@section('nav-reports')
active
@endsection
@section('nav-reports-collapse')
show
@endsection
@section('nav-cars-history')
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
                            <h3 class="mb-0">Historial de vehículo</h3>
                        </div>
                        <form class="" action="{{ route('cars.showHistory') }}" method="get">
                            <div class="col-12 row  text-right">
                                <div class="col-6">
                                    <input type="text" maxlength="8" class="form-control" name="number" 
                                    placeholder="Ingrese placa...">
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-default">BUSCAR PLACA</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="myTable align-items-center table-bordered table-hover table-sm table-striped" id="saleListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Placa</th>
                                    <th scope="col" class="thTaxationMiddle">Marca</th>
                                    <th scope="col" class="thTaxationMiddle">Modelo</th>
                                    <th scope="col" class="thTaxationMiddle">Año fab</th>
                                    <th scope="col" class="thTaxationMiddle">Año modelo</th>
                                    <th scope="col" class="thTaxationMiddle">Color</th>
                                    <th scope="col" class="thTaxationMiddle">Estado</th>
                                    <th scope="col" class="thTaxationMiddle">Ingreso</th>
                                    <th scope="col" class="thTaxationMiddle">Compra</th>
                                    <th scope="col" class="thTaxationRight">Venta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carList as $key => $value)
                                    @include('layouts.utils.car_status_utils')
                                    <tr>
                                        <td>{{ $value->number }}</td>
                                        <td>{{ $value->brand }}</td>
                                        <td>{{ $value->model }}</td>
                                        <td>{{ $value->fab_year }}</td>
                                        <td>{{ $value->model_year }}</td>
                                        <td>{{ $value->color }}</td>
                                        <td>{{ $value->status_name }}</td>
                                        <td>
                                            <a href="#" onclick="abrir_Popup('cars', {{ $value->id }});">
                                                {{ $value->register_date }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" onclick="abrir_Popup('purchases', {{ (!is_null($value->actualPurchase)) ? $value->actualPurchase->id : null }});">
                                                {{ (!is_null($value->actualPurchase)) ? $value->actualPurchase->register_date : '--' }} <br> 
                                                {{ (!is_null($value->actualPurchase)) ? number_format($value->actualPurchase->price_compra) . " USD" : '--' }}                                        
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" onclick="abrir_Popup('sales', {{ (!is_null($value->sale)) ? $value->sale->id : null }});">
                                                {{ (!is_null($value->sale)) ? $value->sale->sale_date : '--' }} <br>
                                                {{ (!is_null($value->sale)) ? number_format($value->sale->price_sale) . " USD" : '--' }}
                                            </a>
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

<script src="{{ asset('argon') }}/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('argon') }}/js/jszip.min.js"></script>
<script src="{{ asset('argon') }}/js/buttons.html5.min.js"></script>
<script src="{{ asset('argon') }}/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "extract-date-pre": function(value) {
                var date = $(value, 'span')[0].innerHTML;
                date = date.split('/');
                return Date.parse(date[1] + '/' + date[0] + '/' + date[2])
            },
            "extract-date-asc": function(a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            "extract-date-desc": function(a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        $('#saleListDataTable').DataTable({
            // paging: false
            "searching": false,
            "lengthChange": false,
            "language": {
                "url": "{{ asset('argon') }}/js/datatables.ES.json"
            },
            "ordering": true,
            "columnDefs": [{
                    type: 'extract-date',
                    targets: [7]
                }
            ],
            "order": ["7", "desc"]
        });
    });

    var configuracion_ventana = 'height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes';
    function abrir_Popup(module, id) {
        if (id === null) {
            alert("No existe el documento.")
        } else {
            window.open('/' + module + "/" + id + "/edit",'popUpWindow', configuracion_ventana);
        }
    }
</script>
@endpush