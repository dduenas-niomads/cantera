@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link rel="stylesheet" href="{{ asset('argon') }}/css/myCss.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/css/bs-stepper.min.css">
@endpush

@section('href_title_name')
/cars-salers
@endsection

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
			<input type="hidden" id="validateNumber" value="{{ $validation }}">
			<div class="card shadow" onscroll="validateNumber();">
				<div class="card-header border-0">
					<div class="row align-items-center">
						<div class="col-12">
							<h3 class="mb-0">Nuevo vehículo</h3>
						</div>
					</div>
				</div>
                <div class="col-12">
					@if (isset($message) && isset($messageClass))
						<div class="alert alert-{{ $messageClass }} alert-dismissible fade show" role="alert">
							<strong>Notificación:</strong> {{ $message }}
							<button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					@endif
                    <div class="row">
                        <div class="col-md-6">
                            <form method="get" action="{{ route('cars.create-new-salers') }}" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
											<input type="hidden" name="view" value="cars.create_new_salers">
                                            <input type="text" maxlength="20" name="taxation_code" id="input-taxation_code" 
                                                class="form-control" 
                                                placeholder="{{ __('Ingrese placa de vehículo') }}" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="submit" 
                                                class="btn btn-default">{{ __('Buscar vehículo') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
				<div class="col-12">
					<form method="post" action="{{ route('cars.store-salers') }}" 
						id="storeForm" autocomplete="off" enctype="multipart/form-data">
						@csrf
						@method('post')
						<div id="stepperDiv" class="bs-stepper">
							<div class="bs-stepper-header">
								<div class="step" data-target="#test-nl-1">
									<button type="button" class="btn step-trigger">
										<span class="bs-stepper-circle">1</span>
										<span class="bs-stepper-label">Datos principales</span>
									</button>
								</div>
								<div class="line"></div>
								<div class="step" data-target="#test-nl-2">
									<div class="btn step-trigger">
										<span class="bs-stepper-circle">2</span>
										<span class="bs-stepper-label">Titular y cliente</span>
									</div>
								</div>
								<div class="line"></div>
								<div class="step" data-target="#test-nl-3">
									<div class="btn step-trigger">
										<span class="bs-stepper-circle">3</span>
										<span class="bs-stepper-label">Datos del vehículo</span>
									</div>
								</div>
							</div>
							<div class="bs-stepper-content">
								<div id="test-nl-1" class="content">
									@include('cars.partials.form_create_info')
								</div>
								<div id="test-nl-2" class="content">
									@include('cars.partials.form_create_clients')
								</div>
								<div id="test-nl-3" class="content">
									@include('cars.partials.form_create_details')
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="card-footer py-4">
					<nav class="d-flex justify-content-end" aria-label="...">
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>

@include('layouts.modals.default')

@endsection

@push('js')
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.ES.js" charset="UTF-8"></script>
<script src="{{ asset('argon') }}/js/default.js"></script>
<script src="{{ asset('argon') }}/js/bs-stepper.min.js"></script>

<script>
	var stepper = new Stepper(document.querySelector('#stepperDiv'));
	function stepperValidation(goNext = true, validateForm = false, idObjectsToValidate = [], someFunction = function (){}) {
		var input_register_date = document.getElementById('input-register_date');
		if (input_register_date) {
			if (input_register_date.value != "") {
				if (goNext) {
					if (validateForm) {
						var validation = true;
						idObjectsToValidate.forEach(element => {
							var inpObj = document.getElementById(element);
							var divInpObj = document.getElementById('div_' + element);
							if (!inpObj.checkValidity()) {
								var message = document.getElementById('message_' + element);
								if (message != null) {
									message.remove();
								}
								inpObj.focus();
								b = document.createElement("DIV");
								b.setAttribute("id", "message_" + element);
								b.innerHTML += '<p style="font-size: 12px;">Este dato es <b>necesario para continuar</b>.</p>';
								divInpObj.appendChild(b);
								validation = false;
								return;
							}
						});
						if (validation) {
							stepper.next();					
						}
					} else {
						stepper.next();
					}
				} else {
					stepper.previous();
				}
				someFunction;
			} else {
				alert("Seleccione una FECHA DE INGRESO");
			}
		} else {
			alert("No existe FECHA DE INGRESO");
		}
	}
	function clientStepLogic() {
		// get holder id value
		var holderId = document.getElementById('purchase[holder_id]');
		var holderEmpty = true;
		if (holderId != null) {
			holderEmpty = isEmpty(holderId.value);
		}
		if (holderEmpty) {
			// holder vacio, sólo llenar nombre 
			document.getElementById('input-holder_names').value = 
				document.getElementById('input-holder').value;
			document.getElementById('input-holder_rz_social').value = 
				document.getElementById('input-holder').value;
		} else {
			// holder existe, llenar datos
		}
		// get owner id value
		var ownerId = document.getElementById('purchase[owner_id]');
		var ownerEmtpy = true;
		if (ownerId != null) {
			ownerEmtpy = isEmpty(ownerId.value);
		}
		if (ownerEmtpy) {
			// owner vacio, sólo llenar nombre 
			document.getElementById('input-owner_names').value = 
				document.getElementById('input-owner').value;
			document.getElementById('input-owner_rz_social').value = 
				document.getElementById('input-owner').value;
		} else {
			// owner existe, llenar datos
		}
	}
	document.addEventListener('scroll', function(e){
		validateNumber();
	}, true);

	function validateNumber() {
		var validateNumber = document.getElementById("validateNumber");
		if (validateNumber != null) {
			if (parseInt(validateNumber.value) == 0) {
				alert("Primero, busque la placa del vehículo para ver si puede continuar."); 
				window.scrollTo(0, 0);
			}
		}
	}
	var positionCount = 0;
    </script>
@endpush