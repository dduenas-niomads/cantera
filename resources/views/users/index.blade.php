@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('view_title_name')
Módulo de usuarios
@endsection

@section('nav-users')
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
                            <h3 class="mb-0">Listado de usuarios</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/users/create" class="btn btn btn-default">Nuevo usuario</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="userListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Nombres</th>
                                    <th scope="col" class="thTaxationMiddle">Apellidos</th>
                                    <th scope="col" class="thTaxationMiddle">Correo</th>
                                    <th scope="col" class="thTaxationMiddle">Teléfono</th>
                                    <th scope="col" class="thTaxationMiddle">Rol</th>
                                    <th scope="col" class="thTaxationMiddle">Estado</th>
                                    <th scope="col" class="thTaxationMiddle">Fecha registro</th>
                                    <th scope="col" class="thTaxationRight"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userList as $key => $value)
                                <tr>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->lastname }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->phone }}</td>
                                    <td>{{ ($value->role) ? $value->role->name : "--" }}</td>
                                    <td>{{ is_null($value->deleted_at) ? "HABILITADO" : "DESHABILITADO" }}</td>
                                    <td>{{ $value->created_at->format("d/m/Y H:i:s") }}</td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="/users/{{ $value->id }}/edit">Información general</a>
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
    $('#userListDataTable').DataTable({
        // paging: false
        "lengthChange": false,
        "language": {
            "url": "{{ asset('argon') }}/js/datatables.ES.json"
        },
        "columnDefs": [
            {
                "targets": [3,4,5],
                "className": 'dt-body-right'
            }
        ],
        'order': [[ 0, "desc" ]],
    });
</script>
@endpush