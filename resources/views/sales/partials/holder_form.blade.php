<div class="col-md-6">
    <div class="col-12">
        <h3 class="">Información del titular</h3>
            @if (!is_null($holder))
                <input type="hidden" name="clients[holder][id]" value="{{ $holder->id }}">
                <div class="form-group">
                    <label class="form-control-label" for="input-type">{{ __('Tipo de cliente') }}</label>
                    <select name="clients[holder][type]" onchange="changeDiv(false, 'holderPersonDiv', 'holderCompanyDiv');" id="input-type" class="form-control ">
                        <option {{ ((int)$holder->type === 1) ? 'selected':'' }} value="1">PERSONA NATURAL</option>
                        <option {{ ((int)$holder->type === 2) ? 'selected':'' }} value="2">EMPRESA</option>
                    </select>
                </div>
                @if((int)$holder->type  === 1)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-type_document">{{ __('Tipo de documento') }}</label>
                                <select name="clients[holder][type_document]" id="input-type_document" class="form-control ">
                                    <option  {{ ($holder->type_document === "01") ? 'selected':'' }} value="01">DNI</option>
                                    <option  {{ ($holder->type_document === "04") ? 'selected':'' }} value="04">CARNET DE EXTRANJERIA</option>
                                    <option  {{ ($holder->type_document === "07") ? 'selected':'' }} value="07">PASAPORTE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-document_number">{{ __('N° de documento') }}</label>
                                <input type="number" name="clients[holder][document_number]" id="input-document_number" class="form-control " 
                                    placeholder="{{ __('Ingrese n° documento') }}" value="{{ $holder->document_number }}">
                            </div>
                        </div>
                    </div>
                    <div id="holderPersonDiv">
                        <div class="form-group">
                            <label class="form-control-label" for="input-names">{{ __('Nombres') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][names]" id="input-names" class="form-control " 
                                placeholder="{{ __('Ingrese nombres') }}" value="{{ $holder->names }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-first_lastname">{{ __('Apellido paterno') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][first_lastname]" id="input-first_lastname" class="form-control " 
                                placeholder="{{ __('Ingrese apellido paterno') }}" value="{{ $holder->first_lastname }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-second_lastname">{{ __('Apellido materno') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][second_lastname]" id="input-second_lastname" class="form-control " 
                                placeholder="{{ __('Ingrese apellido materno') }}" value="{{ $holder->second_lastname }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-birthday">{{ __('Fecha de nacimiento') }}</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control datepicker" name="clients[holder][birthday]" id="input-birthday" 
                                    placeholder="Seleccione una fecha" type="text" maxlength="0" value="{{ $holder->birthday }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="holderCompanyDiv" style="display: none;">
                        <div class="form-group">
                            <label class="form-control-label" for="input-rz_social">{{ __('Razón social') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][rz_social]" id="input-rz_social" class="form-control " 
                                placeholder="{{ __('Ingrese razón social') }}" value="{{ $holder->rz_social }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-commercial_name">{{ __('Nombre comercial') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][commercial_name]" id="input-commercial_name" class="form-control " 
                                placeholder="{{ __('Ingrese nombre comercial') }}" value="{{ $holder->commercial_name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-rl_name">{{ __('Representante legal') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][rl_name]" id="input-rl_name" class="form-control " 
                                placeholder="{{ __('Ingrese nombre rep. legal') }}" value="{{ $holder->rl_name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-rl_document_number">{{ __('N° documento rep. legal') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][rl_document_number]" id="input-rl_document_number" class="form-control " 
                                placeholder="{{ __('Ingrese documento rep. legal') }}" value="{{ $holder->rl_document_number }}">
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-type_document">{{ __('Tipo de documento') }}</label>
                                <select name="clients[holder][type_document]" id="input-type_document" class="form-control ">
                                    <option  {{ ($holder->type_document === "06") ? 'selected':'' }} value="06">RUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-document_number">{{ __('N° de documento') }}</label>
                                <input type="number" name="clients[holder][document_number]" id="input-document_number" class="form-control " 
                                    placeholder="{{ __('Ingrese n° documento') }}" value="{{ $holder->document_number }}">
                            </div>
                        </div>
                    </div>
                    <div id="holderPersonDiv" style="display: none;">
                        <div class="form-group">
                            <label class="form-control-label" for="input-names">{{ __('Nombres') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][names]" id="input-names" class="form-control " 
                                placeholder="{{ __('Ingrese nombres') }}" value="{{ $holder->names }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-first_lastname">{{ __('Apellido paterno') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][first_lastname]" id="input-first_lastname" class="form-control " 
                                placeholder="{{ __('Ingrese apellido paterno') }}" value="{{ $holder->first_lastname }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-second_lastname">{{ __('Apellido materno') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][second_lastname]" id="input-second_lastname" class="form-control " 
                                placeholder="{{ __('Ingrese apellido materno') }}" value="{{ $holder->second_lastname }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-birthday">{{ __('Fecha de nacimiento') }}</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control datepicker" name="clients[holder][birthday]" id="input-birthday" 
                                    placeholder="Seleccione una fecha" type="text" maxlength="0" value="{{ $holder->birthday }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="holderCompanyDiv">
                        <div class="form-group">
                            <label class="form-control-label" for="input-rz_social">{{ __('Razón social') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][rz_social]" id="input-rz_social" class="form-control " 
                                placeholder="{{ __('Ingrese razón social') }}" value="{{ $holder->rz_social }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-commercial_name">{{ __('Nombre comercial') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][commercial_name]" id="input-commercial_name" class="form-control " 
                                placeholder="{{ __('Ingrese nombre comercial') }}" value="{{ $holder->commercial_name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-rl_name">{{ __('Representante legal') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][rl_name]" id="input-rl_name" class="form-control " 
                                placeholder="{{ __('Ingrese nombre rep. legal') }}" value="{{ $holder->rl_name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-rl_document_number">{{ __('N° documento rep. legal') }}</label>
                            <input type="text" maxlength="100" name="clients[holder][rl_document_number]" id="input-rl_document_number" class="form-control " 
                                placeholder="{{ __('Ingrese documento rep. legal') }}" value="{{ $holder->rl_document_number }}">
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label class="form-control-label" for="input-address">{{ __('Dirección') }}</label>
                    <input type="text" maxlength="200" name="clients[holder][address]" id="input-address" class="form-control " 
                        placeholder="{{ __('Ingrese dirección') }}" value="{{ $holder->address }}">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-phone">{{ __('Celular') }}</label>
                            <input type="text" maxlength="25" name="clients[holder][phone]" id="input-phone" class="form-control " 
                                placeholder="{{ __('Ingrese n° de celular') }}" value="{{ $holder->phone }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-phone_2">{{ __('Teléfono fijo') }}</label>
                            <input type="text" maxlength="25" name="clients[holder][phone_2]" id="input-phone_2" class="form-control " 
                                placeholder="{{ __('Ingrese n° de teléfono fijo') }}" value="{{ $holder->phone_2 }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="input-email">{{ __('Correo electrónico') }}</label>
                    <input type="email" maxlength="100" name="clients[holder][email]" id="input-email" class="form-control " 
                        placeholder="{{ __('Ingrese correo electrónico') }}" value="{{ $holder->email }}">
                </div>
            @else
                <input type="hidden" name="clients[holder][id]" value="0">
                <div class="form-group">
                    <label class="form-control-label" for="input-type">{{ __('Tipo de cliente') }}</label>
                    <select name="clients[holder][type]" onchange="changeDiv(true, 'holderPersonDiv', 'holderCompanyDiv');" id="input-type" class="form-control " required>
                        <option selected value="1">PERSONA NATURAL</option>
                        <option value="2">EMPRESA</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-type_document">{{ __('Tipo de documento') }}</label>
                            <select name="clients[holder][type_document]" id="input-type_document" class="form-control ">
                                <option value="01">DNI</option>
                                <option value="04">CARNET DE EXTRANJERIA</option>
                                <option value="07">PASAPORTE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-document_number">{{ __('N° de documento') }}</label>
                            <input type="number" name="clients[holder][document_number]" id="input-document_number" class="form-control " 
                                placeholder="{{ __('Ingrese n° documento') }}" value="">
                        </div>
                    </div>
                </div>
                <div id="holderPersonDiv">
                    <div class="form-group">
                        <label class="form-control-label" for="input-names">{{ __('Nombres') }}</label>
                        <input type="text" maxlength="100" name="clients[holder][names]" id="input-names" class="form-control " 
                            placeholder="{{ __('Ingrese nombres') }}" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-first_lastname">{{ __('Apellido paterno') }}</label>
                        <input type="text" maxlength="100" name="clients[holder][first_lastname]" id="input-first_lastname" class="form-control " 
                            placeholder="{{ __('Ingrese apellido paterno') }}" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-second_lastname">{{ __('Apellido materno') }}</label>
                        <input type="text" maxlength="100" name="clients[holder][second_lastname]" id="input-second_lastname" class="form-control " 
                            placeholder="{{ __('Ingrese apellido materno') }}" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-birthday">{{ __('Fecha de nacimiento') }}</label>
                        <div class="input-group input-group-merge">
                            <input class="form-control datepicker" name="clients[holder][birthday]" id="input-birthday" placeholder="Seleccione una fecha" type="text" maxlength="0">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="holderCompanyDiv" style="display: none;">
                    <div class="form-group">
                        <label class="form-control-label" for="input-rz_social">{{ __('Razón social') }}</label>
                        <input type="text" maxlength="100" name="clients[holder][rz_social]" id="input-rz_social" class="form-control " 
                            placeholder="{{ __('Ingrese razón social') }}" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-commercial_name">{{ __('Nombre comercial') }}</label>
                        <input type="text" maxlength="100" name="clients[holder][commercial_name]" id="input-commercial_name" class="form-control " 
                            placeholder="{{ __('Ingrese nombre comercial') }}" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-rl_name">{{ __('Representante legal') }}</label>
                        <input type="text" maxlength="100" name="clients[holder][rl_name]" id="input-rl_name" class="form-control " 
                            placeholder="{{ __('Ingrese nombre rep. legal') }}" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-rl_document_number">{{ __('N° documento rep. legal') }}</label>
                        <input type="text" maxlength="100" name="clients[holder][rl_document_number]" id="input-rl_document_number" class="form-control " 
                            placeholder="{{ __('Ingrese documento rep. legal') }}" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-phone">{{ __('Celular') }}</label>
                            <input type="text" maxlength="25" name="clients[holder][phone]" id="input-phone" class="form-control " 
                                placeholder="{{ __('Ingrese n° de celular') }}" value="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-phone_2">{{ __('Teléfono fijo') }}</label>
                            <input type="text" maxlength="25" name="clients[holder][phone_2]" id="input-phone_2" class="form-control " 
                                placeholder="{{ __('Ingrese n° de teléfono fijo') }}" value="" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="input-email">{{ __('Correo electrónico') }}</label>
                    <input type="email" maxlength="100" name="clients[holder][email]" id="input-email" class="form-control " 
                        placeholder="{{ __('Ingrese correo electrónico') }}" value="">
                </div>
            @endif
    </div>
</div>