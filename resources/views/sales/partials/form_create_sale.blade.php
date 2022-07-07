<div class="col-12">
    <div class="form-group">
        @if (!is_null($reservation) && !is_null($reservation->client))
            <label class="form-control-label" for="">{{ __('Cliente') }}</label>
            <input type="hidden" id="input-client_name_id" value="{{ $reservation->client->id }}">
            <input type="text" maxlength="200" name="client_name" id="input-client_name" 
                class="form-control" 
                placeholder="{{ __('Nombre de cliente') }}" 
                value="{{ (!is_null($reservation) ? $reservation->client->names : '') }}" 
                readonly>
                <br>
            <label class="form-control-label" for="">{{ __('Documentos del cliente') }}</label>
            <div class="row">
                <div class="col-md-6">
                    <select name="client_type_document" id="input-client_type_document" class="form-control">
                        <option value="01">DNI</option>
                        <option value="04">CEX</option>
                        <option value="07">PAS</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" maxlength="200" name="client_document_number" id="input-client_document_number" 
                        class="form-control" 
                        placeholder="{{ __('Número de documento') }}" 
                        value="{{ (!is_null($reservation) ? $reservation->client->document_number : '') }}" >
                </div>
            </div>
        @else
            <label class="form-control-label" for="">{{ __('Cliente') }}</label>
            <div>
                <div id="mainheaderClient">
                    <input type="hidden" id="input-client_name_id" value="">
                    <input type="text" maxlength="200" name="purchase[holder]" id="input-client_name" 
                        onkeyup="autocompleteAjaxForClient('mainheaderClient', 'input-client_name', 'holder', null, null, 'clients');"
                        class="form-control" 
                        placeholder="{{ __('Ingrese nombre de la persona que reserva.') }}"
                        autocomplete="off">
                </div>
            </div>
            <br>
            <label class="form-control-label" for="">{{ __('Documentos del cliente') }}</label>
            <div class="row">
                <div class="col-md-6">
                    <select name="client_type_document" id="input-client_type_document" class="form-control">
                        <option value="01">DNI</option>
                        <option value="04">CEX</option>
                        <option value="07">PAS</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" maxlength="200" name="client_document_number" id="input-client_document_number" 
                        class="form-control" 
                        placeholder="{{ __('Número de documento') }}" 
                        value="" >
                </div>
            </div>
        @endif
            <div class="row">
                <div class="col-md-6">
                <br>
                    <label class="form-control-label" for="">{{ __('Tipo de comprobante') }}</label>
                    <select name="type_document" id="input-type_document" class="form-control">
                        <option value="00">Ticket interno</option>
                        <option value="03">BOLETA</option>
                    </select>
                </div>
                <div class="col-md-6">
                <br>
                    <label class="form-control-label" for="">{{ __('RUC de comprobante') }}</label>
                    <select name="document_number" id="input-document_number" class="form-control">
                        @foreach ($rucs as $keyR => $valueR)
                            <option value="{{ $valueR->id }}">{{ $valueR->document_number }} {{ $valueR->name }} (Total BOLETAS {{ date("M Y") }}: S/ {{ number_format($valueR->amount_pr_period, 2) }})</option>
                        @endforeach
                    </select>
                </div>
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