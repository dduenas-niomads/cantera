<div class="col-12">
    <input type="hidden" name="details[cars_id]" value="0">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('soat_code') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-soat_code">{{ __('SOAT N° Poliza') }}</label>
                <input type="text" maxlength="50" name="details[soat_code]" id="input-soat_code" class="form-control" placeholder="{{ __('Ingrese póliza de SOAT') }}" value="" >
            </div>
            <div class="form-group{{ $errors->has('soat_end_date') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-soat_end_date">{{ __('Fecha de vencimiento SOAT') }}</label>
                <div class="input-group input-group-merge">
                    <input class="form-control datepicker" name="details[soat_end_date]" id="input-soat_end_date" placeholder="Seleccione una fecha" type="text" maxlength="0">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('tech_review_end_date') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-tech_review_end_date">{{ __('Fecha de vencimiento REVISIÓN TÉCNICA') }}</label>
                <div class="input-group input-group-merge">
                    <input class="form-control datepicker" name="details[tech_review_end_date]" id="input-tech_review_end_date" placeholder="Seleccione una fecha" type="text" maxlength="0">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('sat_taxes') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-sat_taxes">{{ __('Impuesto vehicular') }}</label>
                <select name="details[sat_taxes]" id="input-sat_taxes" class="form-control {{ $errors->has('sat_taxes') ? ' is-invalid' : '' }}" >
                    <option value="0">PENDIENTE</option>
                    <option value="1">PAGADO</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('motor_serie') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-motor_serie">{{ __('N° Serie') }}</label>
                        <input type="text" maxlength="50" name="details[motor_serie]" id="input-motor_serie" class="form-control {{ $errors->has('motor_serie') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese número de serie') }}" value="" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('motor_number') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-motor_number">{{ __('N° Motor') }}</label>
                        <input type="text" maxlength="50" name="details[motor_number]" id="input-motor_number" class="form-control {{ $errors->has('motor_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese número de motor') }}" value="" >
                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('cylinders') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-cylinders">{{ __('N° de cilindros') }}</label>
                <input type="number" name="details[cylinders]" id="input-cylinders" min="0" max="16" class="form-control {{ $errors->has('cylinders') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese n° de cilindros') }}" value="" >
            </div>
            <div class="form-group{{ $errors->has('kilometers') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-kilometers">{{ __('Kilometraje') }}</label>
                <input type="number" name="details[kilometers]" id="input-kilometers" min="0" max="9999999" 
                    class="form-control {{ $errors->has('kilometers') ? ' is-invalid' : '' }}" 
                    placeholder="{{ __('Ingrese kilometraje') }}" 
                    value="{{ (isset($car) && isset($car->details)) ? (int)$car->details->kilometers:0 }}" >
            </div>
            <div class="row">
                <div class="col-md-6 form-group{{ $errors->has('cc') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-cc">{{ __('Cilindrada (cc)') }}</label>
                    <input type="number" name="details[cc]" id="input-cc" min="0" max="5000" class="form-control {{ $errors->has('cc') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese cilindrada') }}" value="" >
                </div>
                <div class="col-md-6 form-group{{ $errors->has('hp') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-hp">{{ __('Potencia (hp)') }}</label>
                    <input type="number" name="details[hp]" id="input-hp" min="0" max="5000" class="form-control {{ $errors->has('hp') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese potencia') }}" value="" >
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group{{ $errors->has('torque') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-torque">{{ __('Torque (Nm)') }}</label>
                    <input type="number" name="details[torque]" id="input-torque" min="0" max="5000" class="form-control {{ $errors->has('torque') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese torque') }}" value="" >
                </div>
                <div class="col-md-6 form-group{{ $errors->has('doors_number') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-doors_number">{{ __('N° de puertas') }}</label>
                    <input type="number" name="details[doors_number]" id="input-doors_number" min="0" max="10" class="form-control {{ $errors->has('doors_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese número de puertas') }}" value="" >
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group{{ $errors->has('transmition') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-transmition">{{ __('Transmisión') }}</label>
                    <select name="details[transmition]" id="input-transmition" class="form-control {{ $errors->has('transmition') ? ' is-invalid' : '' }}" >
                        <option value="MT">MANUAL</option>
                        <option value="AT">AUTOMÁTICA</option>
                        <option value="SE">SECUENCIAL</option>
                        <option value="A&S">AT & SE</option>
                    </select>
                </div>
                <div class="col-md-6 form-group{{ $errors->has('traction') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-traction">{{ __('Tracción') }}</label>
                    <select name="details[traction]" id="input-traction" class="form-control {{ $errors->has('traction') ? ' is-invalid' : '' }}" >
                        <option value="4x2">4x2</option>
                        <option value="4x4">4x4</option>
                        <option value="AWD">AWD</option>
                    </select>
                </div>
            </div>
            <div class="form-group{{ $errors->has('fuel') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-fuel">{{ __('Combustible') }}</label>
                <select name="details[fuel]" id="input-fuel" class="form-control {{ $errors->has('fuel') ? ' is-invalid' : '' }}" >
                    <option value="GASOLINA">GASOLINA</option>
                    <option value="PETROLEO">PETROLEO</option>
                    <option value="GNV">GNV</option>
                    <option value="GLP">GLP</option>
                    <option value="OTRO">OTRO</option>
                </select>
            </div>
            <div class="form-group{{ $errors->has('key_code') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-key_code">{{ __('Código de llave') }}</label>
                <input type="text" name="details[key_code]" id="input-key_code" class="form-control {{ $errors->has('key_code') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese código de llave') }}" value="" maxlength="10">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('circulation_end_date') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-circulation_end_date">{{ __('Fecha de vencimiento de Permiso de circulación') }}</label>
                <div class="input-group input-group-merge">
                    <input class="form-control datepicker" name="details[circulation_end_date]" id="input-circulation_end_date" placeholder="Seleccione una fecha" type="text" maxlength="0">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('next_service_date') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-next_service_date">{{ __('Próximo servicio') }}</label>
                <div class="input-group input-group-merge">
                    <input class="form-control datepicker" name="details[next_service_date]" id="input-next_service_date" placeholder="Seleccione una fecha" type="text" maxlength="0">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('work_hours') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-work_hours">{{ __('Horas de trabajo') }}</label>
                <input type="number" name="details[work_hours]" id="input-work_hours" min="0" max="9999" class="form-control {{ $errors->has('work_hours') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese horas de trabajo') }}" value="" >
            </div>
            <div class="form-group{{ $errors->has('ticket_amount_sutran') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-ticket_amount_sutran">{{ __('Monto de papeletas SUTRAN') }}</label>
                <input type="number" name="details[ticket_amount_sutran]" id="input-ticket_amount_sutran" class="form-control {{ $errors->has('ticket_amount_sutran') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese monto de papeletas SUTRAN') }}" value="" >
            </div>
            <div class="form-group{{ $errors->has('ticket_amount_sat') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-ticket_amount_sat">{{ __('Monto de papeletas SAT') }}</label>
                <input type="number" name="details[ticket_amount_sat]" id="input-ticket_amount_sat" class="form-control {{ $errors->has('ticket_amount_sat') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese monto de papeletas SAT') }}" value="" >
            </div>
            <div class="form-group{{ $errors->has('work_hours') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-work_hours">{{ __('Características extras') }}</label>
                <div class="row" style="padding-left: 1rem;">
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox1" name="details[options_json][manuals]" type="checkbox">
                        <label class="custom-control-label" for="checkbox1">{{ __('Manuales') }}</label>
                    </div>
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox2" name="details[options_json][air_conditioner]" type="checkbox">
                        <label class="custom-control-label" for="checkbox2">{{ __('Aire acondicionado') }}</label>
                    </div>
                </div>
                <div class="row" style="padding-left: 1rem;">
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox3" name="details[options_json][wheel_secure]" type="checkbox">
                        <label class="custom-control-label" for="checkbox3">{{ __('Seguro de ruedas') }}</label>
                    </div>
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox4" name="details[options_json][cat]" type="checkbox">
                        <label class="custom-control-label" for="checkbox4">{{ __('Gata') }}</label>
                    </div>
                </div>
                <div class="row" style="padding-left: 1rem;">
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox5" name="details[options_json][tools]" type="checkbox">
                        <label class="custom-control-label" for="checkbox5">{{ __('Herramientas') }}</label>
                    </div>
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox6" name="details[options_json][extra_key]" type="checkbox">
                        <label class="custom-control-label" for="checkbox6">{{ __('Llave duplicada') }}</label>
                    </div>
                </div>
                <div class="row" style="padding-left: 1rem;">
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox7" name="details[options_json][extra_tire]" type="checkbox">
                        <label class="custom-control-label" for="checkbox7">{{ __('Llanta de repuesto') }}</label>
                    </div>
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox8" name="details[options_json][logo]" type="checkbox">
                        <label class="custom-control-label" for="checkbox8">{{ __('Emblemas') }}</label>
                    </div>
                </div>
                <div class="row" style="padding-left: 1rem;">
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox9" name="details[options_json][wheel_key]" type="checkbox">
                        <label class="custom-control-label" for="checkbox9">{{ __('Llave de ruedas') }}</label>
                    </div>
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox10" name="details[options_json][smoke_path]" type="checkbox">
                        <label class="custom-control-label" for="checkbox10">{{ __('Cenicero') }}</label>
                    </div>
                </div>
                <div class="row" style="padding-left: 1rem;">
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox11" name="details[options_json][floors]" type="checkbox">
                        <label class="custom-control-label" for="checkbox11">{{ __('Pisos') }}</label>
                    </div>
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox12" name="details[options_json][leather_seats]" type="checkbox">
                        <label class="custom-control-label" for="checkbox12">{{ __('Asientos de cuero') }}</label>
                    </div>
                </div>
                <div class="row" style="padding-left: 1rem;">
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox13" name="details[options_json][property_card]" type="checkbox">
                        <label class="custom-control-label" for="checkbox13">{{ __('Tarjeta de propiedad') }}</label>
                    </div>
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox14" name="details[options_json][fog_lights]" type="checkbox">
                        <label class="custom-control-label" for="checkbox14">{{ __('Faros antiniebla') }}</label>
                    </div>
                </div>
                <div class="row" style="padding-left: 1rem;">
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox15" name="details[options_json][security_foils]" type="checkbox">
                        <label class="custom-control-label" for="checkbox15">{{ __('Láminas de seguridad') }}</label>
                    </div>
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox16" name="details[options_json][triangule]" type="checkbox">
                        <label class="custom-control-label" for="checkbox16">{{ __('Triángulo') }}</label>
                    </div>
                </div>
                <div class="row" style="padding-left: 1rem;">
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox17" name="details[options_json][lighter]" type="checkbox">
                        <label class="custom-control-label" for="checkbox17">{{ __('Encendedor') }}</label>
                    </div>
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox18" name="details[options_json][hoop_caps]" type="checkbox">
                        <label class="custom-control-label" for="checkbox18">{{ __('Tapas de aro') }}</label>
                    </div>
                </div>
                <div class="row" style="padding-left: 1rem;">
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox19" name="details[options_json][alloy_hoops]" type="checkbox">
                        <label class="custom-control-label" for="checkbox19">{{ __('Aros de aleación') }}</label>
                    </div>
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox20" name="details[options_json][reverse_camera]" type="checkbox">
                        <label class="custom-control-label" for="checkbox20">{{ __('Cámara de retroceso') }}</label>
                    </div>
                </div>
                <div class="row" style="padding-left: 1rem;">
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox21" name="details[options_json][trunk_cover]" type="checkbox">
                        <label class="custom-control-label" for="checkbox21">{{ __('Cobertor de maletera') }}</label>
                    </div>
                    <div class="custom-control custom-checkbox col-md-6">
                        <input class="custom-control-input" id="checkbox22" name="details[options_json][sat_downloaded]" type="checkbox">
                        <label class="custom-control-label" for="checkbox22">{{ __('Descargado SAT') }}</label>
                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('observations') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-observations">{{ __('Observaciones adicionales') }}</label>
                <input type="text" maxlength="150" name="details[observations]" id="input-observations" class="form-control {{ $errors->has('observations') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese observaciones adicionales') }}" value="" >
            </div>
            <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-description">{{ __('Texto descriptivo para la web') }}</label>
                <textarea type="text" name="details[description]" id="input-description" class="form-control {{ $errors->has('observations') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese descripción para web') }}"></textarea>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="col-md-12">
                <div class="text-center">
                    <button type="button" class="btn btn-default" onclick="stepperValidation(false);">Regresar</button>
                    <button type="button" class="btn btn-default" onclick="submitForm('storeForm');">GUARDAR</button>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>