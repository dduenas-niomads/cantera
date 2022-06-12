@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link rel="stylesheet" href="{{ asset('argon') }}/css/myCss.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/css/bs-stepper.min.css">
@endpush

@section('href_title_name')
/purchases
@endsection

@section('view_title_name')
Módulo de compras
@endsection

@section('nav-purchases')
active
@endsection

@section('content')

@include('layouts.headers.empty')

<div class="container-fluid mt--6">
	<div class="row">
		<div class="col">
			<div class="card shadow">
				<div class="card-header border-0">
					<div class="row align-items-center">
						<div class="col-12">
							<h3 class="mb-0">Editar compra de vehículo</h3>
						</div>
					</div>
				</div>
				<div class="col-12">
					<form method="post" action="{{ route('purchases.update', $purchase->id) }}" 
						id="storeForm" autocomplete="off" enctype="multipart/form-data">
						@csrf
						@method('put')
						<div id="stepperDiv" class="bs-stepper">
							<div class="bs-stepper-header">
								<div class="step" data-target="#test-nl-1">
									<button type="button" class="btn step-trigger">
										<span class="bs-stepper-circle">1</span>
										<span class="bs-stepper-label">Datos de compra</span>
									</button>
								</div>
							</div>
							<div class="bs-stepper-content">
								<div id="test-nl-1" class="content">
									@include('purchases.partials.form_edit_purchase')
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
	// function updateRentValue(element) {
	// 	var labelExpensesRentAmount = document.getElementById("label-expenses_rent_amount");
	// 	var inputExpensesRentAmount = document.getElementById("input-expenses_rent_amount");
	// 	if (labelExpensesRentAmount != null && inputExpensesRentAmount != null) {
	// 		if (element.value) {
	// 			labelExpensesRentAmount.innerHTML = 'RENTA (SOBRE ' + (parseFloat(element.value) + 1000).toFixed(0) + ' USD)';
	// 			inputExpensesRentAmount.value = ((parseFloat(element.value) + 1000)*0.015).toFixed(0)
	// 		} else {
	// 			labelExpensesRentAmount.innerHTML = 'RENTA (SOBRE 0.00 USD)';
	// 			inputExpensesRentAmount.value = 0.00;
	// 		}
	// 	}
	// }

	function updateTaxesValues(element) {
		// rent
		var inputExpensesRentAmount = document.getElementById("input-expenses_rent_amount");
		var inputExpensesRentDetail = document.getElementById("input-expenses_rent_detail");
		// igv
		var inputExpensesIGVAmount = document.getElementById("input-expenses_igv_amount");
		var inputExpensesIGVDetail = document.getElementById("input-expenses_igv_detail");
		if (inputExpensesRentDetail != null && inputExpensesRentAmount != null
			&& inputExpensesIGVAmount != null && inputExpensesIGVDetail != null) {
			if (element.value) {
				// renta
				inputExpensesRentDetail.value = (parseFloat(element.value) + 1000).toFixed(0);
				inputExpensesRentAmount.value = ((parseFloat(element.value) + 1000)*0.015).toFixed(0)
				// igv
				var igvAmount = 1000;
				var elementValue = parseFloat(element.value);
				if (elementValue > 0 && elementValue <= 5000) {
					igvAmount = 500;
				} else if (elementValue > 5000 && elementValue <= 25000) {
					igvAmount = 1000;
				} else {
					igvAmount = 2000;
				}
				inputExpensesIGVAmount.value = (igvAmount - igvAmount/1.18).toFixed(0)
				inputExpensesIGVDetail.value = (igvAmount).toFixed(0)
			} else {
				// renta
				inputExpensesRentDetail.value = 0.00;
				inputExpensesRentAmount.value = 0.00;
				// igv
				inputExpensesIGVAmount.value = (0).toFixed(0);
				inputExpensesIGVDetail.value = (0).toFixed(0);
			}
		}
	}
	function updateIgvValue(element) {
		var inputExpensesIGVAmount = document.getElementById("input-expenses_igv_amount");
		if (inputExpensesIGVAmount != null) {
			if (element.value) {
				var igvAmount = parseFloat(element.value);
				inputExpensesIGVAmount.value = (igvAmount - igvAmount/1.18).toFixed(0);
			}
		}
	}
	function updateRentValue(element) {
		var inputExpensesRentAmount = document.getElementById("input-expenses_rent_amount");
		if (inputExpensesRentAmount != null) {
			if (element.value) {
				var rentAmount = parseFloat(element.value);
				inputExpensesRentAmount.value = ((parseFloat(rentAmount))*0.015).toFixed(0);
			}
		}
	}
	var positionCount = 0;
    </script>
@endpush