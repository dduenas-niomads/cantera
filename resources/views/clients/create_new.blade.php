@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
@endpush

@section('href_title_name')
/clients
@endsection
@section('view_title_name')
Módulo de clientes
@endsection

@section('nav-clients')
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
							<h3 class="mb-0">Nuevo cliente</h3>
						</div>
					</div>
				</div>
				<div class="col-12">
					<form method="post" action="{{ route('clients.store') }}" autocomplete="off">
						@csrf
						@method('post')
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-control-label" for="input-type">{{ __('Tipo de cliente') }}</label>
									<select name="type" onchange="changeDiv();" id="input-type" class="form-control " required>
										<option selected value="1">PERSONA NATURAL</option>
										<option value="2">EMPRESA</option>
									</select>
								</div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-type_document">{{ __('Tipo de documento') }}</label>
                                            <select name="type_document" id="input-type_document" class="form-control ">
                                                <option value="01">DNI</option>
                                                <option value="04">CARNET DE EXTRANJERIA</option>
                                                <option value="07">PASAPORTE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-document_number">{{ __('N° de documento') }}</label>
                                            <input type="text" name="document_number" id="input-document_number" class="form-control " 
                                                placeholder="{{ __('Ingrese n° documento') }}" value="">
                                        </div>
                                    </div>
                                </div>
								<div id="personDiv">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-names">{{ __('Nombres') }}</label>
                                        <input type="text" maxlength="100" name="names" id="input-names" class="form-control " 
                                            placeholder="{{ __('Ingrese nombres') }}" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first_lastname">{{ __('Apellido paterno') }}</label>
                                        <input type="text" maxlength="100" name="first_lastname" id="input-first_lastname" class="form-control " 
                                            placeholder="{{ __('Ingrese apellido paterno') }}" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-second_lastname">{{ __('Apellido materno') }}</label>
                                        <input type="text" maxlength="100" name="second_lastname" id="input-second_lastname" class="form-control " 
                                            placeholder="{{ __('Ingrese apellido materno') }}" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-birthday">{{ __('Fecha de nacimiento') }}</label>
                                        <div class="input-group input-group-merge">
                                            <input class="form-control datepicker" name="birthday" id="input-birthday" placeholder="Seleccione una fecha" type="text" maxlength="0">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="companyDiv" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-rz_social">{{ __('Razón social') }}</label>
                                        <input type="text" maxlength="100" name="rz_social" id="input-rz_social" class="form-control " 
                                            placeholder="{{ __('Ingrese razón social') }}" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-commercial_name">{{ __('Nombre comercial') }}</label>
                                        <input type="text" maxlength="100" name="commercial_name" id="input-commercial_name" class="form-control " 
                                            placeholder="{{ __('Ingrese nombre comercial') }}" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-rl_name">{{ __('Representante legal') }}</label>
                                        <input type="text" maxlength="100" name="rl_name" id="input-rl_name" class="form-control " 
                                            placeholder="{{ __('Ingrese nombre rep. legal') }}" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-rl_document_number">{{ __('N° documento rep. legal') }}</label>
                                        <input type="text" maxlength="100" name="rl_document_number" id="input-rl_document_number" class="form-control " 
                                            placeholder="{{ __('Ingrese documento rep. legal') }}" value="">
                                    </div>
                                </div>
							</div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-department">{{ __('Departamento') }}</label>
									<div id="mainheaderDepartment">
										<input type="text" maxlength="100" name="department" id="input-department" 
											onkeydown="autocompleteAjax('mainheaderDepartment', 'input-department', 'department');
                                                cleanChilds(['input-province', 'input-district']);"
											class="form-control " 
											placeholder="{{ __('Ingrese un departamento') }}" 
											value="" 
											required>
									</div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-province">{{ __('Provincia') }}</label>
                                    <div id="mainheaderProvince">
                                        <input type="text" maxlength="100" name="province" id="input-province" 
                                            onkeydown="autocompleteAjax('mainheaderProvince', 'input-province', 'province', 'input-department', 'department');
                                                cleanChilds(['input-district']);"
                                            class="form-control  danger" 
                                            placeholder="{{ __('Ingrese una provincia') }}" 
                                            value="" 
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-district">{{ __('Distrito') }}</label>
                                    <div id="mainheaderDistrict">
                                        <input type="text" maxlength="100" name="district" id="input-district" 
                                            onkeydown="autocompleteAjax('mainheaderDistrict', 'input-district', 'district', 'input-province', 'province');"
                                            class="form-control " 
                                            placeholder="{{ __('Ingrese un distrito') }}" 
                                            value="" 
                                            required>
                                    </div>
                                </div>
								<div class="form-group">
									<label class="form-control-label" for="input-address">{{ __('Dirección') }}</label>
									<input type="text" maxlength="200" name="address" id="input-address" class="form-control " 
                                        placeholder="{{ __('Ingrese dirección') }}" value="">
								</div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-phone">{{ __('Celular') }}</label>
                                            <input type="text" maxlength="25" name="phone" id="input-phone" class="form-control " 
                                                placeholder="{{ __('Ingrese n° de celular') }}" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-phone_2">{{ __('Teléfono fijo') }}</label>
                                            <input type="text" maxlength="25" name="phone_2" id="input-phone_2" class="form-control " 
                                                placeholder="{{ __('Ingrese n° de teléfono fijo') }}" value="" required>
                                        </div>
                                    </div>
                                </div>
								<div class="form-group">
									<label class="form-control-label" for="input-email">{{ __('Correo electrónico') }}</label>
									<input type="email" maxlength="100" name="email" id="input-email" class="form-control " 
                                        placeholder="{{ __('Ingrese correo electrónico') }}" value="">
								</div>
								<div class="form-group">
									<label class="form-control-label" for="input-comentary">{{ __('Comentarios') }}</label>
									<input type="text" maxlength="200" name="comentary" id="input-comentary" class="form-control " 
                                        placeholder="{{ __('Ingrese un comentario adicional') }}" value="">
								</div>
                            </div>
							<div class="col-md-12 row">
								<div class="col-md-12">
									<div class="text-center">
										<button type="submit" 
											class="btn btn-success mt-4">{{ __('Registrar cliente') }}</button>
									</div>
									<br>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="card-footer py-4">
					<nav class="d-flex justify-content-end" aria-label="...">
					</nav>
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