<div class="col-md-6">
    <div class="col-12">
        <h3 class="">Información del dueño</h3>
            @if (!is_null($owner))
                <input type="hidden" id="input-owner_id" name="clients[owner][id]" value="{{ $owner->id }}">
                <div class="form-group">
                    <label class="form-control-label" for="input-type">{{ __('Tipo de cliente') }}</label>
                    <select name="clients[owner][type]" 
                        onchange="changeDiv(false, 'ownerPersonDiv', 'ownerCompanyDiv', 'input-owner_type', 'input-owner_type_document');" 
                        id="input-owner_type" class="form-control ">
                        <option {{ ((int)$owner->type === 1) ? 'selected':'' }} value="1">PERSONA NATURAL</option>
                        <option {{ ((int)$owner->type === 2) ? 'selected':'' }} value="2">EMPRESA</option>
                    </select>
                </div>
                @if((int)$owner->type  === 1)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-type_document">{{ __('Tipo de documento') }}</label>
                                <select name="clients[owner][type_document]" id="input-owner_type_document" class="form-control ">
                                    <option  {{ ($owner->type_document === "01") ? 'selected':'' }} value="01">DNI</option>
                                    <option  {{ ($owner->type_document === "04") ? 'selected':'' }} value="04">CARNET DE EXTRANJERIA</option>
                                    <option  {{ ($owner->type_document === "07") ? 'selected':'' }} value="07">PASAPORTE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-document_number">{{ __('N° de documento') }}</label>
                                <input type="number" name="clients[owner][document_number]" id="input-owner_document_number" class="form-control " 
                                    placeholder="{{ __('Ingrese n° documento') }}" value="{{ $owner->document_number }}">
                            </div>
                        </div>
                    </div>
                    <div id="ownerPersonDiv">
                        <div class="form-group">
                            <label class="form-control-label" for="input-names">{{ __('Nombres') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][names]" id="input-owner_names" class="form-control " 
                                placeholder="{{ __('Ingrese nombres') }}" value="{{ $owner->names }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-first_lastname">{{ __('Apellido paterno') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][first_lastname]" id="input-owner_first_lastname" class="form-control " 
                                placeholder="{{ __('Ingrese apellido paterno') }}" value="{{ $owner->first_lastname }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-second_lastname">{{ __('Apellido materno') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][second_lastname]" id="input-owner_second_lastname" class="form-control " 
                                placeholder="{{ __('Ingrese apellido materno') }}" value="{{ $owner->second_lastname }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-birthday">{{ __('Fecha de nacimiento') }}</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control datepicker" name="clients[owner][birthday]" id="input-owner_birthday" 
                                    placeholder="Seleccione una fecha" type="text" maxlength="0" value="{{ $owner->birthday }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="ownerCompanyDiv" style="display: none;">
                        <div class="form-group">
                            <label class="form-control-label" for="input-rz_social">{{ __('Razón social') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][rz_social]" id="input-owner_rz_social" class="form-control " 
                                placeholder="{{ __('Ingrese razón social') }}" value="{{ $owner->rz_social }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-commercial_name">{{ __('Nombre comercial') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][commercial_name]" id="input-owner_commercial_name" class="form-control " 
                                placeholder="{{ __('Ingrese nombre comercial') }}" value="{{ $owner->commercial_name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-rl_name">{{ __('Representante legal') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][rl_name]" id="input-owner_rl_name" class="form-control " 
                                placeholder="{{ __('Ingrese nombre rep. legal') }}" value="{{ $owner->rl_name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-rl_document_number">{{ __('N° documento rep. legal') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][rl_document_number]" id="input-owner_rl_document_number" class="form-control " 
                                placeholder="{{ __('Ingrese documento rep. legal') }}" value="{{ $owner->rl_document_number }}">
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-type_document">{{ __('Tipo de documento') }}</label>
                                <select name="clients[owner][type_document]" id="input-owner_type_document" class="form-control ">
                                    <option  {{ ($owner->type_document === "06") ? 'selected':'' }} value="06">RUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-document_number">{{ __('N° de documento') }}</label>
                                <input type="number" name="clients[owner][document_number]" id="input-owner_document_number" class="form-control " 
                                    placeholder="{{ __('Ingrese n° documento') }}" value="{{ $owner->document_number }}">
                            </div>
                        </div>
                    </div>
                    <div id="ownerPersonDiv" style="display: none;">
                        <div class="form-group">
                            <label class="form-control-label" for="input-names">{{ __('Nombres') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][names]" id="input-owner_names" class="form-control " 
                                placeholder="{{ __('Ingrese nombres') }}" value="{{ $owner->names }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-first_lastname">{{ __('Apellido paterno') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][first_lastname]" id="input-owner_first_lastname" class="form-control " 
                                placeholder="{{ __('Ingrese apellido paterno') }}" value="{{ $owner->first_lastname }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-second_lastname">{{ __('Apellido materno') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][second_lastname]" id="input-owner_second_lastname" class="form-control " 
                                placeholder="{{ __('Ingrese apellido materno') }}" value="{{ $owner->second_lastname }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-birthday">{{ __('Fecha de nacimiento') }}</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control datepicker" name="clients[owner][birthday]" id="input-owner_birthday" 
                                    placeholder="Seleccione una fecha" type="text" maxlength="0" value="{{ $owner->birthday }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="ownerCompanyDiv">
                        <div class="form-group">
                            <label class="form-control-label" for="input-rz_social">{{ __('Razón social') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][rz_social]" id="input-owner_rz_social" class="form-control " 
                                placeholder="{{ __('Ingrese razón social') }}" value="{{ $owner->rz_social }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-commercial_name">{{ __('Nombre comercial') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][commercial_name]" id="input-owner_commercial_name" class="form-control " 
                                placeholder="{{ __('Ingrese nombre comercial') }}" value="{{ $owner->commercial_name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-rl_name">{{ __('Representante legal') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][rl_name]" id="input-owner_rl_name" class="form-control " 
                                placeholder="{{ __('Ingrese nombre rep. legal') }}" value="{{ $owner->rl_name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-rl_document_number">{{ __('N° documento rep. legal') }}</label>
                            <input type="text" maxlength="100" name="clients[owner][rl_document_number]" id="input-owner_rl_document_number" class="form-control " 
                                placeholder="{{ __('Ingrese documento rep. legal') }}" value="{{ $owner->rl_document_number }}">
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label class="form-control-label" for="input-address">{{ __('Dirección') }}</label>
                    <input type="text" maxlength="200" name="clients[owner][address]" id="input-owner_address" class="form-control " 
                        placeholder="{{ __('Ingrese dirección') }}" value="{{ $owner->address }}">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-phone">{{ __('Celular') }}</label>
                            <input type="text" maxlength="25" name="clients[owner][phone]" id="input-owner_phone" class="form-control " 
                                placeholder="{{ __('Ingrese n° de celular') }}" value="{{ $owner->phone }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-phone_2">{{ __('Teléfono fijo') }}</label>
                            <input type="text" maxlength="25" name="clients[owner][phone_2]" id="input-owner_phone_2" class="form-control " 
                                placeholder="{{ __('Ingrese n° de teléfono fijo') }}" value="{{ $owner->phone_2 }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="input-email">{{ __('Correo electrónico') }}</label>
                    <input type="email" maxlength="100" name="clients[owner][email]" id="input-owner_email" class="form-control " 
                        placeholder="{{ __('Ingrese correo electrónico') }}" value="{{ $owner->email }}">
                </div>
            @else
                <input type="hidden" id="input-owner_id" name="clients[owner][id]" value="0">
                <div class="form-group">
                    <label class="form-control-label" for="input-type">{{ __('Tipo de cliente') }}</label>
                    <select name="clients[owner][type]" onchange="changeDiv(true, 'ownerPersonDiv', 'ownerCompanyDiv', 'input-owner_type', 'input-owner_type_document');"
                        id="input-owner_type" class="form-control " required>
                        <option selected value="1">PERSONA NATURAL</option>
                        <option value="2">EMPRESA</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-type_document">{{ __('Tipo de documento') }}</label>
                            <select name="clients[owner][type_document]" id="input-owner_type_document" class="form-control ">
                                <option value="01">DNI</option>
                                <option value="04">CARNET DE EXTRANJERIA</option>
                                <option value="07">PASAPORTE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-document_number">{{ __('N° de documento') }}</label>
                            <input type="number" name="clients[owner][document_number]" id="input-owner_document_number" class="form-control " 
                                placeholder="{{ __('Ingrese n° documento') }}" value="">
                        </div>
                    </div>
                </div>
                <div id="ownerPersonDiv">
                    <div class="form-group">
                        <label class="form-control-label" for="input-names">{{ __('Nombres') }}</label>
                        <input type="text" maxlength="100" name="clients[owner][names]" id="input-owner_names" class="form-control " 
                            placeholder="{{ __('Ingrese nombres') }}" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-first_lastname">{{ __('Apellido paterno') }}</label>
                        <input type="text" maxlength="100" name="clients[owner][first_lastname]" id="input-owner_first_lastname" class="form-control " 
                            placeholder="{{ __('Ingrese apellido paterno') }}" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-second_lastname">{{ __('Apellido materno') }}</label>
                        <input type="text" maxlength="100" name="clients[owner][second_lastname]" id="input-owner_second_lastname" class="form-control " 
                            placeholder="{{ __('Ingrese apellido materno') }}" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-birthday">{{ __('Fecha de nacimiento') }}</label>
                        <div class="input-group input-group-merge">
                            <input class="form-control datepicker" name="clients[owner][birthday]" id="input-owner_birthday" placeholder="Seleccione una fecha" type="text" maxlength="0">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="ownerCompanyDiv" style="display: none;">
                    <div class="form-group">
                        <label class="form-control-label" for="input-rz_social">{{ __('Razón social') }}</label>
                        <input type="text" maxlength="100" name="clients[owner][rz_social]" id="input-owner_rz_social" class="form-control " 
                            placeholder="{{ __('Ingrese razón social') }}" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-commercial_name">{{ __('Nombre comercial') }}</label>
                        <input type="text" maxlength="100" name="clients[owner][commercial_name]" id="input-owner_commercial_name" class="form-control " 
                            placeholder="{{ __('Ingrese nombre comercial') }}" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-rl_name">{{ __('Representante legal') }}</label>
                        <input type="text" maxlength="100" name="clients[owner][rl_name]" id="input-owner_rl_name" class="form-control " 
                            placeholder="{{ __('Ingrese nombre rep. legal') }}" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="input-rl_document_number">{{ __('N° documento rep. legal') }}</label>
                        <input type="text" maxlength="100" name="clients[owner][rl_document_number]" id="input-owner_rl_document_number" class="form-control " 
                            placeholder="{{ __('Ingrese documento rep. legal') }}" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-phone">{{ __('Celular') }}</label>
                            <input type="text" maxlength="25" name="clients[owner][phone]" id="input-owner_phone" class="form-control " 
                                placeholder="{{ __('Ingrese n° de celular') }}" value="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-phone_2">{{ __('Teléfono fijo') }}</label>
                            <input type="text" maxlength="25" name="clients[owner][phone_2]" id="input-owner_phone_2" class="form-control " 
                                placeholder="{{ __('Ingrese n° de teléfono fijo') }}" value="" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="input-email">{{ __('Correo electrónico') }}</label>
                    <input type="email" maxlength="100" name="clients[owner][email]" id="input-owner_email" class="form-control " 
                        placeholder="{{ __('Ingrese correo electrónico') }}" value="">
                </div>
            @endif
    </div>
</div>