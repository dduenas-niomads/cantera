<div class="col-12">
    <div class="form-group">
        <label for="" class="">Datos del cliente</label>
        <div class="row">
            <div class="col-md-2">
                <label class="form-control-label" for="">{{ __('Tipo de documento') }}</label>
                <select name="client_type_document" id="input-client_type_document" class="form-control">
                    <option value="01">DNI</option>
                    <option value="06">RUC</option>
                    <option value="04">CEX</option>
                    <option value="07">PAS</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-control-label" for="">{{ __('N° de documento') }}</label>
                <input type="number" maxlength="20" name="client_document_number" id="input-client_document_number" 
                    class="form-control" 
                    placeholder="{{ __('Número de documento') }}" 
                    value="{{ (!is_null($reservation) ? $reservation->client->document_number : '') }}"
                    onclick="this.select();" >
            </div>
            <div class="col-md-4">
                <label class="form-control-label" for="">{{ __('Correo electrónico') }}</label>
                <input type="text" maxlength="100" name="client_email" id="input-client_email" 
                    class="form-control" 
                    placeholder="{{ __('Correo electrónico del cliente') }}" 
                    value="" >
            </div>
            <div class="col-md-2" style="margin-top: 2rem !important;">
                <button class="btn btn-default" type="button" onclick="searchForClientByDocument();">Buscar cliente</button>
            </div>
        </div>
        <div>
            <br>
            <label class="form-control-label" for="">{{ __('Nombre completo') }}</label>
            <div id="mainheaderClient">
                @if (!is_null($reservation) && !is_null($reservation->client))
                <input type="hidden" id="input-client_name_id" value="{{ $reservation->client->id }}">
                <input type="text" maxlength="200" name="client_name" id="input-client_name" 
                    class="form-control" 
                    placeholder="{{ __('Con este nombre se mostrará en el comprobante.') }}" 
                    value="{{ (!is_null($reservation) ? $reservation->client->names : '') }}" 
                    readonly>
                @else
                <input type="hidden" id="input-client_name_id">
                <input type="text" maxlength="200" name="purchase[holder]" id="input-client_name" 
                    onkeyup="autocompleteAjaxForClient('mainheaderClient', 'input-client_name', 'holder', null, null, 'clients');"
                    class="form-control" 
                    placeholder="{{ __('Con este nombre se mostrará en el comprobante.') }}"
                    autocomplete="off">
                @endif
            </div>
        </div>
        <br>
        <label for="" class="">Datos de la venta</label>
        <div class="row">
            <div class="col-md-4">
                <label class="form-control-label" for="">{{ __('Tipo de comprobante') }}</label>
                <select name="type_document" id="input-type_document" class="form-control">
                    <option value="00">Ticket interno</option>
                    <option value="03">BOLETA</option>
                    <option value="01">FACTURA</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-control-label" for="">{{ __('Documento emisor') }}</label>
                <select name="document_number" id="input-document_number" class="form-control">
                    @foreach ($rucs as $keyR => $valueR)
                        <option value="{{ $valueR->id }}">{{ $valueR->document_number }} {{ $valueR->name }} (Total BOLETAS {{ date("M Y") }}: S/ {{ number_format($valueR->amount_pr_period, 2) }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-control-label" for="">{{ __('Enviar por correo') }}</label>
                <select name="type_document" id="input-type_document" class="form-control">
                    <option value="1">Sí</option>
                    <option value="0" selected>No</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                <button type="button" class="btn btn-success" 
                    onclick="stepperValidation();">Continuar</button>
                    <!-- true, true, ['ti_1'] -->
            </div>
        </div>
    </div>
</div>