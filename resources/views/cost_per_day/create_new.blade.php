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
					<form method="post" action="{{ route('costPerDay.store') }}" autocomplete="off">
						@csrf
						@method('post')
						<div class="row">
							<div class="col-md-12">
								<div class="form-group" id="expenses_json">
									<label class="form-control-label" for="input-price_sale">{{ __('Detalle de gastos') }}  <a href="javascript:void(0);" onclick="newExpenseElement();"><i class="fas fa-plus"></i> (Clic para añadir nuevo)</a></label>
								</div>
                            </div>
							<div class="col-md-12 row">
								<div class="col-md-6">
									<div class="text-center">
                                    	<button type="submit"
                                        	class="btn btn-success mt-4">{{ __('Registrar costo diario') }}</button>
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
	var positionCount = 0;
</script>
@endpush