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
							<h3 class="mb-0">Editar tasación vehicular</h3>
						</div>
					</div>
				</div>
				<div class="col-12">
                    <form method="post" action="{{ route('taxations.update', $taxation->id) }}" id="updateForm" autocomplete="off">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-12">
                                    <h3 class="">Información del vehículo</h3>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="input-type_entry">{{ __('Tipo de ingreso') }}</label>
                                    <select id="input-type_entry" name="car_json[type_entry]"
                                        class="form-control " 
                                        value="{{ !is_null($taxation->car) ? $taxation->car->type_entry : '' }}">
                                        @if (!is_null($taxation->car))
                                            <option {{ ((int)$taxation->car->type_entry === 1) ? 'selected':'' }} value="1">Parte de pago</option>
                                            <option {{ ((int)$taxation->car->type_entry === 2) ? 'selected':'' }} value="2">Consignación</option>
                                            <option {{ ((int)$taxation->car->type_entry === 3) ? 'selected':'' }} value="3">Compra</option>
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
                                            value="{{ !is_null($taxation->car) ? $taxation->car->brand : '' }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-model">{{ __('Modelo') }}</label>
                                    <div id="mainheaderModel">
                                        <input type="text" maxlength="50" id="input-model" name="car_json[model]"
                                            onkeydown="autocompleteAjax('mainheaderModel', 'input-model', 'model', 'input-brand', 'brand');"
                                            class="form-control "
                                            placeholder="{{ __('Ingrese modelo') }}" 
                                            value="{{ !is_null($taxation->car) ? $taxation->car->model : '' }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-number">{{ __('Placa') }}</label>
                                    <input type="text" maxlength="8" id="input-number" name="car_json[number]"
                                        class="form-control "
                                        placeholder="{{ __('Ingrese placa actual') }}" 
                                        value="{{ !is_null($taxation->car) ? $taxation->car->number : '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-color">{{ __('Color') }}</label>
                                    <div id="mainheaderColor">
                                        <input type="text" maxlength="50" id="input-color" name="car_json[color]"
                                            onkeydown="autocompleteAjax('mainheaderColor', 'input-color', 'color');"
                                            class="form-control "
                                            placeholder="{{ __('Ingrese color') }}" 
                                            value="{{ !is_null($taxation->car) ? $taxation->car->color : '' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-fab_year">{{ __('Año fabricación') }}</label>
                                            <input type="number" id="input-fab_year" min="1900" max="{{ date('Y') }}" 
                                                class="form-control " name="car_json[fab_year]" 
                                                placeholder="{{ __('Ingrese año de fabricación') }}" 
                                                value="{{ !is_null($taxation->car) ? $taxation->car->fab_year : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-model_year">{{ __('Año modelo') }}</label>
                                            <input type="number" id="input-model_year" min="1900" max="{{ date('Y') }}" 
                                                class="form-control " name="car_json[model_year]" 
                                                placeholder="{{ __('Ingrese año de modelo') }}" 
                                                value="{{ !is_null($taxation->car) ? $taxation->car->model_year : '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-kilometers">{{ __('Kilometraje') }}</label>
                                    <input type="number" maxlength="200" id="input-kilometers"
                                        class="form-control " name="car_json[kilometers]"
                                        placeholder="{{ __('Ingrese kilometraje del vehículo') }}" 
                                        value="{{ (!is_null($taxation->car) && !is_null($taxation->car->details)) ? $taxation->car->details->kilometers : '0' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-holder">{{ __('Titular') }}</label>
                                    <div id="mainheaderHolder">
                                        <input type="text" maxlength="200" id="input-holder"
                                            class="form-control " name="car_json[holder]"
                                            onkeydown="autocompleteAjax('mainheaderHolder', 'input-holder', 'holder', null, null, 'clients');"
                                            placeholder="{{ __('Ingrese titular del vehículo') }}" 
                                            value="{{ !is_null($taxation->car) ? $taxation->car->holder : '' }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-owner">{{ __('Dueño') }}</label>
                                    <div id="mainheaderOwner">
                                        <input type="text" maxlength="200" id="input-owner"
                                            class="form-control " name="car_json[owner]"
                                            onkeydown="autocompleteAjax('mainheaderOwner', 'input-owner', 'owner', null, null, 'clients');"
                                            placeholder="{{ __('Ingrese dueño del vehículo') }}" 
                                            value="{{ !is_null($taxation->car) ? $taxation->car->owner : '' }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-phone">{{ __('Teléfono del cliente') }}</label>
                                    <input type="text" maxlength="25" name="phone" id="input-phone" class="form-control " 
                                        placeholder="{{ __('Ingrese número de contacto del cliente') }}" 
                                        value="{{ $taxation->phone }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-12">
                                    <h3 class="">Información de la tasación</h3>
                                </div>
                                <input type="hidden" name="cars_id" value="{{ !is_null($taxation->car) ? $taxation->car->id : null }}">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-taxation_date">{{ __('Fecha de tasación') }}</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control datepicker" name="taxation_date" id="input-taxation_date" 
                                            placeholder="Seleccione una fecha" type="text" maxlength="0" value="{{ $taxation->taxation_date }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-taxator_id">{{ __('Tasador') }}</label>
									<div id="mainheaderTaxator">
                                        <input type="text" maxlength="200" id="input-taxator" name="taxator"
											onkeydown="autocompleteAjax('mainheaderTaxator', 'input-taxator', 'taxator');"
                                            class="form-control "
                                            placeholder="{{ __('Ingrese tasador') }}" value="{{ $taxation->taxator }}" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-salesman_id">{{ __('Asesor de ventas') }}</label>
									<div id="mainheaderSalesman">
                                        <input type="text" maxlength="200" id="input-salesman" name="salesman"
											onkeydown="autocompleteAjax('mainheaderSalesman', 'input-salesman', 'salesman');"
                                            class="form-control "
                                            placeholder="{{ __('Ingrese asesor de ventas') }}" value="{{ $taxation->salesman }}" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-currency">{{ __('Moneda') }}</label>
                                    <select id="input-currency" 
                                        class="form-control " 
                                        value="{{ !is_null($taxation->car) ? $taxation->car->currency : '' }}">
                                        @if (!is_null($taxation->car))
                                            <option {{ ($taxation->car->currency === 'USD') ? 'selected':'' }} value="USD">DÓLARES</option>
                                            <option {{ ($taxation->car->currency === 'PEN') ? 'selected':'' }} value="PEN">SOLES</option>
                                            <option {{ ($taxation->car->currency === 'EUR') ? 'selected':'' }} value="EUR">EUROS</option>
                                            <option {{ ($taxation->car->currency === 'OTH') ? 'selected':'' }} value="OTH">OTRO</option>
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
                                        placeholder="{{ __('Ingrese monto del cliente') }}" value="{{ $taxation->client_amount }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-offered_amount">{{ __('Monto ofrecido') }}</label>
                                    <input type="number" name="offered_amount" id="input-offered_amount" class="form-control " 
                                        placeholder="{{ __('Ingrese monto ofrecido') }}" value="{{ $taxation->offered_amount }}" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-tires">{{ __('Llantas') }}</label>
                                            <select name="tires" id="input-tires" class="form-control ">
                                                <option {{ ((int)$taxation->tires === 1) ? 'selected':'' }} value="1">MALO</option>
                                                <option {{ ((int)$taxation->tires === 2) ? 'selected':'' }} value="2">REGULAR</option>
                                                <option {{ ((int)$taxation->tires === 3) ? 'selected':'' }} value="3">BUENO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-paint">{{ __('Pintura') }}</label>
                                            <select name="paint" id="input-paint" class="form-control ">
                                                <option {{ ((int)$taxation->paint === 1) ? 'selected':'' }} value="1">MALO</option>
                                                <option {{ ((int)$taxation->paint === 2) ? 'selected':'' }} value="2">REGULAR</option>
                                                <option {{ ((int)$taxation->paint === 3) ? 'selected':'' }} value="3">BUENO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-owners">{{ __('Propietarios') }}</label>
                                            <select name="owners" id="input-owners" class="form-control ">
                                                <option {{ ((int)$taxation->owners === 1) ? 'selected':'' }} value="1">Unico dueño</option>
                                                <option {{ ((int)$taxation->owners === 2) ? 'selected':'' }} value="2">2 dueños</option>
                                                <option {{ ((int)$taxation->owners === 3) ? 'selected':'' }} value="3">3 dueños</option>
                                                <option {{ ((int)$taxation->owners === 4) ? 'selected':'' }} value="4">4 dueños</option>
                                                <option {{ ((int)$taxation->owners === 5) ? 'selected':'' }} value="5">5 dueños</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-maintenance">{{ __('Mantenimiento') }}</label>
                                            <select name="maintenance" id="input-maintenance" class="form-control ">
                                                <option {{ ((int)$taxation->maintenance === 1) ? 'selected':'' }} value="1">MALO</option>
                                                <option {{ ((int)$taxation->maintenance === 2) ? 'selected':'' }} value="2">REGULAR</option>
                                                <option {{ ((int)$taxation->maintenance === 3) ? 'selected':'' }} value="3">BUENO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-status">{{ __('Estado de tasación') }}</label>
                                    <select name="status" id="input-status" class="form-control ">
                                        <option {{ ((int)$taxation->status === 1) ? 'selected':'' }} value="1">Pendiente</option>
                                        <option {{ ((int)$taxation->status === 3) ? 'selected':'' }} value="3">Rechazado</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-comentary">{{ __('Comentarios') }}</label>
                                    <input type="text" maxlength="25" name="comentary" id="input-comentary" class="form-control " 
                                        placeholder="{{ __('Ingrese comentarios adicionales') }}" value="{{ $taxation->comentary }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <button type="button" 
                                        data-toggle="modal" data-target="#updateModal"
                                        class="btn btn-success mt-4">{{ __('Guardar cambios') }}</button>
                                </div>
                                <br>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center">
                                    <button type="button" 
                                        data-toggle="modal" data-target="#deleteModal"
                                        class="btn btn-danger mt-4">{{ __('Eliminar tasación') }}</button>
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