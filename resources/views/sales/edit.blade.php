@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link rel="stylesheet" href="{{ asset('argon') }}/css/myCss.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/css/bs-stepper.min.css">
@endpush

@section('href_title_name')
/sales
@endsection

@section('view_title_name')
Módulo de ventas
@endsection

@section('nav-sales')
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
							<h3 class="mb-0">Ventas de vehículo</h3>
						</div>
					</div>
				</div>
				<div class="col-12">
					<form method="post" action="{{ route('sales.update', $sale->id) }}" 
						id="storeForm" autocomplete="off" enctype="multipart/form-data">
						@csrf
						@method('put')
						<div id="stepperDiv" class="bs-stepper">
							<div class="bs-stepper-header">
								<div class="step" data-target="#test-nl-1">
									<button type="button" class="btn step-trigger">
										<span class="bs-stepper-circle">1</span>
										<span class="bs-stepper-label">Editar datos de venta</span>
									</button>
								</div>
							</div>
							<div class="bs-stepper-content">
								<div id="test-nl-1" class="content">
									@include('sales.partials.form_edit_sale')
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
	function stepperValidation(goNext = true, validateForm = false, idObjectsToValidate = []) {
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
	}
	var positionCount = 0;
	function updateExpensesValues(element) {
		// calcular utilidad facturable
		var baseAmount = 0;
		var inputInvoicedValue = 0;
		var rentAmount = 0;
		var igvAmount = 0;
		var expensesAmount = 0;
		var inputPurchaseInvoiced = document.getElementById('input-purchase_invoiced');
		var inputInvoiced = document.getElementById('input-invoiced');
		if (inputPurchaseInvoiced != null && inputInvoiced != null 
			&& inputPurchaseInvoiced.value != "" && inputInvoiced.value != "") {
			inputInvoicedValue = parseFloat(inputInvoiced.value);
			baseAmount = parseFloat(inputInvoiced.value) - parseFloat(inputPurchaseInvoiced.value);
		}
		// calcular igv
		var labelExpensesIGVAmount = document.getElementById('label-expenses_igv_amount');
		var inputExpensesIGVAmount = document.getElementById('input-expenses_igv_amount');
		if (labelExpensesIGVAmount != null && inputExpensesIGVAmount != null) {
			igvAmount = (baseAmount - baseAmount/1.18);
			labelExpensesIGVAmount.innerHTML = "IGV SOBRE: " + baseAmount.toFixed(0);
			inputExpensesIGVAmount.value = igvAmount.toFixed(0);
			var expenses_igv_detail = document.getElementById('expenses_igv_detail');
			if (expenses_igv_detail != null) {
				expenses_igv_detail.value = baseAmount.toFixed(0);
			}
		}
		// calcular renta
		var labelExpensesRentAmount = document.getElementById('label-expenses_rent_amount');
		var inputExpensesRentAmount = document.getElementById('input-expenses_rent_amount');
		if (labelExpensesRentAmount != null && inputExpensesRentAmount != null) {
			rentAmount = (inputInvoicedValue*0.015);
			labelExpensesRentAmount.innerHTML = "RENTA SOBRE: " + (inputInvoicedValue).toFixed(0);
			inputExpensesRentAmount.value = rentAmount.toFixed(0);
		}
		// actualizar gastos y costo total
		var costWithoutTaxes = document.getElementById('cost_without_taxes');
		if (costWithoutTaxes != null) {
			// gastos
			var inputPriceExpenses = document.getElementById('input-price_expenses');
			if (inputPriceExpenses != null) {
				expensesAmount = parseFloat(costWithoutTaxes.value) + rentAmount + igvAmount;
				inputPriceExpenses.value = expensesAmount.toFixed(0);
			}
			// costo total
			var inputPriceCompra = document.getElementById('input-price_compra');
			var inputTotalCost = document.getElementById('input-total_cost');
			if (inputTotalCost != null && inputPriceCompra != null) {
				inputTotalCost.value = (parseFloat(inputPriceCompra.value) + expensesAmount).toFixed(0);
			}
		}		
	}
    </script>
@endpush