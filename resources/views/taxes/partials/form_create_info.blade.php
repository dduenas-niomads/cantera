<div class="col-12">
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="purchase[cars_id]" value="{{ (!is_null($car) ? $car->id : 0) }}">
            <div class="form-group">
                <label class="form-control-label" for="input-n_tasacion">{{ __('Tasación N°') }}</label>
                <input type="text" name="purchase[n_tasacion]" id="input-n_tasacion" 
                    class="form-control " 
                    placeholder="{{ __('Ingrese número de tasación') }}" value="{{ (!is_null($car) ? $car->n_tasacion : '') }}" readonly>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-number">{{ __('Placa') }}</label>
                        <input type="text" maxlength="8" name="purchase[number]" id="input-number" class="form-control " placeholder="{{ __('Ingrese placa actual') }}" value="{{ (!is_null($car) ? $car->number : '') }}" required>
                    </div>
                </div>
                <div class="col-md-6">	
                    <div class="form-group">
                        <label class="form-control-label" for="input-ref_number">{{ __('Placa referencia') }}</label>
                        <input type="text" maxlength="8" name="purchase[ref_number]" id="input-ref_number" class="form-control " placeholder="{{ __('Ingrese placa de referencia') }}" value="">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-register_date">{{ __('Fecha de ingreso') }}</label>
                <div class="input-group input-group-merge">
                    <input class="form-control datepicker" name="purchase[register_date]" 
                        id="input-register_date" placeholder="Seleccione una fecha" type="text" maxlength="0">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-brand">{{ __('Marca') }}</label>
                <div id="mainheaderBrand">
                    <input type="text" maxlength="50" name="purchase[brand]" id="input-brand" 
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
                    <input type="text" maxlength="50" name="purchase[model]" id="input-model" 
                        onkeydown="autocompleteAjax('mainheaderModel', 'input-model', 'model', 'input-brand', 'brand');"
                        class="form-control " 
                        placeholder="{{ __('Ingrese modelo') }}" 
                        value="{{ (!is_null($car) ? $car->model : '') }}" 
                        required>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label" for="input-holder">{{ __('Titular') }}</label>
                <div id="mainheaderHolder">
                    <input type="text" maxlength="200" name="purchase[holder]" id="input-holder" 
                        onkeydown="autocompleteAjaxForClient('mainheaderHolder', 'input-holder', 'holder', null, null, 'clients');"
                        class="form-control " 
                        placeholder="{{ __('Ingrese titular del vehículo') }}" 
                        value="{{ (!is_null($car) ? $car->holder : '') }}" 
                        required>
                </div>
            </div>
            <!-- <input type="hidden" name="purchase[flag_active]" value="0"> -->
            <div class="form-group">
                <label class="form-control-label" for="input-owner">{{ __('Dueño') }}</label>
                <div id="mainheaderOwner">
                    <input type="text" maxlength="200" name="purchase[owner]" id="input-owner" 
                        onkeydown="autocompleteAjaxForClient('mainheaderOwner', 'input-owner', 'owner', null, null, 'clients');"
                        class="form-control " 
                        placeholder="{{ __('Ingrese dueño del vehículo') }}" 
                        value="{{ (!is_null($car) ? $car->owner : '') }}" 
                        required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-color">{{ __('Color') }}</label>
                <div id="mainheaderColor">
                    <input type="text" maxlength="50" name="purchase[color]" id="input-color" 
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
                        <input type="number" name="purchase[fab_year]" id="input-fab_year" min="1900" max="{{ date('Y') }}" class="form-control " placeholder="{{ __('Ingrese año de fabricación') }}" value="{{ (!is_null($car) ? $car->fab_year : '') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-model_year">{{ __('Año modelo') }}</label>
                        <input type="number" name="purchase[model_year]" id="input-model_year" min="1900" max="{{ date('Y') }}" class="form-control " placeholder="{{ __('Ingrese año de modelo') }}" value="{{ (!is_null($car) ? $car->model_year : '') }}" required>
                    </div>
                </div>
            </div>
            <div class="form-group" style="display: none;">
                <label class="form-control-label" for="input-status">{{ __('Estado') }}</label>
                <select name="purchase[status]" id="input-status" class="form-control ">
                    <option selected value="1">SEMINUEVO</option>
                    <option value="0">NUEVO</option>
                    <option value="2">USADO</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">	
                    <div class="form-group">
                        <label class="form-control-label" for="input-price_sale">{{ __('Precio de venta al público') }}</label>
                        <input type="number" name="purchase[price_sale]" id="input-price_sale" class="form-control " placeholder="{{ __('Ingrese precio de venta') }}" value="{{ (!is_null($car) ? $car->price_sale : '') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-price_promotion">{{ __('Precio en promoción') }}</label>
                        <input type="number" name="purchase[price_promotion]" id="input-price_promotion" 
                            class="form-control " 
                            placeholder="{{ __('Ingrese precio de promoción') }}" value="{{ (!is_null($car) ? $car->price_sale : '') }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-for_sale">{{ __('Vehículo para venta') }}</label>
                <select name="purchase[for_sale]" id="input-for_sale" class="form-control ">
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="col-md-12">
                <div class="text-center">
                    <button type="button" class="btn btn-default" 
                        onclick="stepperValidation();">Continuar</button>
                        <!-- true, true, ['ti_1'] -->
                </div>
                <br>
            </div>
        </div>

    </div>
</div>