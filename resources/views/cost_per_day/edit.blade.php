@extends('layouts.app', ['class' => 'bg-dark'])

@section('href_title_name')
/cost-per-day
@endsection

@section('view_title_name')
Costo diario vehicular
@endsection

@section('nav-cost')
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
							<h3 class="mb-0">Mantenimiento de costo diario vehicular</h3>
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
                </div>
				<div class="col-12">
					<form method="post" action="{{ route('costPerDay.update') }}" autocomplete="off">
						@csrf
						@method('put')
						<div class="row">
							<div class="col-md-12">
								<div class="form-group" id="expenses_json">
									<label class="form-control-label" for="input-price_sale">{{ __('Detalle de gastos') }}  <a href="javascript:void(0);" onclick="newExpenseElement();"><i class="fas fa-plus"></i> (Clic para añadir nuevo)</a></label>
									@php
                                        $iterator = 0;
                                    @endphp
                                    @foreach ($costPerDay->expenses_json as $expenseJson)
                                        <div class="row" id="expense_element_{{ $iterator }}" >
                                            <div class="col-md-3">
                                                <input type="text" name="expenses_json[{{ $iterator }}][name]" class="form-control" 
                                                    placeholder="Nombre" value="{{ $expenseJson['name'] }}">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="expenses_json[{{ $iterator }}][detail]" class="form-control" 
                                                    placeholder="Detalle" value="{{ $expenseJson['detail'] }}">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="expenses_json[{{ $iterator }}][date]" class="form-control datepicker" 
                                                    placeholder="Detalle" value="{{ $expenseJson['date'] }}">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="expenses_json[{{ $iterator }}][value]" class="form-control" 
                                                    placeholder="Monto" value="{{ $expenseJson['value'] }}">
                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <select class="form-control" name="expenses_json[{{ $iterator }}][currency]">
															<option value="{{ $expenseJson['currency'] }}">{{ $expenseJson['currency'] }}</option>
                                                            <option value="USD">USD</option>
                                                            <option value="PEN">PEN</option>
                                                            <option value="EUR">EUR</option>
                                                            <option value="OTH">OTH</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <a href="javascript:void(0);" onclick="deleteExpenseElement({{ $iterator }});">
                                                            <i class="fas fa-trash" style="padding-top: 1rem;"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br id="br_expense_element_{{ $iterator }}"/>
                                        @php
                                            $iterator++;
                                        @endphp
                                    @endforeach
								</div>
                            </div>
							<div class="col-md-12 row">
								<div class="col-md-6">
									<div class="text-center">
                                    	<button type="submit"
                                        	class="btn btn-success mt-4">{{ __('Guardar cambios') }}</button>
									</div>
									<br>
								</div>
								<div class="col-md-6">
									<div class="text-center">
										<button type="button"
											onclick="calculateExpenses();"
											class="btn btn-default mt-4">{{ __('Calcular gasto') }}</button>
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
<div class="modal fade"  id="expensesModal"  tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{ __('Resultado de gastos') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4 id="expenses_amount">0.00</h4>
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
	var positionCount = {{ $iterator }};
</script>
@endpush