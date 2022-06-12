@extends('layouts.app', ['class' => 'bg-dark'])

@section('href_title_name')
/taxations
@endsection

@section('view_title_name')
Tasación vehicular
@endsection

@section('nav-taxations')
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
							<h3 class="mb-0">Imágenes de la tasación: {{ str_pad($taxation->car_number, 6, "0", STR_PAD_LEFT) }}</h3>
						</div>
					</div>
				</div>
				<div class="col-12">
					<form method="post" action="{{ route('taxations.update-images', $taxation->id) }}" 
						autocomplete="off" id="updateForm" enctype="multipart/form-data">
						@csrf
						@method('put')
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-control-label" for="custom_image1">{{ __('Imagen 1') }}</label>
                                    <a href="{{ isset($taxation->progress_image_json['custom_image1'])? '/' . $taxation->progress_image_json['custom_image1']:'' }}" target="_blank">
										<img src="{{ isset($taxation->progress_image_json['custom_image1'])? '/' . $taxation->progress_image_json['custom_image1']:'' }}" height="50px" />
									</a><input type="file" class="form-control" name="custom_image1" id="custom_image1">
                                </div>
								<div class="form-group">
									<label class="form-control-label" for="custom_image2">{{ __('Imagen 2') }}</label>
                                    <a href="{{ isset($taxation->progress_image_json['custom_image2'])? '/' . $taxation->progress_image_json['custom_image2']:'' }}" target="_blank">
										<img src="{{ isset($taxation->progress_image_json['custom_image2'])? '/' . $taxation->progress_image_json['custom_image2']:'' }}" height="50px" />
									</a><input type="file" class="form-control" name="custom_image2" id="custom_image2">
                                </div>
								<div class="form-group">
									<label class="form-control-label" for="custom_image3">{{ __('Imagen 3') }}</label>
                                    <a href="{{ isset($taxation->progress_image_json['custom_image3'])? '/' . $taxation->progress_image_json['custom_image3']:'' }}" target="_blank">
										<img src="{{ isset($taxation->progress_image_json['custom_image3'])? '/' . $taxation->progress_image_json['custom_image3']:'' }}" height="50px" />
									</a><input type="file" class="form-control" name="custom_image3" id="custom_image3">
                                </div>
                            </div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-control-label" for="custom_image4">{{ __('Imagen 4') }}</label>
                                    <a href="{{ isset($taxation->progress_image_json['custom_image4'])? '/' . $taxation->progress_image_json['custom_image4']:'' }}" target="_blank">
										<img src="{{ isset($taxation->progress_image_json['custom_image4'])? '/' . $taxation->progress_image_json['custom_image4']:'' }}" height="50px" />
									</a><input type="file" class="form-control" name="custom_image4" id="custom_image4">
                                </div>
								<div class="form-group">
									<label class="form-control-label" for="custom_image5">{{ __('Imagen 5') }}</label>
                                    <a href="{{ isset($taxation->progress_image_json['custom_image5'])? '/' . $taxation->progress_image_json['custom_image5']:'' }}" target="_blank">
										<img src="{{ isset($taxation->progress_image_json['custom_image5'])? '/' . $taxation->progress_image_json['custom_image5']:'' }}" height="50px" />
									</a><input type="file" class="form-control" name="custom_image5" id="custom_image5">
                                </div>
								<div class="form-group">
									<label class="form-control-label" for="custom_image6">{{ __('Imagen 6') }}</label>
                                    <a href="{{ isset($taxation->progress_image_json['custom_image6'])? '/' . $taxation->progress_image_json['custom_image6']:'' }}" target="_blank">
										<img src="{{ isset($taxation->progress_image_json['custom_image6'])? '/' . $taxation->progress_image_json['custom_image6']:'' }}" height="50px" />
									</a><input type="file" class="form-control" name="custom_image6" id="custom_image6">
                                </div>
                            </div>
							<div class="col-md-12 row">
								<div class="col-md-12">
									<div class="text-center">
										<button type="button" 
                                            data-toggle="modal" data-target="#updateModal"
											class="btn btn-success mt-4">{{ __('Guardar cambios') }}</button>
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