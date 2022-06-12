<div class="col-12">
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="purchase[cars_id]" value="{{ (!is_null($car) ? $car->id : 0) }}">
            <div class="form-group">
                <label class="form-control-label" for="input-n_tasacion">{{ __('Tasación N°') }}</label>
                <input type="text" name="purchase[n_tasacion]" id="input-n_tasacion" 
                    class="form-control " 
                    placeholder="{{ __('Ingrese número de tasación') }}" 
                    value="{{ (!is_null($car) ? $car->n_tasacion : '') }}" 
                    readonly>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-register_date">{{ __('Fecha de compra') }}</label>
                <div class="input-group input-group-merge">
                    <input class="form-control datepicker" name="purchase[register_date]" 
                    id="input-register_date" placeholder="Seleccione una fecha" 
                    type="text" maxlength="0" value="{{ (!is_null($purchase) ? $purchase->register_date : '') }}">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-register_date">{{ __('Fecha de ingreso') }}</label>
                <div class="input-group">
                    <input class="form-control" value="{{ !is_null($car) ? $car->register_date : '' }}" placeholder="Sin fecha de ingreso" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-type_entry">{{ __('Tipo de ingreso') }}</label>
                <select name="purchase[type_entry]" id="input-type_entry" class="form-control ">
                    <option {{ (!is_null($purchase) && (int)$purchase->type_entry === 3 ) ? 'selected':'' }} value="3">Compra</option>
                    <option {{ (!is_null($purchase) && (int)$purchase->type_entry === 1 ) ? 'selected':'' }} value="1">Parte de pago en dación</option>
                    <option {{ (!is_null($purchase) && (int)$purchase->type_entry === 4 ) ? 'selected':'' }} value="4">Parte de pago en permuta</option>
                    <option {{ (!is_null($purchase) && (int)$purchase->type_entry === 5 ) ? 'selected':'' }} value="5">Anticipo</option>
                    <option {{ (!is_null($purchase) && (int)$purchase->type_entry === 2 ) ? 'selected':'' }} value="2">Consignación</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-type_entry_detail">{{ __('Detalle de tipo de ingreso') }}</label>
                <input type="text" maxlength="250" name="purchase[type_entry_detail]" 
                id="input-type_entry_detail" class="form-control "
                placeholder="{{ __('Ingrese detalle de tipo de ingreso') }}" 
                value="{{ (!is_null($purchase) ? $purchase->type_entry_detail : '') }}">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-number">{{ __('Placa') }}</label>
                        <input type="text" maxlength="8" name="purchase[number]" id="input-number" 
                        class="form-control " 
                        placeholder="{{ __('Ingrese placa actual') }}" 
                        value="{{ (!is_null($purchase) ? $purchase->number : '') }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">	
                    <div class="form-group">
                        <label class="form-control-label" for="input-ref_number">{{ __('Placa referencia') }}</label>
                        <input type="text" maxlength="8" name="purchase[ref_number]" 
                        id="input-ref_number" class="form-control " 
                        placeholder="{{ __('Ingrese placa de referencia') }}" 
                        value="{{ (!is_null($purchase) ? $purchase->ref_number : '') }}" readonly>
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
                        value="{{ (!is_null($purchase) ? $purchase->brand : '') }}" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-model">{{ __('Modelo') }}</label>
                <div id="mainheaderModel">
                    <input type="text" maxlength="50" name="purchase[model]" id="input-model" 
                        onkeydown="autocompleteAjax('mainheaderModel', 'input-model', 'model', 'input-brand', 'brand');"
                        class="form-control " 
                        placeholder="{{ __('Ingrese modelo') }}" 
                        value="{{ (!is_null($purchase) ? $purchase->model : '') }}" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-color">{{ __('Color') }}</label>
                <div id="mainheaderColor">
                    <input type="text" maxlength="50" name="purchase[color]" id="input-color" 
                        onkeydown="autocompleteAjax('mainheaderColor', 'input-color', 'color');"
                        class="form-control " 
                        placeholder="{{ __('Ingrese color') }}" 
                        value="{{ (!is_null($purchase) ? $purchase->color : '') }}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-fab_year">{{ __('Año fabricación') }}</label>
                        <input type="number" name="purchase[fab_year]" 
                        id="input-fab_year" min="1900" max="{{ date('Y') }}" 
                        class="form-control " 
                        placeholder="{{ __('Ingrese año de fabricación') }}" 
                        value="{{ (!is_null($purchase) ? $purchase->fab_year : '') }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-model_year">{{ __('Año modelo') }}</label>
                        <input type="number" name="purchase[model_year]" id="input-model_year" 
                        min="1900" max="{{ date('Y') }}" class="form-control " 
                        placeholder="{{ __('Ingrese año de modelo') }}" 
                        value="{{ (!is_null($purchase) ? $purchase->model_year : '') }}" readonly>
                    </div>
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
                        value="{{ (!is_null($purchase) ? $purchase->holder : '') }}" 
                       >
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-owner">{{ __('Dueño') }}</label>
                <div id="mainheaderOwner">
                    <input type="text" maxlength="200" name="purchase[owner]" id="input-owner" 
                        onkeydown="autocompleteAjaxForClient('mainheaderOwner', 'input-owner', 'owner', null, null, 'clients');"
                        class="form-control " 
                        placeholder="{{ __('Ingrese dueño del vehículo') }}" 
                        value="{{ (!is_null($purchase) ? $purchase->owner : '') }}" 
                       >
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-currency">{{ __('Moneda') }}</label>
                <select name="purchase[currency]" id="input-currency" class="form-control ">
                    <option {{ (!is_null($purchase) && $purchase->currency === "USD" ) ? 'selected':'' }}  value="USD">DÓLARES</option>
                    <option {{ (!is_null($purchase) && $purchase->currency === "PEN" ) ? 'selected':'' }}  value="PEN">SOLES</option>
                    <option {{ (!is_null($purchase) && $purchase->currency === "EUR" ) ? 'selected':'' }}  value="EUR">EUROS</option>
                    <option {{ (!is_null($purchase) && $purchase->currency === "OTH" ) ? 'selected':'' }}  value="OTH">OTRO</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-price_tasacion">{{ __('Precio tasación') }}</label>
                        <input type="number" name="purchase[price_tasacion]" 
                        id="input-price_tasacion" class="form-control " 
                        placeholder="{{ __('Ingrese precio de tasación') }}" 
                        value="{{ (!is_null($purchase) ? $purchase->price_tasacion : '0.00') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-price_compra">{{ __('Precio compra') }}</label>
                        <input type="number"  
                        name="purchase[price_compra]" id="input-price_compra" 
                        class="form-control " 
                        placeholder="{{ __('Ingrese precio de compra') }}" 
                        value="{{ (!is_null($purchase) ? $purchase->price_compra : '0.00') }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-price_sale">{{ __('Precio de venta al público') }}</label>
                <input type="number" name="purchase[price_sale]" 
                id="input-price_sale" class="form-control " 
                placeholder="{{ __('Ingrese precio de venta') }}" 
                value="{{ (!is_null($purchase) ? $purchase->price_sale : '0.00') }}">
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-control-label" for="input-invoiced">{{ __('Monto facturable de compra') }}</label>
                        <input type="number" onkeyup="updateTaxesValues(this);" 
                        name="purchase[invoiced]" id="input-invoiced" class="form-control " 
                        placeholder="{{ __('Ingrese monto facturable de compra') }}" 
                        value="{{ (!is_null($car) ? $car->invoiced : '') }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-control-label" for="input-expenses_igv_detail" id="label-expenses_igv_detail">{{ __('IGV BASE') }}</label>
                                <input type="text" name="expenses[igv_detail]" id="input-expenses_igv_detail" 
                                    onkeyup="updateIgvValue(this);" class="form-control " 
                                    placeholder="{{ __('Igv base') }}" 
                                    value="{{ (!is_null($car) ? $car->igv_base : '0.00') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-control-label" for="input-expenses_igv_amount" id="label-expenses_igv_amount">{{ __('IGV TOTAL') }}</label>
                                <input type="text" name="expenses[igv]" id="input-expenses_igv_amount" 
                                    class="form-control " 
                                    placeholder="{{ __('Total igv') }}" 
                                    value="{{ (!is_null($car) ? $car->igv_amount : '0.00') }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-control-label" for="input-expenses_rent_detail" id="label-expenses_rent_detail">{{ __('RENTA BASE') }}</label>
                                <input type="text" name="expenses[rent_detail]" id="input-expenses_rent_detail" 
                                    onkeyup="updateRentValue(this);" class="form-control " 
                                    placeholder="{{ __('Renta base') }}" 
                                    value="{{ (!is_null($car) ? $car->rent_base : '0.00') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-control-label" for="input-expenses_rent_amount" id="label-expenses_rent_amount">{{ __('RENTA TOTAL') }}</label>
                                <input type="text" name="expenses[rent]" id="input-expenses_rent_amount" 
                                    class="form-control " 
                                    placeholder="{{ __('Total rent') }}" 
                                    value="{{ (!is_null($car) ? $car->rent_amount : '0.00') }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-type_sign">{{ __('Firma') }}</label>
                <select name="purchase[type_sign]" id="input-type_sign" class="form-control ">
                    <option {{ (!is_null($purchase) && (int)$purchase->type_sign === 1 ) ? 'selected':'' }} value="1">Ley 30536</option>
                    <option {{ (!is_null($purchase) && (int)$purchase->type_sign === 2 ) ? 'selected':'' }} value="2">Empresa</option>
                    <option {{ (!is_null($purchase) && (int)$purchase->type_sign === 3 ) ? 'selected':'' }} value="3">Persona natural</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-details_price_acta">{{ __('Precio de acta') }}</label>
                <input type="number" name="purchase[details_price_acta]" 
                    id="input-details_price_acta" class="form-control " 
                    placeholder="{{ __('Ingrese precio de venta') }}" 
                    value="{{ (!is_null($purchase) ? $purchase->details_price_acta : '0.00') }}">
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-notary">{{ __('Notaria') }}</label>
                <div id="mainheaderNotary">
                    <input type="text" maxlength="200" name="purchase[notary]" id="input-notary" 
                        onkeydown="autocompleteAjax('mainheaderNotary', 'input-notary', 'notary');"
                        class="form-control " 
                        placeholder="{{ __('Ingrese notaria del trámite') }}" 
                        value="{{ (!is_null($purchase) ? $purchase->notary : '') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-n_kardex">{{ __('N° de kardex') }}</label>
                        <input type="text" maxlength="25" name="purchase[n_kardex]" 
                        id="input-n_kardex" class="form-control " 
                        placeholder="{{ __('Ingrese número de kardex') }}" 
                        value="{{ (!is_null($purchase) ? $purchase->n_kardex : '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-n_title">{{ __('N° de título') }}</label>
                        <input type="text" maxlength="25" name="purchase[n_title]" 
                        id="input-n_title" class="form-control " 
                        placeholder="{{ __('Ingrese número de título') }}" 
                        value="{{ (!is_null($purchase) ? $purchase->n_title : '') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="col-md-12">
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
                <br>
            </div>
        </div>

    </div>
</div>