@extends('layouts.app', ['class' => 'bg-dark'])

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
							<h3 class="mb-0">Editar características del vehículo: {{ $carEntryDetail->car->brand }}  {{ $carEntryDetail->car->model }}  ({{ $carEntryDetail->car->number }})</h3>
						</div>
					</div>
				</div>

				<div class="col-12">


					<form method="post" action="{{ route('cars.update-details', $carEntryDetail->id) }}" autocomplete="off" id="updateForm">
						@csrf
						@method('put')

                        <input type="hidden" name="cars_id" value="{{ $carEntryDetail->cars_id }}">

						@if (session('status'))
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							{{ session('status') }}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						@endif

						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('soat_code') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-soat_code">{{ __('SOAT N° Poliza') }}</label>
									<input type="text" maxlength="50" name="soat_code" id="input-soat_code" class="form-control" placeholder="{{ __('Ingrese póliza de SOAT') }}" value="{{ $carEntryDetail->soat_code }}" >
								</div>
								<div class="form-group{{ $errors->has('soat_end_date') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-soat_end_date">{{ __('Fecha de vencimiento SOAT') }}</label>
									<div class="input-group input-group-merge">
										<input class="form-control datepicker" name="soat_end_date" id="input-soat_end_date" placeholder="Seleccione una fecha" value="{{ $carEntryDetail->soat_end_date }}" type="text" maxlength="0">
										<div class="input-group-append">
											<span class="input-group-text"><i class="fas fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group{{ $errors->has('tech_review_end_date') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-tech_review_end_date">{{ __('Fecha de vencimiento REVISIÓN TÉCNICA') }}</label>
									<div class="input-group input-group-merge">
										<input class="form-control datepicker" name="tech_review_end_date" id="input-tech_review_end_date" placeholder="Seleccione una fecha" value="{{ $carEntryDetail->tech_review_end_date }}" type="text" maxlength="0">
										<div class="input-group-append">
											<span class="input-group-text"><i class="fas fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group{{ $errors->has('sat_taxes') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-sat_taxes">{{ __('Impuesto vehicular') }}</label>
									<select name="sat_taxes" id="input-sat_taxes" class="form-control {{ $errors->has('sat_taxes') ? ' is-invalid' : '' }}" >
										<option {{ ((int)$carEntryDetail->sat_taxes === 0) ? 'selected':'' }} value="0">PENDIENTE</option>
										<option {{ ((int)$carEntryDetail->sat_taxes === 1) ? 'selected':'' }} value="1">PAGADO</option>
									</select>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group{{ $errors->has('motor_serie') ? ' has-danger' : '' }}">
											<label class="form-control-label" for="input-motor_serie">{{ __('N° Serie') }}</label>
											<input type="text" maxlength="50" name="motor_serie" id="input-motor_serie" class="form-control {{ $errors->has('motor_serie') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese número de serie') }}" value="{{ $carEntryDetail->motor_serie }}" >
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group{{ $errors->has('motor_number') ? ' has-danger' : '' }}">
											<label class="form-control-label" for="input-motor_number">{{ __('N° Motor') }}</label>
											<input type="text" maxlength="50" name="motor_number" id="input-motor_number" class="form-control {{ $errors->has('motor_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese número de motor') }}" value="{{ $carEntryDetail->motor_number }}" >
										</div>
									</div>
								</div>
								<div class="form-group{{ $errors->has('cylinders') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-cylinders">{{ __('N° de cilindros') }}</label>
									<input type="number" name="cylinders" id="input-cylinders" min="0" max="16" class="form-control {{ $errors->has('cylinders') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese n° de cilindros') }}" value="{{ $carEntryDetail->cylinders }}" >
								</div>
								<div class="form-group{{ $errors->has('kilometers') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-kilometers">{{ __('Kilometraje') }}</label>
									<input type="number" name="kilometers" id="input-kilometers" min="0" max="9999999" class="form-control {{ $errors->has('kilometers') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese kilometraje') }}" value="{{ $carEntryDetail->kilometers }}" >
								</div>
								<div class="row">
									<div class="col-md-6 form-group{{ $errors->has('cc') ? ' has-danger' : '' }}">
										<label class="form-control-label" for="input-cc">{{ __('Cilindrada (cc)') }}</label>
										<input type="number" name="cc" id="input-cc" min="0" max="5000" class="form-control {{ $errors->has('cc') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese cilindrada') }}" value="{{ $carEntryDetail->cc }}" >
									</div>
									<div class="col-md-6 form-group{{ $errors->has('hp') ? ' has-danger' : '' }}">
										<label class="form-control-label" for="input-hp">{{ __('Potencia (hp)') }}</label>
										<input type="number" name="hp" id="input-hp" min="0" max="5000" class="form-control {{ $errors->has('hp') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese potencia') }}" value="{{ $carEntryDetail->hp }}" >
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 form-group{{ $errors->has('torque') ? ' has-danger' : '' }}">
										<label class="form-control-label" for="input-torque">{{ __('Torque (Nm)') }}</label>
										<input type="number" name="torque" id="input-torque" min="0" max="5000" class="form-control {{ $errors->has('torque') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese torque') }}" value="{{ $carEntryDetail->torque }}" >
									</div>
									<div class="col-md-6 form-group{{ $errors->has('doors_number') ? ' has-danger' : '' }}">
										<label class="form-control-label" for="input-doors_number">{{ __('N° de puertas') }}</label>
										<input type="number" name="doors_number" id="input-doors_number" min="0" max="10" class="form-control {{ $errors->has('doors_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese número de puertas') }}" value="{{ $carEntryDetail->doors_number }}" >
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 form-group{{ $errors->has('transmition') ? ' has-danger' : '' }}">
										<label class="form-control-label" for="input-transmition">{{ __('Transmisión') }} {{ $carEntryDetail->transmition }}</label>
										<select name="transmition" id="input-transmition" class="form-control {{ $errors->has('transmition') ? ' is-invalid' : '' }}" >
											<option {{ ($carEntryDetail->transmition === "MT") ? 'selected':'' }} value="MT">MANUAL</option>
											<option {{ ($carEntryDetail->transmition === "AT") ? 'selected':'' }} value="AT">AUTOMÁTICA</option>
											<option {{ ($carEntryDetail->transmition === "SE") ? 'selected':'' }} value="SE">SECUENCIAL</option>
											<option {{ ($carEntryDetail->transmition === "A&S") ? 'selected':'' }} value="A&S">AT & SE</option>
										</select>
									</div>
									<div class="col-md-6 form-group{{ $errors->has('traction') ? ' has-danger' : '' }}">
										<label class="form-control-label" for="input-traction">{{ __('Tracción') }}</label>
										<select name="traction" id="input-traction" class="form-control {{ $errors->has('traction') ? ' is-invalid' : '' }}" >
											<option {{ ($carEntryDetail->traction === "4X2") ? 'selected':'' }} value="4x2">4x2</option>
											<option {{ ($carEntryDetail->traction === "4X4") ? 'selected':'' }} value="4x4">4x4</option>
											<option {{ ($carEntryDetail->traction === "AWD") ? 'selected':'' }} value="AWD">AWD</option>
										</select>
									</div>
								</div>
								<div class="form-group{{ $errors->has('fuel') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-fuel">{{ __('Combustible') }}</label>
									<select name="fuel" id="input-fuel" class="form-control {{ $errors->has('fuel') ? ' is-invalid' : '' }}" >
										<option {{ ($carEntryDetail->fuel === "GASOLINA") ? 'selected':'' }}  value="GASOLINA">GASOLINA</option>
										<option {{ ($carEntryDetail->fuel === "PETROLEO") ? 'selected':'' }}  value="PETROLEO">PETROLEO</option>
										<option {{ ($carEntryDetail->fuel === "GNV") ? 'selected':'' }}  value="GNV">GNV</option>
										<option {{ ($carEntryDetail->fuel === "GLP") ? 'selected':'' }}  value="GLP">GLP</option>
										<option {{ ($carEntryDetail->fuel === "OTRO") ? 'selected':'' }}  value="OTRO">OTRO</option>
									</select>
								</div>
								<div class="form-group{{ $errors->has('key_code') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-key_code">{{ __('Código de llave') }}</label>
									<input type="text" name="key_code" id="input-key_code" class="form-control {{ $errors->has('key_code') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese código de llave') }}" value="{{ $carEntryDetail->key_code }}" maxlength="10">
								</div>
                            </div>
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('circulation_end_date') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-circulation_end_date">{{ __('Fecha de vencimiento de Permiso de circulación') }}</label>
									<div class="input-group input-group-merge">
										<input class="form-control datepicker" name="circulation_end_date" id="input-circulation_end_date" placeholder="Seleccione una fecha" type="text" maxlength="0" value="{{ $carEntryDetail->circulation_end_date }}">
										<div class="input-group-append">
											<span class="input-group-text"><i class="fas fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group{{ $errors->has('next_service_date') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-next_service_date">{{ __('Próximo servicio FECHA') }}</label>
									<div class="input-group input-group-merge">
										<input class="form-control datepicker" name="next_service_date" id="input-next_service_date" placeholder="Seleccione una fecha" type="text" maxlength="0" value="{{ $carEntryDetail->next_service_date }}">
										<div class="input-group-append">
											<span class="input-group-text"><i class="fas fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group{{ $errors->has('next_service_km') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-next_service_km">{{ __('Próximo servicio KM') }}</label>
									<div class="input-group input-group-merge">
										<input class="form-control" name="next_service_km" id="input-next_service_km" placeholder="Ingrese próximo servicio en KM" type="text" value="{{ $carEntryDetail->next_service_km }}">
									</div>
								</div>
								<div class="form-group{{ $errors->has('work_hours') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-work_hours">{{ __('Horas de trabajo') }}</label>
									<input type="number" name="work_hours" id="input-work_hours" min="0" max="9999" class="form-control {{ $errors->has('work_hours') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese horas de trabajo') }}"  value="{{ $carEntryDetail->work_hours }}" >
								</div>
								<div class="form-group{{ $errors->has('ticket_amount_sutran') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-ticket_amount_sutran">{{ __('Monto de papeletas SUTRAN') }}</label>
									<input type="number" name="ticket_amount_sutran" id="input-ticket_amount_sutran" class="form-control {{ $errors->has('ticket_amount_sutran') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese monto de papeletas SUTRAN') }}"  value="{{ $carEntryDetail->ticket_amount_sutran }}" >
								</div>
								<div class="form-group{{ $errors->has('ticket_amount_sat') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-ticket_amount_sat">{{ __('Monto de papeletas SAT') }}</label>
									<input type="number" name="ticket_amount_sat" id="input-ticket_amount_sat" class="form-control {{ $errors->has('ticket_amount_sat') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese monto de papeletas SAT') }}"  value="{{ $carEntryDetail->ticket_amount_sat }}" >
								</div>
								<div class="form-group{{ $errors->has('work_hours') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-work_hours">{{ __('Características extras') }}</label>
                                    <div class="row" style="padding-left: 1rem;">
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox1" name="options_json[manuals]" type="checkbox" {{ (isset($carEntryDetail->options_json['manuals']) && $carEntryDetail->options_json['manuals'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox1">{{ __('Manuales') }}</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox2" name="options_json[air_conditioner]" type="checkbox"  {{ (isset($carEntryDetail->options_json['air_conditioner']) && $carEntryDetail->options_json['air_conditioner'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox2">{{ __('Aire acondicionado') }}</label>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left: 1rem;">
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox3" name="options_json[wheel_secure]" type="checkbox"  {{ (isset($carEntryDetail->options_json['wheel_secure']) && $carEntryDetail->options_json['wheel_secure'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox3">{{ __('Seguro de ruedas') }}</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox4" name="options_json[cat]" type="checkbox"  {{ (isset($carEntryDetail->options_json['cat']) && $carEntryDetail->options_json['cat'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox4">{{ __('Gata') }}</label>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left: 1rem;">
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox5" name="options_json[tools]" type="checkbox"  {{ (isset($carEntryDetail->options_json['tools']) && $carEntryDetail->options_json['tools'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox5">{{ __('Herramientas') }}</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox6" name="options_json[extra_key]" type="checkbox"  {{ (isset($carEntryDetail->options_json['extra_key']) && $carEntryDetail->options_json['extra_key'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox6">{{ __('Llave duplicada') }}</label>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left: 1rem;">
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox7" name="options_json[extra_tire]" type="checkbox"  {{ (isset($carEntryDetail->options_json['extra_tire']) && $carEntryDetail->options_json['extra_tire'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox7">{{ __('Llanta de repuesto') }}</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox8" name="options_json[logo]" type="checkbox"  {{ (isset($carEntryDetail->options_json['logo']) && $carEntryDetail->options_json['logo'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox8">{{ __('Emblemas') }}</label>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left: 1rem;">
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox9" name="options_json[wheel_key]" type="checkbox"  {{ (isset($carEntryDetail->options_json['wheel_key']) && $carEntryDetail->options_json['wheel_key'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox9">{{ __('Llave de ruedas') }}</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox10" name="options_json[smoke_path]" type="checkbox"  {{ (isset($carEntryDetail->options_json['smoke_path']) && $carEntryDetail->options_json['smoke_path'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox10">{{ __('Cenicero') }}</label>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left: 1rem;">
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox11" name="options_json[floors]" type="checkbox"  {{ (isset($carEntryDetail->options_json['floors']) && $carEntryDetail->options_json['floors'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox11">{{ __('Pisos') }}</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox12" name="options_json[leather_seats]" type="checkbox"  {{ (isset($carEntryDetail->options_json['leather_seats']) && $carEntryDetail->options_json['leather_seats'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox12">{{ __('Asientos de cuero') }}</label>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left: 1rem;">
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox13" name="options_json[property_card]" type="checkbox"  {{ (isset($carEntryDetail->options_json['property_card']) && $carEntryDetail->options_json['property_card'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox13">{{ __('Tarjeta de propiedad') }}</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox14" name="options_json[fog_lights]" type="checkbox"  {{ (isset($carEntryDetail->options_json['fog_lights']) && $carEntryDetail->options_json['fog_lights'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox14">{{ __('Faros antiniebla') }}</label>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left: 1rem;">
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox15" name="options_json[security_foils]" type="checkbox"  {{ (isset($carEntryDetail->options_json['security_foils']) && $carEntryDetail->options_json['security_foils'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox15">{{ __('Láminas de seguridad') }}</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox16" name="options_json[triangule]" type="checkbox"  {{ (isset($carEntryDetail->options_json['triangule']) && $carEntryDetail->options_json['triangule'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox16">{{ __('Triángulo') }}</label>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left: 1rem;">
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox17" name="options_json[lighter]" type="checkbox"  {{ (isset($carEntryDetail->options_json['lighter']) && $carEntryDetail->options_json['lighter'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox17">{{ __('Encendedor') }}</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox18" name="options_json[hoop_caps]" type="checkbox"  {{ (isset($carEntryDetail->options_json['hoop_caps']) && $carEntryDetail->options_json['hoop_caps'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox18">{{ __('Tapas de aro') }}</label>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left: 1rem;">
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox19" name="options_json[alloy_hoops]" type="checkbox"  {{ (isset($carEntryDetail->options_json['alloy_hoops']) && $carEntryDetail->options_json['alloy_hoops'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox19">{{ __('Aros de aleación') }}</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox20" name="options_json[reverse_camera]" type="checkbox"  {{ (isset($carEntryDetail->options_json['reverse_camera']) && $carEntryDetail->options_json['reverse_camera'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox20">{{ __('Cámara de retroceso') }}</label>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left: 1rem;">
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox21" name="options_json[trunk_cover]" type="checkbox"  {{ (isset($carEntryDetail->options_json['trunk_cover']) && $carEntryDetail->options_json['trunk_cover'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox21">{{ __('Cobertor de maletera') }}</label>
                                        </div>
                                        <div class="custom-control custom-checkbox col-md-6">
                                            <input class="custom-control-input" id="checkbox22" name="options_json[sat_downloaded]" type="checkbox"  {{ (isset($carEntryDetail->options_json['sat_downloaded']) && $carEntryDetail->options_json['sat_downloaded'] === 'on' ) ? 'checked':'' }}>
                                            <label class="custom-control-label" for="checkbox22">{{ __('Descargado SAT') }}</label>
                                        </div>
                                    </div>
                                </div>
								<div class="form-group{{ $errors->has('observations') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-observations">{{ __('Observaciones adicionales del vehículo') }}</label>
									<input type="text" maxlength="150" name="observations" id="input-observations" class="form-control {{ $errors->has('observations') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese observaciones adicionales') }}" value="{{ $carEntryDetail->observations }}" >
								</div>
								<div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
									<label class="form-control-label" for="input-description">{{ __('Texto descriptivo para la web') }}</label>
									<textarea type="text" name="description" id="input-description" class="form-control {{ $errors->has('observations') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese descripción para web') }}">{{ $carEntryDetail->description }}</textarea>
								</div>
                            </div>
							<div class="col-md-12 row">
								<!-- <div class="col-md-6">
									<div class="text-center">
										<button type="button"
											onClick="window.location.replace('/cars');"
											class="btn btn-warning mt-4">{{ __('Regresar al listado') }}</button>
									</div>
									<br>
								</div> -->
								<div class="col-md-12">
									<div class="text-center">
										<button type="button"
                                            data-toggle="modal" data-target="#updateModal"
											class="btn btn-success mt-4">{{ __('Guardar características') }}</button>
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

@endsection

@push('js')
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.ES.js" charset="UTF-8"></script>
<script src="{{ asset('argon') }}/js/default.js"></script>
@endpush