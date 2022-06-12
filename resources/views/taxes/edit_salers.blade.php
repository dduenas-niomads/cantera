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
                            <h3 class="mb-0">Datos generales del vehículo y de la compra</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <form method="post" action="{{ route('cars.update', $car->id) }}" id="updateForm"  autocomplete="off">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-n_tasacion">{{ __('Tasación N°') }}</label>
                                    <input type="text" name="n_tasacion" id="input-n_tasacion"
                                        class="form-control "
                                        placeholder="{{ __('Ingrese número de tasación') }}"
                                        value="{{ $car->n_tasacion }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-register_date">{{ __('Fecha de ingreso') }}</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control datepicker" name="register_date" 
                                            id="input-register_date" placeholder="Seleccione una fecha" 
                                            type="text" maxlength="0" value="{{ $car->register_date }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-publish_at">{{ __('Fecha de publicación') }}</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control datepicker" name="publish_at" 
                                            id="input-publish_at" placeholder="Seleccione una fecha" 
                                            type="text" maxlength="0" value="{{ $car->publish_at }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-number">{{ __('Placa') }}</label>
                                            <input type="text" maxlength="8" name="number" id="input-number"
                                                class="form-control "
                                                placeholder="{{ __('Ingrese placa actual') }}" value="{{ $car->number }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-ref_number">{{ __('Placa referencia') }}</label>
                                            <input type="text" maxlength="8" name="ref_number" id="input-ref_number"
                                                class="form-control "
                                                placeholder="{{ __('Ingrese placa de referencia') }}"
                                                value="{{ $car->ref_number }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-brand">{{ __('Marca') }}</label>
									<div id="mainheaderBrand">
										<input type="text" maxlength="50" name="brand" id="input-brand" 
											onkeydown="autocompleteAjax('mainheaderBrand', 'input-brand', 'brand');
												cleanChilds(['input-model']);"
											class="form-control " 
											placeholder="{{ __('Ingrese marca del vehículo') }}" 
											value="{{ (!is_null($car) ? $car->brand : '') }}" 
											required>
									</div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-model">{{ __('Modelo') }}</label>
									<div id="mainheaderModel">
										<input type="text" maxlength="50" name="model" id="input-model" 
											onkeydown="autocompleteAjax('mainheaderModel', 'input-model', 'model', 'input-brand', 'brand');"
											class="form-control " 
											placeholder="{{ __('Ingrese modelo') }}" 
											value="{{ (!is_null($car) ? $car->model : '') }}" 
											required>
									</div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-flag_active">{{ __('Estado actual') }}</label>
                                    <select name="flag_active" id="input-flag_active" 
                                        class="form-control "
                                        required value="{{ $car->flag_active }}">
                                        <option {{ ((int)$car->flag_active === 1) ? 'selected':'' }} value="1">COMPRADO</option>
                                        <option {{ ((int)$car->flag_active === 2) ? 'selected':'' }} value="2">VENDIDO</option>
                                        <option {{ ((int)$car->flag_active === 3) ? 'selected':'' }} value="3">ELIMINADO</option>
                                        <option {{ ((int)$car->flag_active === 0) ? 'selected':'' }} value="0">INCOMPLETO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-holder">{{ __('Titular') }}</label>
									<div id="mainheaderHolder">
										<input type="text" maxlength="200" name="holder" id="input-holder" 
											onkeydown="autocompleteAjax('mainheaderHolder', 'input-holder', 'holder', null, null, 'clients');"
											class="form-control " 
											placeholder="{{ __('Ingrese titular del vehículo') }}" 
											value="{{ (!is_null($car) ? $car->holder : '') }}" 
											required>
									</div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-owner">{{ __('Dueño') }}</label>
									<div id="mainheaderOwner">
										<input type="text" maxlength="200" name="owner" id="input-owner" 
											onkeydown="autocompleteAjax('mainheaderOwner', 'input-owner', 'owner', null, null, 'clients');"
											class="form-control " 
											placeholder="{{ __('Ingrese dueño del vehículo') }}" 
											value="{{ (!is_null($car) ? $car->owner : '') }}" 
											required>
									</div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-color">{{ __('Color') }}</label>
									<div id="mainheaderColor">
										<input type="text" maxlength="50" name="color" id="input-color" 
											onkeydown="autocompleteAjax('mainheaderColor', 'input-color', 'color');"
											class="form-control " 
											placeholder="{{ __('Ingrese color') }}" 
											value="{{ (!is_null($car) ? $car->color : '') }}" 
											required>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="form-control-label" for="input-fab_year">{{ __('Año fabricación') }}</label>
                                            <input type="number" name="fab_year" id="input-fab_year" min="1900" max="{{ date('Y') }}" 
                                                class="form-control " 
                                                placeholder="{{ __('Ingrese año de fabricación') }}" value="{{ $car->fab_year }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-model_year">{{ __('Año modelo') }}</label>
                                            <input type="number" name="model_year" id="input-model_year" min="1900" max="{{ date('Y') }}" 
                                                class="form-control " 
                                                placeholder="{{ __('Ingrese año de modelo') }}" value="{{ $car->model_year }}" required>
                                        </div>
                                    </div>
                                </div>
								<div class="row">
									<div class="col-md-6">	
										<div class="form-group">
											<label class="form-control-label" for="input-price_sale">{{ __('Precio de venta al público') }}</label>
											<input type="number" name="price_sale" id="input-price_sale" class="form-control " placeholder="{{ __('Ingrese precio de venta') }}" value="{{ (!is_null($car) ? $car->price_sale : '') }}" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-price_promotion">{{ __('Precio en promoción') }}</label>
											<input type="number" name="price_promotion" id="input-price_promotion" 
												class="form-control " 
												placeholder="{{ __('Ingrese precio de promoción') }}" value="{{ (!is_null($car) ? $car->price_promotion : '') }}">
										</div>
									</div>
								</div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-for_sale">{{ __('Vehículo para venta') }}</label>
                                    <select name="for_sale" id="input-for_sale" 
                                        class="form-control " 
                                        required value="{{ $car->for_sale }}">
                                        <option {{ ((int)$car->for_sale === 0) ? 'selected':'' }}  value="0">NO</option>
                                        <option {{ ((int)$car->for_sale === 1) ? 'selected':'' }}  value="1">SI</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                @if (is_null($car->deleted_at))
                                <form method="post" action="{{ route('cars.destroy', $car->id) }}" autocomplete="off" id="deleteForm">
                                    @csrf
                                    @method('delete')
                                    <button type="button"
                                        data-toggle="modal" data-target="#deleteModal"
                                        class="btn btn-danger mt-4">{{ __('Eliminar vehículo') }}</button>
                                </form>
                                @else
                                <form method="post" action="{{ route('cars.update', $car->id) }}" autocomplete="off" id="updateForm2">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="flag_active" value="1">
                                    <input type="hidden" name="deleted_at" value>
                                    <button type="button"
                                        data-toggle="modal" data-target="#reintegroModal"
                                        class="btn btn-danger mt-4">{{ __('Reintegrar vehículo') }}</button>
                                </form>
                                @endif
                            </div>
                            <br>
                        </div>
                    </div>
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
