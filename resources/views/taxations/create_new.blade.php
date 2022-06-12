@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('href_title_name')
/taxations
@endsection
@section('view_title_name')
Tasación vehicular
@endsection

@section('nav-taxations')
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
							<h3 class="mb-0">Nueva tasación vehicular</h3>
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
                            <form method="get" action="{{ route('taxations.create') }}" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" maxlength="20" name="car_code" id="input-car_code" 
                                                class="form-control" 
                                                placeholder="{{ __('Ingrese código de vehículo') }}" value="" autofocus>
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
                    <form method="post" action="{{ route('taxations.store') }}" autocomplete="off">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-12">
                                    <h3 class="">Información del vehículo</h3>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="input-type_entry">{{ __('Tipo de ingreso') }}</label>
                                    <select id="input-type_entry" name="car_json[type_entry]" 
                                        class="form-control " value="{{ !is_null($car) ? $car->type_entry : '' }}">
                                        @if (!is_null($car))
                                            <option {{ ((int)$car->type_entry === 1) ? 'selected':'' }} value="1">Parte de pago</option>
                                            <option {{ ((int)$car->type_entry === 2) ? 'selected':'' }} value="2">Consignación</option>
                                            <option {{ ((int)$car->type_entry === 3) ? 'selected':'' }} value="3">Compra</option>
                                        @else
                                            <option value="1">Parte de pago</option>
                                            <option value="2">Consignación</option>
                                            <option value="3">Compra</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-brand">{{ __('Marca') }}</label>
                                    <div id="mainheaderBrand">
                                        <input type="text" maxlength="50" id="input-brand" name="car_json[brand]"
                                            onkeydown="autocompleteAjax('mainheaderBrand', 'input-brand', 'brand');
                                                cleanChilds(['input-model']);"
                                            class="form-control " 
                                            placeholder="{{ __('Ingrese marca del vehículo') }}"
                                            value="{{ !is_null($car) ? $car->brand : '' }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-model">{{ __('Modelo') }}</label>
                                    <div id="mainheaderModel">
                                        <input type="text" maxlength="50" id="input-model" name="car_json[model]"
                                            onkeydown="autocompleteAjax('mainheaderModel', 'input-model', 'model', 'input-brand', 'brand');"
                                            class="form-control "
                                            placeholder="{{ __('Ingrese modelo') }}" value="{{ !is_null($car) ? $car->model : '' }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-number">{{ __('Placa') }}</label>
                                    <input type="text" maxlength="8" id="input-number" name="car_json[number]"
                                        class="form-control "
                                        placeholder="{{ __('Ingrese placa actual') }}" value="{{ !is_null($car) ? $car->number : '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-color">{{ __('Color') }}</label>
                                    <div id="mainheaderColor">
                                        <input type="text" maxlength="50" id="input-color" name="car_json[color]"
                                            onkeydown="autocompleteAjax('mainheaderColor', 'input-color', 'color');"
                                            class="form-control "
                                            placeholder="{{ __('Ingrese color') }}" value="{{ !is_null($car) ? $car->color : '' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-fab_year">{{ __('Año fabricación') }}</label>
                                            <input type="number" id="input-fab_year" name="car_json[fab_year]" min="1900" max="{{ date('Y') }}" 
                                                class="form-control " 
                                                placeholder="{{ __('Ingrese año de fabricación') }}" value="{{ !is_null($car) ? $car->fab_year : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-model_year">{{ __('Año modelo') }}</label>
                                            <input type="number" id="input-model_year" name="car_json[model_year]" min="1900" max="{{ date('Y') }}" 
                                                class="form-control " 
                                                placeholder="{{ __('Ingrese año de modelo') }}" value="{{ !is_null($car) ? $car->model_year : '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-kilometers">{{ __('Kilometraje') }}</label>
                                    <input type="number" maxlength="200" id="input-kilometers" name="car_json[kilometers]"
                                        class="form-control "
                                        placeholder="{{ __('Ingrese kilometraje del vehículo') }}" value="{{ !is_null($car) ? $car->kilometers : '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-holder">{{ __('Titular') }}</label>
                                    <div id="mainheaderHolder">
                                        <input type="text" maxlength="200" id="input-holder" name="car_json[holder]"
                                            onkeydown="autocompleteAjax('mainheaderHolder', 'input-holder', 'holder', null, null, 'clients');"
                                            class="form-control "
                                            placeholder="{{ __('Ingrese titular del vehículo') }}" value="{{ !is_null($car) ? $car->holder : '' }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-owner">{{ __('Dueño') }}</label>
                                    <div id="mainheaderOwner">
                                        <input type="text" maxlength="200" id="input-owner" name="car_json[owner]"
                                            onkeydown="autocompleteAjax('mainheaderOwner', 'input-owner', 'owner', null, null, 'clients');"
                                            class="form-control "
                                            placeholder="{{ __('Ingrese dueño del vehículo') }}" value="{{ !is_null($car) ? $car->owner : '' }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-phone">{{ __('Teléfono del cliente') }}</label>
                                    <input type="text" maxlength="25" name="phone" id="input-phone" class="form-control " 
                                        placeholder="{{ __('Ingrese número de contacto del cliente') }}" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-12">
                                    <h3 class="">Información de la tasación</h3>
                                </div>
                                <input type="hidden" name="cars_id" value="{{ !is_null($car) ? $car->id : null }}">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-taxation_date">{{ __('Fecha de tasación') }}</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control datepicker" name="taxation_date" id="input-taxation_date" placeholder="Seleccione una fecha" type="text" maxlength="0">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-taxator">{{ __('Tasador') }}</label>
									<div id="mainheaderTaxator">
                                        <input type="text" maxlength="200" id="input-taxator" name="taxator"
											onkeydown="autocompleteAjax('mainheaderTaxator', 'input-taxator', 'taxator');"
                                            class="form-control "
                                            placeholder="{{ __('Ingrese tasador') }}" value="" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-salesman">{{ __('Asesor de ventas') }}</label>
									<div id="mainheaderSalesman">
                                        <input type="text" maxlength="200" id="input-salesman" name="salesman"
											onkeydown="autocompleteAjax('mainheaderSalesman', 'input-salesman', 'salesman');"
                                            class="form-control "
                                            placeholder="{{ __('Ingrese asesor de ventas') }}" value="" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-currency">{{ __('Moneda') }}</label>
                                    <select id="input-currency" name="car_json[currency]" 
                                        class="form-control " value="{{ !is_null($car) ? $car->currency : '' }}">
                                        @if (!is_null($car))
                                            <option {{ ($car->currency === 'USD') ? 'selected':'' }} value="USD">DÓLARES</option>
                                            <option {{ ($car->currency === 'PEN') ? 'selected':'' }} value="PEN">SOLES</option>
                                            <option {{ ($car->currency === 'EUR') ? 'selected':'' }} value="EUR">EUROS</option>
                                            <option {{ ($car->currency === 'OTH') ? 'selected':'' }} value="OTH">OTRO</option>
                                        @else
                                            <option value="USD">DÓLARES</option>
                                            <option value="PEN">SOLES</option>
                                            <option value="EUR">EUROS</option>
                                            <option value="OTH">OTRO</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-client_amount">{{ __('Monto del cliente') }}</label>
                                    <input type="number" name="client_amount" id="input-client_amount" class="form-control " 
                                        placeholder="{{ __('Ingrese solicitado por el cliente') }}" value="" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-offered_amount">{{ __('Monto ofrecido') }}</label>
                                    <input type="number" name="offered_amount" id="input-offered_amount" class="form-control " 
                                        placeholder="{{ __('Ingrese monto ofrecido por el asesor/tasador') }}" value="" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-tires">{{ __('Llantas') }}</label>
                                            <select name="tires" id="input-tires" class="form-control ">
                                                <option value="1">Malo</option>
                                                <option selected value="2">Regular</option>
                                                <option value="3">Bueno</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-paint">{{ __('Pintura') }}</label>
                                            <select name="paint" id="input-paint" class="form-control ">
                                                <option value="1">Malo</option>
                                                <option selected value="2">Regular</option>
                                                <option value="3">Bueno</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-owners">{{ __('Propietarios') }}</label>
                                            <select name="owners" id="input-owners" class="form-control ">
                                                <option selected value="1">Único dueño</option>
                                                <option value="2">2 dueños</option>
                                                <option value="2">3 dueños</option>
                                                <option value="4">4 dueños</option>
                                                <option value="5">5 dueños</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-maintenance">{{ __('Mantenimiento') }}</label>
                                            <select name="maintenance" id="input-maintenance" class="form-control ">
                                                <option value="1">Malo</option>
                                                <option selected value="2">Regular</option>
                                                <option value="3">Bueno</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-status">{{ __('Estado de tasación') }}</label>
                                    <select name="status" id="input-status" class="form-control ">
                                        <option value="1">Pendiente</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-comentary">{{ __('Comentarios') }}</label>
                                    <input type="text" maxlength="25" name="comentary" id="input-comentary" class="form-control " 
                                        placeholder="{{ __('Ingrese comentarios adicionales') }}" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <button type="submit" 
                                        class="btn btn-success mt-4">{{ __('Registrar tasación') }}</button>
                                </div>
                                <br>
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
@endpush