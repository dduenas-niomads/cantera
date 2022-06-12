@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
    <style>
        @media screen {
            #printSection {
                display: none;
            }
        }

        @media print {
            body * {
                visibility:hidden;
            }
            #printSection, #printSection * {
                visibility:visible;
            }
            #printSection {
                position:absolute;
                left:0;
                top:0;
            }
        }
    </style>
@endpush

@section('view_title_name')
Módulo de Reservas
@endsection

@section('nav-reservations')
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
                        $carSelected = Session::get('carSelected')? Session::get('carSelected') : 0;
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
                            <h3 class="mb-0">Resumen de Reservas</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="#" onclick="openCalendarView();" class="btn btn btn-secondary">Ver calendario</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="carListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Cod reserva</th>
                                    <th scope="col" class="thTaxationMiddle">Cancha</th>
                                    <th scope="col" class="thTaxationMiddle">Fecha</th>
                                    <th scope="col" class="thTaxationMiddle">Hora</th>
                                    <th scope="col" class="thTaxationMiddle">Cliente</th>
                                    <th scope="col" class="thTaxationMiddle">Adelanto</th>
                                    <th scope="col" class="thTaxationMiddle">Estado</th>
                                    <th scope="col" class="thTaxationMiddle">Acciones</th>
                                    <th scope="col" class="thTaxationRight"></th>
                                </tr>
                            </thead>
                            <tbody>
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

    <div class="modal fade"  id="newEventModal"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title">{{ __('¿Desea agregar una nueva reserva?') }}</h5>
                <br>
                <label for="">Cancha</label>
                <input type="hidden" class="form-control" id="reservation_cancha_id" value="{{ $user->cancha->id }}">
                <input type="text" class="form-control" value="{{ $user->cancha->name }}" readonly>
                <br>
                <label for="">Cliente</label>
                <div>
                    <div id="mainheaderClient">
                        <input type="hidden" class="form-control" id="reservation_client_id" value="">
                        <input type="text" maxlength="200" name="purchase[holder]" id="reservation_client" 
                            onkeyup="autocompleteAjaxForClient('mainheaderClient', 'reservation_client', 'holder', null, null, 'clients');"
                            class="form-control " 
                            placeholder="{{ __('Ingrese nombre de la persona que reserva') }}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Fecha</label>
                        <input type="date" class="form-control" id="reservation_date" placeholder="dd/mm/aaaa" maxlength="10">
                    </div>
                    <div class="col-md-6">
                        <label for="">Hora</label>
                        <input type="time" class="form-control timepicker"  twelvehour="true" id="reservation_hour" placeholder="hh:mm am/pm">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Tiempo</label>
                        <select id="reservation_time" class="form-control">
                            <option value="30">30 minutos</option>
                            <option value="45">45 minutos</option>
                            <option selected value="60">60 minutos</option>
                            <option value="90">90 minutos</option>
                            <option value="120">120 minutos</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">Adelanto</label>
                        <input type="text" class="form-control" id="reservation_payment" placeholder="Cantidad de adelanto">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('VOLVER') }}</button>
                <button type="button" id="submitButton" onClick="newReservation();" class="btn btn-success">{{ __('AGREGAR RESERVA') }}</button>
            </div>
            </div>
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
    var table = $('#carListDataTable').DataTable({
        "info": false,
        "scrollX": false,
        "ordering": true,
        "searching": true,
        "processing": true,
        "serverSide": true,
        "lengthChange": false,
        "bPaginate": true,
        "responsive": false,
        "language": {
            "url": "{{ asset('argon') }}/js/datatables.ES.json"
        },
        "order": [[ 0, "desc" ]],
        "ajax": function(data, callback, settings) {
            $.get('/api/reservations', {
                limit: data.length,
                offset: data.start,
                order: data.order,
                search: data.search
            }, function(res) {
                arrayProducts = [];
                res.data.forEach(element => {
                    arrayProducts[element.id] = element;
                });
                callback({
                    recordsTotal: res.total,
                    recordsFiltered: res.total,
                    data: res.data
                });
            });
        },
        "columns" : [
                {'data':   function (data) {
                    var id_ = data.id.toString();
                    return id_.padStart(6,'0');
                }},
                {'data':   function (data) {
                    return data.cancha_id;
                }},
                {'data':   function (data) {
                    return data.reservation_date;
                }},
                {'data':   function (data) {
                    return data.reservation_time;
                }},
                {'data':   function (data) {
                    return data.client_name;
                }},
                {'data':   function (data) {
                    return data.payment;
                }},
                {'data':   function (data) {
                    switch (data.flag_active) {
                        case 1:
                            message = "ACTIVO";
                            break;
                        case 2:
                            message = "COBRADO";
                            break;
                        case 0:
                            message = "ELIMINADO";
                            break;
                        default:
                            message = "ACTIVO";
                            break;
                    }
                    return message;
                }},
                {'data':   function (data) {
                    switch (data.flag_active) {
                        case 1:
                            message = "<a class='btn btn-sm btn-success' href='/sales/create?reservation_code="+ data.id +"'>COBRAR</a>";
                            break;
                        case 2:
                            message = "<button class='btn btn-sm btn-info'>VER DOCUMENTO</button>";
                            break;
                        case 0:
                            message = "ELIMINADO";
                            break;
                        default:
                            message = "ACTIVO";
                            break;
                    }
                    return message;
                }},
                {'data':   function (data) {
                    return '<div class="dropdown">' +
                            '<a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                '<i class="fas fa-ellipsis-v"></i>' +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">' +
                                '<a class="dropdown-item" href="#">Repetir reserva</a>' +
                                '<a class="dropdown-item" href="#">Ver histórico de cliente</a>' +
                                '<a class="dropdown-item" href="#" onclick="deleteTax(' + data.id + ');">Eliminar reserva</a>' +
                            '</div>' +
                        '</div>';
                }, "orderable": false},
            ],
        });

    function deleteTax(taxId) {
        var confirm = false;
        var confirm = window.confirm("¿Está seguro de eliminar el RUC?");
        if (confirm) {
            $.ajax('/api/taxes/destroy/' + taxId, {
                type: 'DELETE',  // http method
                data: {},  // data to submit
                success: function (data, status, xhr) {
                    alert("RUC eliminado correctamente.");
                    table.ajax.reload();
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    alert("Hubo un error al eliminar el RUC.");
                }
            });
        }
    }

    function openCalendarView() {
        window.location.replace("/reservations-calendar");        
    }

    function openNewReservationModal() {
        $('#newEventModal').modal();
    }
    
    function newReservation() {
        // get data
            var reservation = {
                "reservation_cancha_id" : document.getElementById('reservation_cancha_id').value,
                "reservation_client" : document.getElementById('reservation_client').value,
                "reservation_client_id" : document.getElementById('reservation_client_id').value,
                "reservation_date" : document.getElementById('reservation_date').value,
                "reservation_hour" : document.getElementById('reservation_hour').value,
                "reservation_time" : document.getElementById('reservation_time').value,
                "reservation_payment" : document.getElementById('reservation_payment').value,
            };
        // send reservation
            $.post("/api/reservations", reservation,
                function(data, status){
                    alert(data.message);
                    // refresh datatable
                        table.ajax.reload();
                });
        // clear data
            document.getElementById('reservation_client').value = "";
            document.getElementById('reservation_client_id').value = null;
            document.getElementById('reservation_date').value = ""
            document.getElementById('reservation_hour').value = "";
            document.getElementById('reservation_time').value = "60";
            document.getElementById('reservation_payment').value = "";
        // send data
            console.log(reservation);
        // hide modal
            $('#newEventModal').modal('hide');
    }

</script>
@endpush