@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('href_title_name')
/products
@endsection

@section('view_title_name')
Módulo de productos
@endsection

@section('nav-products')
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
							<h3 class="mb-0">Nuevo ingreso de producto - Datos generales</h3>
						</div>
					</div>
				</div>
				<hr>
				<div class="col-12">
					<form method="post" action="{{ route('products.store') }}" autocomplete="off" id="storeForm">
						@csrf
						@method('post')
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-control-label" for="input-code">{{ __('Código de barras') }}</label>
									<div>
										<input type="text" maxlength="50" name="code" id="input-code"
											class="form-control " 
											placeholder="{{ __('Ingrese código del producto') }}" 
											value="{{ (!is_null($product) ? $product->code : '') }}" 
											required>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-category">{{ __('Categoría') }}</label>
											<div id="mainheaderCategory">
												<input type="text" maxlength="50" name="category" id="input-category" 
													onkeyup="autocompleteAjax('mainheaderCategory', 'input-category', 'category');
														cleanChilds(['input-model']);"
													class="form-control " 
													placeholder="{{ __('Ingrese categoría del producto') }}" 
													value="{{ (!is_null($product) ? $product->brand : '') }}" 
													required>
											</div>
										</div>										
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-brand">{{ __('Marca') }}</label>
											<div id="mainheaderBrand">
												<input type="text" maxlength="50" name="brand" id="input-brand" 
													onkeyup="autocompleteAjax('mainheaderBrand', 'input-brand', 'brand');
														cleanChilds(['input-model']);"
													class="form-control " 
													placeholder="{{ __('Ingrese marca del producto') }}" 
													value="{{ (!is_null($product) ? $product->brand : '') }}" 
													required>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="form-control-label" for="input-name">{{ __('Nombre') }}</label>
									<div>
										<input type="text" maxlength="50" name="name" id="input-name"
											class="form-control " 
											placeholder="{{ __('Ingrese nombre del producto') }}" 
											value="{{ (!is_null($product) ? $product->name : '') }}" 
											required>
									</div>
								</div>
								<div class="form-group">
									<label class="form-control-label" for="input-description">{{ __('Descripción') }}</label>
									<div>
										<input type="text" maxlength="100" name="description" id="input-description"
											class="form-control " 
											placeholder="{{ __('Ingrese descripción del producto') }}" 
											value="{{ (!is_null($product) ? $product->description : '') }}" >
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-price_compra">{{ __('Precio de compra') }}</label>
											<input type="number" name="price_compra" id="input-price_compra" class="form-control " placeholder="{{ __('Ingrese precio de compra') }}" value="{{ (!is_null($product) ? $product->price_compra : '') }}" required>
										</div>
									</div>
									<div class="col-md-6">	
										<div class="form-group">
											<label class="form-control-label" for="input-price_sale">{{ __('Precio de venta al público') }}</label>
											<input type="number" name="price_sale" id="input-price_sale" class="form-control " placeholder="{{ __('Ingrese precio de venta') }}" value="{{ (!is_null($product) ? $product->price_sale : '') }}" required>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="form-control-label" for="input-type_product">{{ __('Situación de venta') }}</label>
									<select name="type_product" id="input-type_product" class="form-control ">
										<option selected value="1">PRODUCTO</option>
										<option value="2">SERVICIO</option>
									</select>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-stock">{{ __('Stock actual') }}</label>
											<input type="number" name="stock" id="input-stock" class="form-control " placeholder="{{ __('Ingrese stock actual') }}" value="{{ (!is_null($product) ? $product->stock : '0') }}" required>
										</div>
									</div>
									<div class="col-md-6">	
										<div class="form-group">
											<label class="form-control-label" for="input-minimun_stock">{{ __('Stock mínimo') }}</label>
											<input type="number" name="minimun_stock" id="input-minimun_stock" class="form-control " placeholder="{{ __('Ingrese stock mínimo') }}" value="{{ (!is_null($product) ? $product->minimun_stock : '1') }}" required>
										</div>
									</div>
								</div>
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
											class="btn btn-success mt-4">{{ __('Registrar producto') }}</button>
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