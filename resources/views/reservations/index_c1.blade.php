@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.css"/>
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
                <div class="card-body">
                <br>
                    <div class="row">
                        <div class="col-md-12">
                            <h1 style="text-align: center;">CANCHA {{ Auth()->user()->cancha_id }}</h1>
                            <div id='calendar'></div>
                        </div>
                        <div class="col-md-12">
                            <div id='external-events-1' style="border: solid;
                                    border-color: #2e9e6e;
                                    border-radius: 5px;
                                    padding: 10px;">
                                <p>
                                    <strong>Cancha {{ Auth()->user()->cancha_id }}</strong>
                                </p>
                                <hr>
                                <div id="cancha_1_events">
                                </div>
                            </div>
                            <br>
                            <div id='external-events-2' style="border: solid;
                                    border-color: #5e72e4;
                                    border-radius: 5px;
                                    padding: 10px;">
                                <p>
                                    <strong>Cancha 2</strong>
                                </p>
                                <hr>
                                <div id="cancha_2_events">
                                </div>
                            </div>

                            <br>
                            <p>
                                <input type='checkbox' id='drop-remove' checked/>
                                <label for='drop-remove'>Remover eventos después de usar</label>
                            </p>
                            <br>
                            <button onclick="openNewEventModal();" class="btn btn-success">Nuevo Evento</button>
                        </div>
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
            <div class="modal-header">
                <h5 class="modal-title">{{ __('¿Desea agregar una nueva reserva?') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="">Cancha</label>
                <select class="form-control" id="cancha_select_id">
                    <option value="1">Cancha 1</option>
                    <option value="2">Cancha 2</option>
                </select>
                <br>
                <label for="">Cliente</label>
                <input type="text" class="form-control" id="cancha_name_id" placeholder="Ingrese nombre de la persona que reserva">
            
                <br>
                <label for="">Detalle</label>
                <input type="text" class="form-control" id="cancha_name_id" placeholder="Ingrese detalle de la reserva">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('VOLVER') }}</button>
                <button type="button" id="submitButton" onClick="newEvent();" class="btn btn-success">{{ __('AGREGAR RESERVA') }}</button>
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
<script>
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
    document.addEventListener('DOMContentLoaded', function() {
        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;

        var containerEl1 = document.getElementById('cancha_1_events');
        var containerEl2 = document.getElementById('cancha_2_events');
        var calendarEl = document.getElementById('calendar');
        var checkbox = document.getElementById('drop-remove');

        // initialize the external events
        // -----------------------------------------------------------------

        new Draggable(containerEl1, {
            itemSelector: '.fc-event',
            eventData: function(eventEl) {
                return {
                    title: eventEl.innerText,
                    color: '#2e9e6e',
                };
            }
        });

        new Draggable(containerEl2, {
            itemSelector: '.fc-event',
            eventData: function(eventEl) {
                return {
                    title: eventEl.innerText,
                    color: '#5e72e4',
                };
            }
        });

        // initialize the calendar
        // -----------------------------------------------------------------
        var calendar = new Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            selectable: true,
            selectHelper: true,
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function(info) {
            // is the "remove after drop" checkbox checked?
            if (checkbox.checked) {
                // if so, remove the element from the "Draggable Events" list
                info.draggedEl.parentNode.removeChild(info.draggedEl);
            }
            },
            select: function(start, end, allDay) {
                console.log(start, end, allDay);
                // alert('Clicked on: ' + date.format());
                // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                // alert('Current view: ' + view.name);
                // // change the day's background color just for fun
                $(this).css('background-color', 'red');
        
                //------------Llamando al modal de Bootstrap
                $("#newEventModal").modal();
                $('#submitButton').on('click',function(){
                    var mockEvent = {title: 'myNewEvent!', start, end};
                    $('#calendar').fullCalendar('renderEvent', mockEvent);
                    $('#submitButton').unbind('click');
                    $('#createEventModal').modal('hide');
                });
  		    }
        });
        calendar.setOption('locale', 'es');
        calendar.render();

        if (window.innerWidth <= 768 ) {
            calendar.changeView('timeGridDay');
        } else {
            calendar.changeView('timeGridWeek');
        }
    });

</script>
@endpush