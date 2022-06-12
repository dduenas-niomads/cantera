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
@section('nav-reports-cars')
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
                        <div class="col-12">
                            <h3 class="mb-0">Reporte de stock de vehículos</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="myTable align-items-center table-bordered table-hover table-sm table-striped" id="saleListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Marca</th>
                                    <th scope="col" class="thTaxationMiddle">Modelo</th>
                                    <th scope="col" class="thTaxationMiddle">Año fab</th>
                                    <th scope="col" class="thTaxationMiddle">Año modelo</th>
                                    <th scope="col" class="thTaxationMiddle">Motor</th>
                                    <th scope="col" class="thTaxationMiddle">Potencia (hp)</th>
                                    <th scope="col" class="thTaxationMiddle">Combustible</th>
                                    <th scope="col" class="thTaxationMiddle">Transmisión</th>
                                    <th scope="col" class="thTaxationMiddle">Color</th>
                                    <th scope="col" class="thTaxationMiddle">Kilometraje</th>
                                    <th scope="col" class="thTaxationMiddle">Placa</th>
                                    <th scope="col" class="thTaxationMiddle">Precio venta</th>
                                    <th scope="col" class="thTaxationMiddle">Precio compra</th>
                                    <th scope="col" class="thTaxationMiddle">Total gastos</th>
                                    <th scope="col" class="thTaxationMiddle">Costo total</th>
                                    <th scope="col" class="thTaxationMiddle">Utilidad</th>
                                    <th scope="col" class="thTaxationMiddle">Máximo facturable</th>
                                    <th scope="col" class="thTaxationMiddle">Fecha compra</th>
                                    <th scope="col" class="thTaxationRight">Firma</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carList as $key => $value)
                                    @include('layouts.utils.car_list_utility')
                                    <tr>
                                        <td>{{ $value->brand }}</td>
                                        <td>{{ $value->model }}</td>
                                        <td>{{ $value->fab_year }}</td>
                                        <td>{{ $value->fab_model }}</td>
                                        <td>{{ isset($value->details) ? $value->details->cc : '--' }}</td>
                                        <td>{{ isset($value->details) ? $value->details->hp : '--' }}</td>
                                        <td>{{ isset($value->details) ? $value->details->fuel : '--' }}</td>
                                        <td>{{ isset($value->details) ? $value->details->transmition : '--' }}</td>
                                        <td>{{ $value->color }}</td>
                                        <td>{{ isset($value->details) ? number_format($value->details->kilometers) : '--' }}</td>
                                        <td>{{ $value->number }}</td>
                                        <td>{{ ($value->price_sale) ? number_format($value->price_sale) : number_format(0) }}</td>
                                        <td>{{ ($value->price_compra) ? number_format($value->price_compra) : number_format(0) }}</td>
                                        <td>{{ number_format($value->totalExpensesAmount) }}</td>
                                        <td>{{ number_format((float)$value->price_compra + $value->totalExpensesAmount) }}</td>
                                        <td>{{ number_format($value->totalUtility) }}</td>
                                        <td>{{ number_format($value->max_invoiced) }}</td>
                                        <td>{{ (!is_null($value->actualPurchase)) ? $value->actualPurchase->register_date : 'Sin compra' }}</td>
                                        <td>{{ ($value->type_sign_name) ? $value->type_sign_name : '--' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    @for ($i=0; $i < 19 ; $i++)
                                        <th></th>
                                    @endfor
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
        "order": [[ 1, "asc" ]],
        "ordering": true,
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Totals

            // precio venta
            total11 = api
                .column( 11 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // format
            total11 = (total11).toLocaleString('en-US', {
                style: 'currency',
                minimumFractionDigits: 0,
                currency: 'USD',
            });
            // Update footer
            $( api.column( 11 ).footer() ).html(
                '<b>' + total11 + '</b>'
            );

            // precio compra
            total12 = api
                .column( 12 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // format
            total12 = (total12).toLocaleString('en-US', {
                style: 'currency',
                minimumFractionDigits: 0,
                currency: 'USD',
            });
            // Update footer
            $( api.column( 12 ).footer() ).html(
                '<b>' + total12 + '</b>'
            );

            // total gastos
            total13 = api
                .column( 13 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // format
            total13 = (total13).toLocaleString('en-US', {
                style: 'currency',
                minimumFractionDigits: 0,
                currency: 'USD',
            });
            // Update footer
            $( api.column( 13 ).footer() ).html(
                '<b>' + total13 + '</b>'
            );

            // costo total
            total14 = api
                .column( 14 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // format
            total14 = (total14).toLocaleString('en-US', {
                style: 'currency',
                minimumFractionDigits: 0,
                currency: 'USD',
            });
            // Update footer
            $( api.column( 14 ).footer() ).html(
                '<b>' + total14 + '</b>'
            );

            // // comision
            // total15 = api
            //     .column( 15 )
            //     .data()
            //     .reduce( function (a, b) {
            //         return intVal(a) + intVal(b);
            //     }, 0 );
            // // format
            // total15 = (total15).toLocaleString('en-US', {
            //     style: 'currency',
            //     minimumFractionDigits: 0,
            //     currency: 'USD',
            // });
            // // Update footer
            // $( api.column( 15 ).footer() ).html(
            //     '<b>' + total15 + '</b>'
            // );

            // utilidad
            total15 = api
                .column( 15 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // format
            total15 = (total15).toLocaleString('en-US', {
                style: 'currency',
                minimumFractionDigits: 0,
                currency: 'USD',
            });
            // Update footer
            $( api.column( 15 ).footer() ).html(
                '<b>' + total15 + '</b>'
            );

            // maximo facturable
            total16 = api
                .column( 16 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // format
            total16 = (total16).toLocaleString('en-US', {
                style: 'currency',
                minimumFractionDigits: 0,
                currency: 'USD',
            });
            // Update footer
            $( api.column( 16 ).footer() ).html(
                '<b>' + total16 + '</b>'
            );
        }
    });
</script>
@endpush