@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('href_title_name')
/cars
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
			<div class="card shadow">
				<div class="card-header border-0">
					<div class="row align-items-center">
						<div class="col-12">
							<h3 class="mb-0">Editar gastos añadidos del vehículo: {{ $carEntryExpense->car->brand }}  {{ $carEntryExpense->car->model }}  ({{ $carEntryExpense->car->number }})</h3>
						</div>
					</div>
				</div>

				<div class="col-12">


					<form method="post" action="{{ route('cars.update-expenses', $carEntryExpense->id) }}" autocomplete="off" id="updateForm">
						@csrf
						@method('put')
						<input type="hidden" id="exchange_rate" value="{{ $exchangeRateValue }}">
						@if (session('status'))
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							{{ session('status') }}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						@endif

						<div class="row">
							<div class="col-md-12">
									@php
                                        $iterator = 0;
                                    @endphp
									<table class="myTable align-items-center table-bordered table-hover table-sm">
										<thead>
											<th scope="col" class="thTaxationLeft" style="width: 20%;">Nombre</th>
											<th scope="col" class="thTaxationMiddle" style="width: 35%;">Detalle</th>
											<th scope="col" class="thTaxationMiddle" style="width: 12%;">Fecha</th>
											<th scope="col" class="thTaxationMiddle" style="width: 10%;">Moneda</th>
											<th scope="col" class="thTaxationMiddle" style="width: 10%;">Monto</th>
											<th scope="col" class="thTaxationMiddle" style="width: 8%;">T.Cambio</th>
											<th scope="col" class="thTaxationRight" style="width: 5%;"><a id="buttonNew" class="button btn btn-success btn-sm" href="javascript:void(0);" onclick="newExpenseElementTd({{ $car->id }});"><i class="fas fa-plus"></i></a></th>
										</thead>
										<tbody id="expenses_json">
											@if (!is_null($carEntryExpense->expenses_json))
												@foreach ($carEntryExpense->expenses_json as $expenseJson)
													<tr id="expense_element_{{ $iterator }}">
														<td>
															<input type="text" name="expenses_json[{{ $iterator }}][name]" class="form-control form-control-sm" 
																placeholder="Nombre" value="{{ $expenseJson['name'] }}" autofocus>
														</td>
														<td>
															<input type="text" name="expenses_json[{{ $iterator }}][detail]" class="form-control form-control-sm" 
																placeholder="Detalle" value="{{ $expenseJson['detail'] }}">
														</td>
														<td>
															<input type="text" name="expenses_json[{{ $iterator }}][date]" class="form-control form-control-sm datepicker" 
																placeholder="Fecha" value="{{ $expenseJson['date'] }}">
														</td>
														<td>	
															<select class="form-control form-control-sm" onChange="changeRate({{ $iterator }}, this);" name="expenses_json[{{ $iterator }}][currency]">
																<option value="{{ $expenseJson['currency'] }}">{{ $expenseJson['currency'] }}</option>
																<option value="USD">USD</option>
																<option value="PEN">PEN</option>
																<option value="EUR">EUR</option>
																<option value="OTH">OTH</option>
															</select>
														</td>
														<td>
															<input type="number" name="expenses_json[{{ $iterator }}][value]" class="form-control form-control-sm" 
																placeholder="Monto" value="{{ $expenseJson['value'] }}">
														</td>
														<td>
															<input type="text" id="exchange_rate_{{ $iterator }}" name="expenses_json[{{ $iterator }}][exchange_rate]" class="form-control form-control-sm" 
																	placeholder="TC" value="{{ isset($expenseJson['exchange_rate']) ? $expenseJson['exchange_rate'] : 1 }}">
														</td>
														<td>
															<a href="javascript:void(0);" onclick="deleteExpenseElement({{ $iterator }});">
																<i class="fas fa-trash" style="padding-top: 1rem;"></i>
															</a><br id="br_expense_element_{{ $iterator }}"/>
														</td>
													</tr>
													@php
														$iterator++;
													@endphp
												@endforeach
											@endif
										</tbody>
									</table>
                                <input type="hidden" id="iteratorCount" value="{{ $iterator }}">
                            </div>
							<div class="col-md-12 row">
								<div class="col-md-6">
									<div class="text-center">
										<button type="button" 
											onclick="submitForm('updateForm');"
											class="btn btn-success mt-4">{{ __('Guardar cambios') }}</button>
									</div>
									<br>
								</div>
								<div class="col-md-6">
									<div class="text-center">
										<button type="button" 
											onclick="calculateExpenses();"
											class="btn btn-default mt-4">{{ __('Calcular gastos') }}</button>
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
<!-- modals -->

	<div class="modal fade"  id="updateModal"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('¿Desea guardar los cambios realizados?') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('Porfavor, confirme si desea continuar con la actualización de características.') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" onClick="submitForm('updateForm');" class="btn btn-success">{{ __('GUARDAR') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('REGRESAR') }}</button>
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade"  id="expensesModal"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{ __('Resultado de gastos') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@php
					$registerDate = DateTime::createFromFormat('d/m/Y', $carEntryExpense->car->register_date);
					if (!$registerDate) {
						$dateDiff = 0;
					} else {
						$todayDate = date_create('now');
						$interval = date_diff($registerDate, $todayDate);
						$dateDiff = $interval->format('%a');
					}
				@endphp
				<input type="hidden" name="date_diff" id="date_diff" value="{{ $dateDiff }}">
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table table-sm table-bordered align-items-center">
							<thead class="">
								<th>Precio compra</th>
								<th>Precio venta</th>
								<th><b>Total de gastos añadidos</b></th>
							</thead>
							<tbody>
								<tr>
									<td>{{ $carEntryExpense->car->price_compra }}</td>
									<td>{{ $carEntryExpense->car->price_sale }}</td>
									<td><b id="expenses_amount">0.00</b> {{ $carEntryExpense->car->currency }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('REGRESAR') }}</button>
				</div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.ES.js" charset="UTF-8"></script>
<script src="{{ asset('argon') }}/js/default.js"></script>
<script>
	var positionCount = parseInt(document.getElementById('iteratorCount').value) - 1;
	$('#buttonNew').click();
	var inputName = document.getElementById(positionCount);
	if (inputName != null) {
		inputName.focus();
	}
</script>
@endpush