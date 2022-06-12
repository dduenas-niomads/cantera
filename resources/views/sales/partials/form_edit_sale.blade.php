<div class="col-12">
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="sale[cars_id]" value="{{ (!is_null($car) ? $car->id : 0) }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-purchase_date">{{ __('Fecha de compra') }}</label>
                        <div class="input-group input-group-merge">
                            <input type="text" name="sale[purchase_date]" id="input-purchase_date" class="form-control datepicker" placeholder="{{ __('Fecha de compra') }}" value="{{ (!is_null($sale) ? $sale->purchase_date : '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">	
                    <div class="form-group">
                        <label class="form-control-label" for="input-sale_date">{{ __('Fecha de venta') }}</label>
                        <div class="input-group input-group-merge">
                            <input type="text" name="sale[sale_date]" id="input-sale_date" class="form-control datepicker" placeholder="{{ __('Fecha de venta') }}" value="{{ (!is_null($sale) ? $sale->sale_date : '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-company_owner">{{ __('A nombre de quien') }}</label>
                <div id="mainheaderCompanyOwner">
                    <input type="text" maxlength="200" name="company_owner" id="input-company_owner" 
                        class="form-control " 
                        placeholder="{{ __('Vehículo sin dueño en la empresa') }}" 
                        value="{{ (!is_null($car) ? $car->company_owner : '') }}"
                        onkeydown="autocompleteAjax('mainheaderCompanyOwner', 'input-company_owner', 'company_owner', null, null, 'masters');">
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-type_document">{{ __('Tipo de venta') }}</label>
                <select name="sale[type_document]" id="input-type_document" class="form-control " required>
                    <option {{ (!is_null($sale) && (int)$sale->type_document === 6 ) ? 'selected':'' }} value="6">Ley 30536 Boleta</option>
                    <option {{ (!is_null($sale) && (int)$sale->type_document === 7 ) ? 'selected':'' }} value="7">Ley 30536 Factura</option>
                    <option {{ (!is_null($sale) && (int)$sale->type_document === 3 ) ? 'selected':'' }} value="3">Boleta</option>
                    <option {{ (!is_null($sale) && (int)$sale->type_document === 1 ) ? 'selected':'' }} value="1">Factura</option>
                    <option {{ (!is_null($sale) && (int)$sale->type_document === 4 ) ? 'selected':'' }} value="4">Comisión Boleta</option>
                    <option {{ (!is_null($sale) && (int)$sale->type_document === 2 ) ? 'selected':'' }} value="2">Comisión Factura</option>
                    <option {{ (!is_null($sale) && (int)$sale->type_document === 8 ) ? 'selected':'' }} value="8">Persona natural</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-type_document">{{ __('Detalle de tipo de venta') }}</label>
                <input type="text" name="sale[detail_type_document]" id="input-detail_type_document" class="form-control " placeholder="{{ __('Detalle tipo de documento') }}" value="{{ (!is_null($sale) ? $sale->detail_type_document : '') }}">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-document_serie">{{ __('Serie') }}</label>
                        <input type="text" maxlength="8" name="sale[document_serie]" id="input-document_serie" class="form-control " placeholder="{{ __('Serie del documento') }}" value="{{ (!is_null($sale) ? $sale->document_serie : '') }}">
                    </div>
                </div>
                <div class="col-md-6">	
                    <div class="form-group">
                        <label class="form-control-label" for="input-document_number">{{ __('Correlativo') }}</label>
                        <input type="text" maxlength="8" name="sale[document_number]" id="input-document_number" class="form-control " placeholder="{{ __('Correlativo del documento') }}" value="{{ (!is_null($sale) ? $sale->document_number : '') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-number">{{ __('Placa') }}</label>
                        <input type="text" maxlength="8" name="sale[number]" 
                        id="input-number" class="form-control " 
                        placeholder="{{ __('Ingrese placa actual') }}" 
                        value="{{ (!is_null($car) ? $car->number : '') }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">	
                    <div class="form-group">
                        <label class="form-control-label" for="input-color">{{ __('Color') }}</label>
                        <div id="mainheaderColor">
                            <input type="text" maxlength="50" name="sale[color]" id="input-color" 
                                onkeydown="autocompleteAjax('mainheaderColor', 'input-color', 'color');"
                                class="form-control " 
                                placeholder="{{ __('Ingrese color') }}" 
                                value="{{ (!is_null($car) ? $car->color : '') }}" 
                                readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-brand">{{ __('Marca') }}</label>
                        <div id="mainheaderBrand">
                            <input type="text" maxlength="50" name="sale[brand]" id="input-brand" 
                                onkeydown="autocompleteAjax('mainheaderBrand', 'input-brand', 'brand');
                                    cleanChilds(['input-model']);"
                                class="form-control " 
                                placeholder="{{ __('Ingrese marca del vehículo') }}" 
                                value="{{ (!is_null($car) ? $car->brand : '') }}" 
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-model">{{ __('Modelo') }}</label>
                        <div id="mainheaderModel">
                            <input type="text" maxlength="50" name="sale[model]" id="input-model" 
                                onkeydown="autocompleteAjax('mainheaderModel', 'input-model', 'model', 'input-brand', 'brand');"
                                class="form-control " 
                                placeholder="{{ __('Ingrese modelo') }}" 
                                value="{{ (!is_null($car) ? $car->model : '') }}" 
                                readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-fab_year">{{ __('Año fabricación') }}</label>
                        <input type="text" name="sale[fab_year]" id="input-fab_year" 
                        min="1900" max="{{ date('Y') }}" class="form-control " 
                        placeholder="{{ __('Ingrese año de fabricación') }}" 
                        value="{{ (!is_null($car) ? $car->fab_year : '') }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-model_year">{{ __('Año modelo') }}</label>
                        <input type="text" name="sale[model_year]" id="input-model_year" 
                        min="1900" max="{{ date('Y') }}" class="form-control " 
                        placeholder="{{ __('Ingrese año de modelo') }}" 
                        value="{{ (!is_null($car) ? $car->model_year : '') }}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-holder">{{ __('Titular') }}</label>
                <div id="mainheaderHolder">
                    <input type="text" maxlength="200" name="sale[holder]" id="input-holder" 
                        onkeydown="autocompleteAjax('mainheaderHolder', 'input-holder', 'holder', null, null, 'clients');"
                        class="form-control " 
                        placeholder="{{ __('Ingrese titular del vehículo') }}" 
                        value="{{ (!is_null($car) ? $car->holder : '') }}" 
                        readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-owner">{{ __('Dueño') }}</label>
                <div id="mainheaderOwner">
                    <input type="text" maxlength="200" name="sale[owner]" id="input-owner" 
                        onkeydown="autocompleteAjax('mainheaderOwner', 'input-owner', 'owner', null, null, 'clients');"
                        class="form-control " 
                        placeholder="{{ __('Ingrese dueño del vehículo') }}" 
                        value="{{ (!is_null($car) ? $car->owner : '') }}" 
                        readonly>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <input type="hidden" name="sale[currency]" value="USD">
            <input type="hidden" id="cost_without_taxes" value="{{ isset($car) ? $car->cost_without_taxes : 0 }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-price_compra">{{ __('Precio compra (USD)') }}</label>
                        <input type="text" name="sale[price_compra]" id="input-price_compra" class="form-control " placeholder="{{ __('Ingrese precio de compra') }}" value="{{ (!is_null($car) ? $car->price_compra : 0) }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-price_sale">{{ __('Precio de venta (USD)') }}</label>
                        <input type="text" name="sale[price_sale]" id="input-price_sale" class="form-control " placeholder="{{ __('Ingrese precio de venta') }}" value="{{ (!is_null($car) ? $car->price_sale : 0) }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-control-label" for="input-price_expenses">{{ __('Total de gastos (USD)') }}</label>
                        <input type="text" name="sale[price_expenses]" id="input-price_expenses" class="form-control " placeholder="{{ __('Total de gastos') }}" value="{{ (!is_null($car) ? $car->total_expenses : 0) }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-control-label" for="input-total_cost">{{ __('Costo total del vehículo (USD)') }}</label>
                        <input type="text" name="sale[total_cost]" id="input-total_cost" class="form-control " placeholder="{{ __('Costo total del vehículo') }}" value="{{ (!is_null($car) ? $car->total_cost : 0) }}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-control-label" for="input-purchase_invoiced">{{ __('Monto Facturable de compra') }}</label>
                        <input type="text" name="sale[purchase_invoiced]" id="input-purchase_invoiced" class="form-control " placeholder="{{ __('Ingrese monto facturable de compra') }}" value="{{ (!is_null($car) ? $car->invoiced : 0) }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-control-label" for="input-invoiced">{{ __('Monto Facturable de venta') }}</label>
                        <input type="text" name="sale[total_invoiced]" onkeyup="updateExpensesValues(this);" id="input-invoiced" class="form-control " placeholder="{{ __('Ingrese monto facturable de venta') }}" value="{{ (!is_null($sale) ? $sale->total_invoiced : 0) }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="hidden" id="expenses_igv_detail" name="expenses[igv_detail]" value="0">
                        <label class="form-control-label" for="input-expenses_igv_amount" id="label-expenses_igv_amount">{{ __('IGV TOTAL') }}</label>
                        <input type="text" name="expenses[igv]" id="input-expenses_igv_amount" class="form-control " placeholder="{{ __('Total igv') }}" value="{{ (!is_null($car) ? $car->igv_amount : 0) }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="input-expenses_rent_amount" id="label-expenses_rent_amount">{{ __('RENTA TOTAL') }}</label>
                        <input type="text" name="expenses[rent]" id="input-expenses_rent_amount" class="form-control " placeholder="{{ __('Total igv') }}" value="{{ (!is_null($car) ? $car->rent_amount : 0) }}" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-notary">{{ __('Notaria') }}</label>
                <div id="mainheaderNotary">
                    <input type="text" maxlength="200" name="sale[notary]" id="input-notary" 
                        onkeydown="autocompleteAjax('mainheaderNotary', 'input-notary', 'notary');"
                        class="form-control " 
                        placeholder="{{ __('Ingrese notaria del trámite') }}" 
                        value="{{ (!is_null($sale) ? $sale->notary : '') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-n_kardex">{{ __('N° de kardex') }}</label>
                <input type="text" maxlength="25" name="sale[n_kardex]" id="input-n_kardex" 
                    class="form-control " placeholder="{{ __('Ingrese número de kardex') }}"
                    value="{{ (!is_null($sale) ? $sale->n_kardex : '') }}">
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-n_title">{{ __('N° de título') }}</label>
                <input type="text" maxlength="25" name="sale[n_title]" id="input-n_title" 
                    class="form-control " placeholder="{{ __('Ingrese número de título') }}"
                    value="{{ (!is_null($sale) ? $sale->n_title : '') }}">
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-saled_by">{{ __('VENDEDOR') }}</label>
                <select name="sale[saled_by]" id="input-saled_by" class="form-control " required>
                    @foreach ($users as $userKey => $userValue)
                        @if ((int)$sale->saled_by === $userValue->id)
                            <option selected value="{{ $userValue->id }}">{{ $userValue->name }} {{ $userValue->lastname }}</option>
                        @else
                            <option value="{{ $userValue->id }}">{{ $userValue->name }} {{ $userValue->lastname }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-posted_by">{{ __('PUBLICADOR') }}</label>
                <select name="sale[posted_by]" id="input-posted_by" class="form-control " required>
                    @foreach ($users as $userKey => $userValue)
                        @if ((int)$sale->posted_by === $userValue->id)
                            <option selected value="{{ $userValue->id }}">{{ $userValue->name }} {{ $userValue->lastname }}</option>
                        @else
                            <option value="{{ $userValue->id }}">{{ $userValue->name }} {{ $userValue->lastname }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="input-holder">{{ __('Comprador') }}</label>
                <div id="mainheaderOwnerFrom">
                    <input type="hidden" name="clients[owner-from_id]" id="owner-from_id"
                        value='{{ !is_null($sale->Client) ? $sale->Client->id : null }}'>
                    <input type="text" maxlength="200" name="clients[owner-from]" id="input-owner-from" 
                        onkeydown="autocompleteAjax('mainheaderOwnerFrom', 'input-owner-from', 'owner-from', null, null, 'clients');"
                        class="form-control " 
                        placeholder="{{ __('Ingrese comprador del vehículo') }}"
                        value='{{ !is_null($sale->Client) ? ($sale->Client->name !== "" ? $sale->Client->name : "CLIENTE GENERICO") : "--" }}'>
                </div>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="col-md-12">
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                        <!-- true, true, ['ti_1'] -->
                </div>
                <br>
            </div>
        </div>

    </div>
</div>