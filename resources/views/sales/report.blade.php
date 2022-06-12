@extends('layouts.app', ['class' => 'bg-dark', 'titleName' => 'JC Ugarte - Reporte de ventas ' . date("d/m/Y")])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('view_title_name')
Módulo de ventas
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
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0">Reporte de ventas</h3>
                        </div>
                        <div class="col-6">
                            <select class="form-control" name="period" onchange="filterByPeriod(this);">
                                <option value="0">SELECCIONE UN PERIODO</option>
                                <option value="06/2021">JUNIO 2021</option>
                                <option value="07/2021">JULIO 2021</option>
                                <option value="08/2021">AGOSTO 2021</option>
                                <option value="09/2021">SEPTIEMPRE 2021</option>
                                <option value="10/2021">OCTUBRE 2021</option>
                                <option value="11/2021">NOVIEMBRE 2021</option>
                                <option value="12/2021">DICIEMBRE 2021</option>
                                <option value="01/2022">ENERO 2022</option>
                                <option value="02/2022">FEBRERO 2022</option>
                                <option value="03/2022">MARZO 2022</option>
                                <option value="04/2022">ABRIL 2022</option>
                                <option value="05/2022">MAYO 2022</option>
                                <option value="06/2022">JUNIO 2022</option>
                                <option value="07/2022">JULIO 2022</option>
                                <option value="08/2022">AGOSTO 2022</option>
                                <option value="09/2022">SEPTIEMBRE 2022</option>
                                <option value="10/2022">OCTUBRE 2022</option>
                                <option value="11/2022">NOVIEMBRE 2022</option>
                                <option value="12/2022">DICIEMBRE 2022</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="saleListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Venta</th>
                                    <th scope="col" class="thTaxationMiddle">Compra</th>
                                    <th scope="col" class="thTaxationMiddle">Año</th>
                                    <th scope="col" class="thTaxationMiddle">Carros que llegaron</th>
                                    <th scope="col" class="thTaxationMiddle">Color</th>
                                    <th scope="col" class="thTaxationMiddle">Placa</th>
                                    <th scope="col" class="thTaxationMiddle">D_B_F</th>
                                    <th scope="col" class="thTaxationMiddle">Ventas</th>
                                    <th scope="col" class="thTaxationMiddle">Costo</th>
                                    <th scope="col" class="thTaxationMiddle">Utilidad</th>
                                    <th scope="col" class="thTaxationMiddle">Sociedad</th>
                                    <th scope="col" class="thTaxationMiddle">Sunat</th>
                                    <th scope="col" class="thTaxationMiddle">i.g.v</th>
                                    <th scope="col" class="thTaxationMiddle">renta</th>
                                    <!-- <th scope="col" class="thTaxationMiddle">encargado</th> -->
                                    <th scope="col" class="thTaxationMiddle">vendedor</th>
                                    <th scope="col" class="thTaxationMiddle">publicador</th>
                                    <th scope="col" class="thTaxationRight">deuda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($saleList as $key => $value)
                                    @if (!is_null($value->car))
                                    <tr>
                                        <td>{{ $value->sale_date }}</td>
                                        <td>{{ $value->purchase_date }}</td>
                                        <td>{{ $value->car->model_year }}</td>
                                        <td>{{ $value->car->model }} {{ $value->car->brand }}</td>
                                        <td>{{ $value->car->color }}</td>
                                        <td>{{ $value->car->number }}</td>
                                        @switch((int)$value->type_document)
                                            @case(1)
                                                <td>Factura</td>
                                                @break
                                            @case(3)
                                                <td>Boleta</td>
                                                @break
                                            @case(6)
                                                <td>Ley 30536 Boleta</td>
                                                @break
                                            @case(7)
                                                <td>Ley 30536 Factura</td>
                                                @break
                                            @case(8)
                                                <td>Persona natural</td>
                                                @break
                                            @default
                                                <td>Factura</td>
                                        @endswitch
                                        @php
                                            $totalUtility = $value->price_sale - $value->total_cost;
                                            $igv = 0;
                                            $rent = 0;
                                            if (!is_null($value->car) && !is_null($value->car->expenses)) {
                                                if (!is_null($value->car->expenses->expenses_json)) {
                                                    foreach ($value->car->expenses->expenses_json as $keyEJ => $valueEJ) {
                                                        if (isset($valueEJ['tag']) && $valueEJ['tag'] === "IGV") {
                                                            $igv = $valueEJ['value'];
                                                        } else {
                                                            if (isset($valueEJ['name']) && $valueEJ['name'] === "IGV")  {
                                                                $igv = $valueEJ['value'];
                                                            }
                                                        }
                                                        if (isset($valueEJ['tag']) && $valueEJ['tag'] === "RENT") {
                                                            $rent = $valueEJ['value'];
                                                        } else {
                                                            if (isset($valueEJ['name']) && $valueEJ['name'] === "RENTA 1.5%")  {
                                                                $rent = $valueEJ['value'];
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        <td>{{ number_format($value->price_sale) }}</td>
                                        <td>{{ number_format($value->total_cost) }}</td>
                                        <td>{{ number_format(($totalUtility)) }}</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>{{ number_format(($igv)) }}</td>
                                        <td>{{ number_format(($rent)) }}</td>
                                        <!-- <td>{{ (!is_null($value->car->createdBy)) ? $value->car->createdBy->name : '--' }} {{ (!is_null($value->car->createdBy)) ? $value->car->createdBy->lastname : '' }}</td> -->
                                        <td>{{ (!is_null($value->saledBy)) ? $value->saledBy->name : '--' }} {{ (!is_null($value->saledBy)) ? $value->saledBy->lastname : '' }}</td>
                                        <td>{{ (!is_null($value->postedBy)) ? $value->postedBy->name : '--' }} {{ (!is_null($value->postedBy)) ? $value->postedBy->lastname : '' }}</td>
                                        <td>--</td>
                                    </tr>
                                    @endif
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
            "extract-sale-date-pre": function(value) {
                if (value != "") {
                    date = value.split('/');
                    return Date.parse(date[1] + '/' + date[0] + '/' + date[2]);
                } else {
                    return "";
                }
            },
            "extract-sale-date-asc": function(a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            "extract-sale-date-desc": function(a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
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
        $('#saleListDataTable').DataTable({
            // paging: false
            "lengthChange": false,
            "language": {
                "url": "{{ asset('argon') }}/js/datatables.ES.json"
            },
            "dom": "Bfrtip",
            "buttons": [
                {
                    "extend": "excel",
                    "text": "Exportar datos a formato Excel (.xlsx)",
                    "class": "btn btn btn-success",
                    "footer": true
                }
            ],
            "columnDefs": [
                {
                    "targets": [3,4,5],
                    "className": 'dt-body-right'
                },
                {
                    "type": 'extract-sale-date',
                    "targets": [0]
                },
                {
                    "type": 'extract-purchase-date',
                    "targets": [1]
                }
            ],
        });
    });

    function filterByPeriod(element) {
        const urlPath = window.location.href;
        const url = new URL(urlPath);
        const search_ = '?period=' + element.value;
        const newUrl = url.protocol + '//' + url.hostname + url.pathname + search_;
        window.location.href = newUrl // Go to page2 url
    }
</script>
@endpush