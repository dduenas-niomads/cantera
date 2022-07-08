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
Módulo de reservas
@endsection

@section('nav-reservations')
active
@endsection

@section('content')

@include('layouts.headers.empty')

<style>

    .cancha_1 {
        background-color: #2e9e6e; color: white;
        padding: 1px;
        border-radius: 3px; 
    }

    .cancha_2 {
        background-color: #5e72e4; color: white;
        padding: 1px;
        border-radius: 3px;
    }

</style>

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
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
                            <h3 class="mb-0">Gestión de reservas</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="#" onclick="openNewReservationModal();" class="btn btn btn-default">Nueva Reserva</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id='calendar'></div>
                </div>
            </div>
            <br>
        </div>
    </div>

    <div class="modal fade"  id="newEventModal"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Nueva reserva para {{ $user->cancha->name }}</h2>
                    <input type="hidden" id="reservation_cancha_id" value="{{ $user->cancha->id }}">
                </div>
                <div class="modal-body">
                    <label for="">Cliente</label>
                    <div>
                        <div id="mainheaderClient">
                            <input type="hidden" id="reservation_client_id" value="">
                            <input type="text" maxlength="200" name="purchase[holder]" id="reservation_client" 
                                onkeyup="autocompleteAjaxForClient('mainheaderClient', 'reservation_client', 'holder', null, null, 'clients');"
                                class="form-control form-control-sm" 
                                placeholder="{{ __('Ingrese nombre de la persona que reserva.') }}"
                                autocomplete="off">
                        </div>
                    </div>
                    <br>
                    <label for="">Ingresa la fecha</label>
                    <input placeholder="dd/mm/aaaa" type="date" class="form-control form-control-sm" id="reservation_date" maxlength="10">
                    <br>
                    <label for="">Ingresa la hora</label>
                    <div class="row">
                        <div class="col-md-4 col-4">
                            <select class="form-control form-control-sm" id="reservation_hour_hh">
                                <option value="">Hora</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-4">
                            <select class="form-control form-control-sm" id="reservation_hour_mm">
                                <option value="">Minuto</option>
                                <option value="0">00</option>
                                <option value="15">15</option>
                                <option value="30">30</option>
                                <option value="45">45</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-4">
                            <select class="form-control form-control-sm" id="reservation_hour_ampm">
                                <option value="PM">p.m.</option>
                                <option value="AM">a.m.</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <label for="">Tiempo de reserva</label>
                    <select id="reservation_time" class="form-control form-control-sm">
                        <option selected value="60">60 minutos</option>
                        <option value="90">90 minutos</option>
                        <option value="120">120 minutos</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" onClick="refreshModalData();">{{ __('VOLVER') }}</button>
                    <button type="button" id="submitButton" onClick="newReservation();" class="btn btn-success btn-sm">{{ __('CREAR RESERVA') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade"  id="infoEventModal"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="info_modal_code">Reserva:</h2>
                </div>
                <div class="modal-body">
                    <label for="">Cliente</label>
                    <input type="text" class="form-control form-control-sm" id="info_modal_client_name" readonly>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <label for="">Fecha de inicio</label>
                            <input type="text" class="form-control form-control-sm" id="info_modal_date_start" readonly>
                        </div>
                        <div class="col-md-6 col-6">
                            <label for="">Fecha de fin</label>
                            <input type="text" class="form-control form-control-sm" id="info_modal_date_end" readonly>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <label for="">Tiempo total</label>
                            <input type="text" class="form-control form-control-sm" id="info_modal_reservation_time" readonly>
                        </div>
                        <div class="col-md-6 col-6">
                            <label for="">Minutos extra</label>
                            <input type="text" class="form-control form-control-sm" id="info_modal_reservation_additional_time" readonly>
                        </div>
                    </div>
                    <br>
                    <label for="">Adelantos</label>
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <input type="text" class="form-control form-control-sm" id="info_modal_payment" readonly>
                        </div>
                        <div class="col-md-6 col-6">
                            <button type="button" class="btn btn-success btn-sm" onClick="goToSale();">{{ __('Hacer pago') }}</button>
                        </div>
                    </div>
                    <br>
                    <label for="">Estado de la reserva</label>
                    <select id="info_modal_reservation_flag_active" class="form-control form-control-sm" disabled readonly>
                        <option value="0">ANULADO</option>
                        <option value="1">ACTIVO</option>
                        <option value="2">PAGADO</option>
                    </select>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary btn-sm" onClick="refreshInfoModal();">{{ __('VOLVER') }}</button>
                    <button type="button" class="btn btn-success btn-sm" onClick="paymentsModal();">{{ __('VER PAGOS') }}</button>
                    <button type="button" class="btn btn-default btn-sm" onClick="optionsModal();">{{ __('MODIFICAR') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="salesModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="sales_modal_code">Ventas de la reserva:</h2>
                </div>
                <div class="modal-body" style="height: 250px; overflow-y: auto;">
                    <table class="table table-sm table-striped table-responsive" style="width: 100%;">
                        <thead class="thead-dark">
                            <th>Información de venta</th>
                            <th>Productos vendidos</th>
                        </thead>
                        <tbody id="tbodySalesModal"></tbody>
                    </table>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary btn-sm" onClick="refreshSalesModal();">{{ __('VOLVER') }}</button>
                    <button type="button" class="btn btn-success btn-sm" onClick="goToSale();">{{ __('HACER PAGO') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade"  id="optionsEventModal"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="options_modal_code">Reserva:</h2>
                </div>
                <div class="modal-body">
                    <label for="">Cliente</label>
                    <input type="text" class="form-control form-control-sm" id="options_modal_client_name" readonly>
                    <br>
                    <label for="">Fecha de reserva</label>
                    <input placeholder="dd/mm/aaaa" type="date" class="form-control form-control-sm" id="options_modal_reservation_date" maxlength="10">
                    <br>
                    <label for="">Hora de reserva</label>
                    <div class="row">
                        <div class="col-md-4 col-4">
                            <select class="form-control form-control-sm" id="options_modal_reservation_hour_hh">
                                <option value="">Hora</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-4">
                            <select class="form-control form-control-sm" id="options_modal_reservation_hour_mm">
                                <option value="">Minuto</option>
                                <option value="0">00</option>
                                <option value="15">15</option>
                                <option value="30">30</option>
                                <option value="45">45</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-4">
                            <select class="form-control form-control-sm" id="options_modal_reservation_hour_ampm">
                                <option value="PM">p.m.</option>
                                <option value="AM">a.m.</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <label for="">Tiempo total</label>
                            <select id="options_modal_reservation_time" class="form-control form-control-sm">
                                <option selected value="60">60 minutos</option>
                                <option value="90">90 minutos</option>
                                <option value="120">120 minutos</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-6">
                            <label for="">Minutos extra</label>
                            <input type="number" id="options_modal_reservation_additional_time" class="form-control form-control-sm" value="0">
                        </div>
                    </div>
                    <br>
                    <label for="">Repetir reserva</label>
                    <select id="options_modal_reservation_repeat" class="form-control form-control-sm">
                        <option value="0">Única vez</option>
                        <option value="1">Repetir una vez</option>
                        <option value="2">Repetir resto del mes</option>
                        <option value="3">Repetir resto del año</option>
                    </select>
                    <br>
                    <label for="">En caso de Anulación:</label>
                    <select id="options_modal_reservation_destroy" class="form-control form-control-sm">
                        <option value="0">Seleccione una opción</option>
                        <option value="1">Anular sólo esta reserva</option>
                        <option value="2">Anular todas las reservas</option>
                    </select>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary btn-sm" onClick="refreshOptionsModal();">{{ __('VOLVER') }}</button>
                    <button type="button" class="btn btn-success btn-sm" id="submitButtonOptions" onClick="saveOptionsModal();">{{ __('REPROGRAMAR') }}</button>
                    <button type="button" class="btn btn-danger btn-sm" id="options_modal_destroy_button" onClick="destroyReservation();">{{ __('ANULAR') }}</button>
                </div>
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

<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/locales-all.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.css"/>
<script>
    var reservation = null;

    function openNewEventModal() {
        $('#newEventModal').modal();
    }

    function newEvent() {
        var cancha_select_id = document.getElementById('cancha_select_id');
        if (cancha_select_id) {
            if (parseInt(cancha_select_id.value) == 1) {
                var cancha_1_events = document.getElementById('cancha_1_events');
                if (cancha_1_events) {
                    var div_ = document.createElement("div");
                    var br_ = document.createElement("br");
                    div_.classList.add('fc-event');
                    div_.classList.add('cancha_1');
                    
                    var divText_ = document.createElement("div");
                    divText_.classList.add('fc-event-main');
                    
                    var text_ = document.createTextNode(document.getElementById('cancha_name_id').value);
                    
                    divText_.appendChild(text_);
                    div_.appendChild(divText_);
                    cancha_1_events.appendChild(br_);
                    cancha_1_events.appendChild(div_);
                }
            } else {
                var cancha_2_events = document.getElementById('cancha_2_events');
                if (cancha_2_events) {
                    var div_ = document.createElement("div");
                    var br_ = document.createElement("br");
                    div_.classList.add('fc-event');
                    div_.classList.add('cancha_2');
                    
                    var divText_ = document.createElement("div");
                    divText_.classList.add('fc-event-main');
                    
                    var text_ = document.createTextNode(document.getElementById('cancha_name_id').value);
                    
                    divText_.appendChild(text_);
                    div_.appendChild(divText_);
                    cancha_2_events.appendChild(br_);
                    cancha_2_events.appendChild(div_);
                }
            }
            document.getElementById('cancha_name_id').value = "";
            $('#newEventModal').modal('hide');
        }
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
                "reservation_hour_hh" : document.getElementById('reservation_hour_hh').value,
                "reservation_hour_mm" : document.getElementById('reservation_hour_mm').value,
                "reservation_hour_ampm" : document.getElementById('reservation_hour_ampm').value,
                "reservation_time" : document.getElementById('reservation_time').value,
            };
        // validate data
            if (reservation.reservation_client == "") {
                alert("Debe ingresar el nombre de la persona que reserva.");
                document.getElementById('reservation_client').style.borderColor = "red";
                return;
            }
            if (reservation.reservation_date == "") {
                alert("Debe ingresar una fecha para la reserva.");
                document.getElementById('reservation_date').style.borderColor = "red";
                return;
            }
            if (reservation.reservation_hour_hh == "") {
                alert("Debe seleccionar la hora de la reserva.");
                document.getElementById('reservation_hour_hh').style.borderColor = "red";
                return;
            }
            if (reservation.reservation_hour_mm == "") {
                alert("Debe seleccionar el minuto de la reserva.");
                document.getElementById('reservation_hour_mm').style.borderColor = "red";
                return;
            }
        // send reservation
            document.getElementById('submitButton').disabled = true;
            document.getElementById('submitButton').innerHTML = "Procesando...";
            $.post("/api/reservations", reservation, function(data, status){
                alert(data.message);
                refreshModalData();
                calendar.refetchEvents();
            }).fail(function(data, status) {
                alert(data.responseJSON.message);
                document.getElementById('submitButton').disabled = false;
                document.getElementById('submitButton').innerHTML = "CREAR RESERVA";
                // refreshModalData();
            });
    }

    function refreshModalData() {
        // data
        document.getElementById('reservation_client').value = "";
        document.getElementById('reservation_client_id').value = null;
        document.getElementById('reservation_date').value = ""
        document.getElementById('reservation_hour_hh').value = "";
        document.getElementById('reservation_hour_mm').value = "";
        document.getElementById('reservation_hour_ampm').value = "pm";
        document.getElementById('reservation_time').value = "60";
        // borders
        document.getElementById('reservation_client').style.borderColor = "#cad1d7";
        document.getElementById('reservation_date').style.borderColor = "#cad1d7";
        document.getElementById('reservation_hour_hh').style.borderColor = "#cad1d7";
        document.getElementById('reservation_hour_mm').style.borderColor = "#cad1d7";
        // button
        document.getElementById('submitButton').disabled = false;
        document.getElementById('submitButton').innerHTML = "CREAR RESERVA";
        // close modal
        $('#newEventModal').modal('hide');
    }

    function refreshSalesModal() {
        $('#salesModal').modal('hide');
    }

    function refreshInfoModal(reservationOptions = true) {
        if (reservationOptions) {
            reservation = null;
        }
        document.getElementById('info_modal_code').innerHTML = "Reserva: ";
        document.getElementById('info_modal_client_name').value = "";
        document.getElementById('info_modal_date_start').value = "";
        document.getElementById('info_modal_date_end').value = "";
        document.getElementById('info_modal_reservation_time').value = "";
        document.getElementById('info_modal_reservation_additional_time').value = "0";
        document.getElementById('info_modal_payment').value = "";
        document.getElementById('info_modal_reservation_flag_active').value = 1;
        $('#infoEventModal').modal('hide');
    }

    function optionsModal() {
        refreshInfoModal(false);
        var codeString = reservation.id.toString();
        document.getElementById('options_modal_code').innerHTML = "Reserva: " + codeString.padStart(6, "0");
        document.getElementById('options_modal_client_name').value = reservation.client_name;
        document.getElementById('options_modal_reservation_additional_time').value = reservation.additional_time;
        document.getElementById('options_modal_reservation_date').value = reservation.reservation_date;
        document.getElementById('options_modal_reservation_hour_hh').value = reservation.reservation_hour_hh;
        document.getElementById('options_modal_reservation_hour_mm').value = reservation.reservation_hour_mm;
        document.getElementById('options_modal_reservation_hour_ampm').value = reservation.reservation_hour_ampm;
        document.getElementById('options_modal_reservation_time').value = reservation.reservation_time;
        document.getElementById('options_modal_reservation_repeat').value = 0;
        document.getElementById('options_modal_reservation_destroy').value = 0;
        
        $('#optionsEventModal').modal();
    }

    function saveOptionsModal() {
        // get data
            var reservation_update = {
                "id" : reservation.id,
                "additional_time": document.getElementById('options_modal_reservation_additional_time').value,
                "reservation_date" : document.getElementById('options_modal_reservation_date').value,
                "reservation_hour_hh" : document.getElementById('options_modal_reservation_hour_hh').value,
                "reservation_hour_mm" : document.getElementById('options_modal_reservation_hour_mm').value,
                "reservation_hour_ampm" : document.getElementById('options_modal_reservation_hour_ampm').value,
                "reservation_time" : document.getElementById('options_modal_reservation_time').value,
                "repeat" : document.getElementById('options_modal_reservation_repeat').value
            };
        // validate data
            if (reservation_update.reservation_date == "") {
                alert("Debe ingresar una fecha para la reserva.");
                document.getElementById('options_modal_reservation_date').style.borderColor = "red";
                return;
            }
            if (reservation_update.reservation_hour_hh == "") {
                alert("Debe seleccionar la hora de la reserva.");
                document.getElementById('options_modal_reservation_hour_hh').style.borderColor = "red";
                return;
            }
            if (reservation_update.reservation_hour_mm == "") {
                alert("Debe seleccionar el minuto de la reserva.");
                document.getElementById('options_modal_reservation_hour_mm').style.borderColor = "red";
                return;
            }
        // send reservation
            document.getElementById('submitButtonOptions').disabled = true;
            document.getElementById('submitButtonOptions').innerHTML = "Procesando...";
            $.ajax({
                url: "/api/reservations/" + reservation_update.id,
                data: reservation_update,
                type: 'PUT',
                success: function(result) {
                    alert(result.message);
                    refreshOptionsModal();
                    calendar.refetchEvents();
                },
                error: function(result, status) {
                    alert(result.responseJSON.message);
                    document.getElementById('submitButtonOptions').disabled = false;
                    document.getElementById('submitButtonOptions').innerHTML = "REPROGRAMAR";
                }
            });
    }

    function refreshOptionsModal() {
        reservation = null;
        document.getElementById('options_modal_code').innerHTML = "Reserva: ";
        document.getElementById('options_modal_client_name').value = "";
        document.getElementById('options_modal_reservation_additional_time').value = "";
        document.getElementById('options_modal_reservation_date').value = "";
        document.getElementById('options_modal_reservation_hour_hh').value = "";
        document.getElementById('options_modal_reservation_hour_mm').value = "";
        document.getElementById('options_modal_reservation_hour_ampm').value = "";
        document.getElementById('options_modal_reservation_time').value = "";
        document.getElementById('options_modal_reservation_repeat').value = 0;
        document.getElementById('options_modal_reservation_destroy').value = 0;
        document.getElementById('submitButtonOptions').disabled = false;
        document.getElementById('submitButtonOptions').innerHTML = "REPROGRAMAR";
        document.getElementById('options_modal_destroy_button').innerHTML = "ANULAR";
        document.getElementById('options_modal_destroy_button').disabled = false;
        $('#optionsEventModal').modal('hide');
    }

    function goToSale() {
        window.location.replace("/sales/create?reservation_code=" + reservation.id);
    }

    function paymentsModal() {
        refreshInfoModal(false);
        $('#salesModal').modal();
        var codeString = reservation.id.toString();
        document.getElementById('sales_modal_code').innerHTML = "Ventas de la reserva: " + codeString.padStart(6, "0");        
        $.ajax({
            url: "/api/sales-by-reservation-id/" + reservation.id,
            type: 'GET',
            success: function(result) {
                printReservationSales(result.result);
            },
            error: function(result, status) {
                alert(result.responseJSON.message);
            }
        });
    }

    function printReservationSales(sales_ = []) {
        var tbodySalesModal = document.getElementById('tbodySalesModal');
        if (tbodySalesModal) {
            tbodySalesModal.innerHTML = "";
			sales_.forEach(item => {
                ulProducts = '';
                items_ = item.items;
                count_ = 1;
                items_.forEach(element => {
                    ulProducts += '<ul class="simple_ul"><li><b>N°: </b>' + count_ + '</li>' +
                        '<li><b>Código: </b>' + element.code + '</li>' +
                        '<li><b>Nombre: </b>' + element.name + '</li>' +
                        '<li><b>Cantidad: </b>' + element.quantity + '</li>' +
                        '<li><b>Precio: </b>' + element.price + '</li></ul><br>';
                    count_++;
                });
                url_ = "";
                if (item.fe_url_pdf) {
                    url_ = '<a target="_blank" href="'+ item.fe_url_pdf +'">Abrir documento</a>';
                }
                var statusName = "Ok";
                if (parseInt(item.flag_active) == 0) {
                    statusName = "Anulado";
                }
                codString = item.correlative.toString();
                ulDocument = '<ul class="simple_ul"><li><b>Ruc: </b>' + item.document.document_number + '</li>' +
                    '<li><b>Doc: </b>' + item.serie + '-' + codString.padStart(6, "0") + '</li>' +
                    '<li><b>Tipo: </b>' + item.type_document + '</li>' +
                    '<li><b>Total: </b>S/ ' + (parseFloat(item.total_amount)).toFixed(2) + '</li>' +
                    '<li><b>Fecha: </b>' + item.created_at + '</li>' +
                    '<li><b>Estado: </b>' + statusName + '</li>' +
                    '<li><b>' + url_ + '</b></li></ul>';
				b = document.createElement("TR");
				b.innerHTML += '<td>' + ulDocument + '</td>' +
					'<td>' + ulProducts + '</td>'; 
                tbodySalesModal.appendChild(b);
			});
        }
    }

    function destroyReservation() {
        var confirm = window.confirm("¿Está seguro de anular esta reserva?");
        if (confirm) {
            var reservationOption = document.getElementById('options_modal_reservation_destroy');
            if (reservationOption) {
                reservationOption = reservationOption.value;
            } else {
                reservationOption = 0;
            }
            document.getElementById('options_modal_destroy_button').disabled = true;
            document.getElementById('options_modal_destroy_button').innerHTML = "Procesando...";
            $.get("/api/reservations-destroy/" + reservation.id + "?reservation_option=" + reservationOption, function(data, status) {
                alert(data.message);
                refreshOptionsModal();
                calendar.refetchEvents();
            }).fail(function(data, status) {
                alert(data.responseJSON.message);
                refreshOptionsModal();
            });
        }
    }

    function openInfoEventModal(infoParams) {
        if (infoParams.object) {
            reservation = infoParams.object;
            console.log(reservation);
            var dateStart = new Date(reservation.reservation_date_start_iso);
            var dateEnd = new Date(reservation.reservation_date_end_iso);
            var codeString = reservation.id.toString();
            document.getElementById('info_modal_code').innerHTML = "Reserva: " + codeString.padStart(6, "0");
            document.getElementById('info_modal_client_name').value = reservation.client_name;
            document.getElementById('info_modal_date_start').value = localeDatePeru(dateStart);
            document.getElementById('info_modal_date_end').value = localeDatePeru(dateEnd);
            document.getElementById('info_modal_reservation_time').value = reservation.reservation_time + " minutos";
            document.getElementById('info_modal_reservation_additional_time').value = reservation.additional_time + " minutos";
            if (reservation.payment) {
                document.getElementById('info_modal_payment').value = "S/ "+ reservation.payment;
            } else {
                document.getElementById('info_modal_payment').value = "Sin adelantos";
            }
            document.getElementById('info_modal_reservation_flag_active').value = reservation.flag_active;            
        }
        $('#infoEventModal').modal();
    }

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;
    var calendarEl = document.getElementById('calendar');
    // initialize the calendar
    // -----------------------------------------------------------------
    var calendar = new Calendar(calendarEl, {
        events: '/api/reservations-as-events',
        initialView: 'list',
        allDaySlot: false,
        height: 500,
        footerToolbar: {
            left: 'prev,next',
            center: '',
            right: 'timeGridWeek,timeGridDay,list'
        },
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: ''
        },
      titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' },
        eventClick: function(info) {
            if (info.event.extendedProps) {
                openInfoEventModal(info.event.extendedProps);
            }
        }
    });
    calendar.setOption('locale', 'es');
    calendar.render();

</script>
@endpush