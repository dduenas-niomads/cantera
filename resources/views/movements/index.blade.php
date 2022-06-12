@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('view_title_name')
Módulo de movimientos
@endsection

@section('nav-movements')
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
                            <h3 class="mb-0">Resumen de movimientos</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('movements.create') }}" class="btn btn btn-default">Nuevo movimiento</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="saleListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Fecha</th>
                                    <th scope="col" class="thTaxationMiddle">Tipo</th>
                                    <th scope="col" class="thTaxationMiddle">Documento</th>
                                    <th scope="col" class="thTaxationMiddle">Total movimiento</th>
                                    <th scope="col" class="thTaxationMiddle">Productos</th>
                                    <th scope="col" class="thTaxationRight"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $object)
                                <tr>
                                    <td>{{ $object->created_at }}</td>
                                    <td>{{ $object->type_movement_name }}</td>
                                    <td>{{ $object->ref_document }}</td>
                                    <td>{{ $object->total_amount }}</td>
                                    <td>
                                        @foreach ($object->items as $item)
                                        <ul>
                                            <li><b>Nombre:</b> {{ $item['name'] }}</li>
                                            <li><b>Código:</b> {{ $item['code'] }}</li>
                                            <li><b>Cantidad:</b> {{ $item['quantity'] }}</li>
                                            <li><b>Precio:</b> {{ $item['price'] }}</li>
                                        </ul>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="#">Anular movimiento</a>
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
    $(document).ready(function() {
        $('#saleListDataTable').DataTable({
            // paging: false
            "order": [[ 0, "desc" ]],
            "lengthChange": false,
            "language": {
                "url": "{{ asset('argon') }}/js/datatables.ES.json"
            }
        });
    });
</script>
@endpush