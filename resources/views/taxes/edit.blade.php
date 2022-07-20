@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('href_title_name')
/taxes
@endsection

@section('view_title_name')
Módulo de RUCS
@endsection

@section('nav-taxes')
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
							<h3 class="mb-0">Actualizar RUC - {{ $tax->document_number }} {{ $tax->name }}</h3>
						</div>
					</div>
				</div>
				<hr>
				<div class="col-12">
					<form method="post" action="{{ route('taxes.update', $tax->id) }}" autocomplete="off" id="storeForm">
						@csrf
						@method('put')
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-control-label" for="input-document_number">{{ __('Número de documento') }}</label>
									<div>
										<input type="text" maxlength="11" name="document_number" id="input-document_number"
											class="form-control " 
											placeholder="{{ __('Ingrese número de RUC') }}" 
											value="{{ (!is_null($tax) ? $tax->document_number : '') }}" 
											required>
									</div>
								</div>
								<div class="form-group">
									<label class="form-control-label" for="input-name">{{ __('Razón social') }}</label>
									<div>
										<input type="text" maxlength="50" name="name" id="input-name"
											class="form-control " 
											placeholder="{{ __('Ingrese nombre de la razón social') }}" 
											value="{{ (!is_null($tax) ? $tax->name : '') }}" 
											required>
									</div>
								</div>
								<div class="form-group">
									<label class="form-control-label" for="input-description">{{ __('Descripción') }}</label>
									<div>
										<input type="text" maxlength="100" name="description" id="input-description"
											class="form-control " 
											placeholder="{{ __('Ingrese descripción del RUC') }}" 
											value="{{ (!is_null($tax) ? $tax->description : '') }}" >
									</div>
								</div>
								<div class="form-group">
									<label class="form-control-label" for="input-top">{{ __('Máximo de emisión') }}</label>
									<input type="number" name="top" id="input-top" class="form-control " placeholder="{{ __('Ingrese máximo de emisión') }}" value="{{ (!is_null($tax) ? $tax->top : '0') }}" required>
								</div>
							</div>
							<div class="col-md-6">
								@if (Auth()->user()->company->type_business === 1)
									<div class="form-group">
										<label class="form-control-label" for="input-type">{{ __('Tipo de RUC') }}</label>
										<select name="type" id="input-type" class="form-control ">
											<option {{ ((int)$tax->type === 1) ? 'selected':'' }} value="1">CANCHA</option>
											<option {{ ((int)$tax->type === 2) ? 'selected':'' }} value="2">BAR</option>
										</select>
									</div>
									<div class="form-group{{ $errors->has('cancha_id') ? ' has-danger' : '' }}">
										<label class="form-control-label" for="input-cancha_id">{{ __('Cancha') }}</label>
										<select name="cancha_id" class="form-control ">
											<option {{ ((int)$tax->cancha_id === 1) ? 'selected':'' }} value="1">CANCHA 1</option>
											<option {{ ((int)$tax->cancha_id === 2) ? 'selected':'' }} value="2">CANCHA 2</option>
										</select>
									</div>
								@else
									<div class="form-group">
										<label class="form-control-label" for="input-type">{{ __('Tipo de RUC') }}</label>
										<select name="type" id="input-type" class="form-control ">
											<option selected value="3">VENTA FISICA</option>
											<option value="4" disabled>VENTA ONLINE</option>
										</select>
									</div>
									<div class="form-group{{ $errors->has('cancha_id') ? ' has-danger' : '' }}">
										<label class="form-control-label" for="input-cancha_id">{{ __('Local') }}</label>
										<select name="cancha_id" class="form-control ">
											<option value="3">{{ Auth()->user()->company->name }}</option>
										</select>
									</div>
								@endif
								<div class="form-group">
									<label class="form-control-label" for="input-flag_active">{{ __('Estado') }}</label>
									<select name="flag_active" id="input-flag_active" class="form-control ">
										<option selected value="1">ACTIVO</option>
										<option value="0">INACTIVO</option>
									</select>
								</div>
							</div>
							<div class="col-md-12 row">
								<div class="col-md-12">
									<div class="text-center">
										<button type="button" onclick="submitForm('storeForm');" 
											class="btn btn-success mt-4">{{ __('Actualizar RUC') }}</button>
									</div>
									<br>
								</div>
							</div>
						</div>
					</form>
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

<script>
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
</script>
@endpush