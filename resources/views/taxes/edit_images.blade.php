@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
@endpush

@section('href_title_name')
/cars
@endsection

@section('view_title_name')
Módulo de vehículos
@endsection

@section('nav-cars')
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
							<h3 class="mb-0">Imágenes del vehículo: {{ $car->brand }}  {{ $car->model }}  ({{ $car->number }})</h3>
						</div>
					</div>
				</div>
				<div class="col-12">
					<form method="post" action="{{ route('cars.update-images', $car->id) }}" 
						autocomplete="off" id="updateForm" enctype="multipart/form-data">
						@csrf
						@method('put')
						<div class="row">
							<div class="col-md-6">
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image1">{{ __('Imagen 1 (Principal)') }}</label>								
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image1'])? '/' . $car->images_json['custom_image1'] : '#' }}" target="_blank">
											<img id="image_custom_image1" src="{{ isset($car->images_json['custom_image1'])? '/' . $car->images_json['custom_image1'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image1']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image1');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image1" id="custom_image1"  accept="image/*" onchange="validateWeight(this);">
									</div>
                                </div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image2">{{ __('Imagen 2') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image2'])? '/' . $car->images_json['custom_image2'] : '#' }}" target="_blank">
											<img id="image_custom_image2" src="{{ isset($car->images_json['custom_image2'])? '/' . $car->images_json['custom_image2'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image2']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image2');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image2" id="custom_image2"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image3">{{ __('Imagen 3') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image3'])? '/' . $car->images_json['custom_image3'] : '#' }}" target="_blank">
											<img id="image_custom_image3" src="{{ isset($car->images_json['custom_image3'])? '/' . $car->images_json['custom_image3'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image3']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image3');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image3" id="custom_image3"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image4">{{ __('Imagen 4') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image4'])? '/' . $car->images_json['custom_image4'] : '#' }}" target="_blank">
											<img id="image_custom_image4" src="{{ isset($car->images_json['custom_image4'])? '/' . $car->images_json['custom_image4'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image4']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image4');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image4" id="custom_image4"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image5">{{ __('Imagen 5') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image5'])? '/' . $car->images_json['custom_image5'] : '#' }}" target="_blank">
											<img id="image_custom_image5" src="{{ isset($car->images_json['custom_image5'])? '/' . $car->images_json['custom_image5'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image5']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image5');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image5" id="custom_image5"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image6">{{ __('Imagen 6') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image6'])? '/' . $car->images_json['custom_image6'] : '#' }}" target="_blank">
											<img id="image_custom_image6" src="{{ isset($car->images_json['custom_image6'])? '/' . $car->images_json['custom_image6'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image6']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image6');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image6" id="custom_image6"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image7">{{ __('Imagen 7') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image7'])? '/' . $car->images_json['custom_image7'] : '#' }}" target="_blank">
											<img id="image_custom_image7" src="{{ isset($car->images_json['custom_image7'])? '/' . $car->images_json['custom_image7'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image7']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image7');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image7" id="custom_image7"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image8">{{ __('Imagen 8') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image8'])? '/' . $car->images_json['custom_image8'] : '#' }}" target="_blank">
											<img id="image_custom_image8" src="{{ isset($car->images_json['custom_image8'])? '/' . $car->images_json['custom_image8'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image8']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image8');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image8" id="custom_image8"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image9">{{ __('Imagen 9') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image9'])? '/' . $car->images_json['custom_image9'] : '#' }}" target="_blank">
											<img id="image_custom_image9" src="{{ isset($car->images_json['custom_image9'])? '/' . $car->images_json['custom_image9'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image9']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image9');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image9" id="custom_image9"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image10">{{ __('Imagen 10') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image10'])? '/' . $car->images_json['custom_image10'] : '#' }}" target="_blank">
											<img id="image_custom_image10" src="{{ isset($car->images_json['custom_image10'])? '/' . $car->images_json['custom_image10'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image10']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image10');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image10" id="custom_image10"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
                            </div>
							<div class="col-md-6">
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image11">{{ __('Imagen 11') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image11'])? '/' . $car->images_json['custom_image11'] : '#' }}" target="_blank">
											<img id="image_custom_image11" src="{{ isset($car->images_json['custom_image11'])? '/' . $car->images_json['custom_image11'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image11']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image11');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image11" id="custom_image11"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image12">{{ __('Imagen 12') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image12'])? '/' . $car->images_json['custom_image12'] : '#' }}" target="_blank">
											<img id="image_custom_image12" src="{{ isset($car->images_json['custom_image12'])? '/' . $car->images_json['custom_image12'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image12']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image12');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image12" id="custom_image12"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image13">{{ __('Imagen 13') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image13'])? '/' . $car->images_json['custom_image13'] : '#' }}" target="_blank">
											<img id="image_custom_image13" src="{{ isset($car->images_json['custom_image13'])? '/' . $car->images_json['custom_image13'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image13']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image13');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image13" id="custom_image13"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image14">{{ __('Imagen 14') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image14'])? '/' . $car->images_json['custom_image14'] : '#' }}" target="_blank">
											<img id="image_custom_image14" src="{{ isset($car->images_json['custom_image14'])? '/' . $car->images_json['custom_image14'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image14']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image14');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image14" id="custom_image14"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image15">{{ __('Imagen 15') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image15'])? '/' . $car->images_json['custom_image15'] : '#' }}" target="_blank">
											<img id="image_custom_image15" src="{{ isset($car->images_json['custom_image15'])? '/' . $car->images_json['custom_image15'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image15']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image15');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image15" id="custom_image15"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image16">{{ __('Imagen 16') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image16'])? '/' . $car->images_json['custom_image16'] : '#' }}" target="_blank">
											<img id="image_custom_image16" src="{{ isset($car->images_json['custom_image16'])? '/' . $car->images_json['custom_image16'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image16']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image16');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image16" id="custom_image16"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image17">{{ __('Imagen 17') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image17'])? '/' . $car->images_json['custom_image17'] : '#' }}" target="_blank">
											<img id="image_custom_image17" src="{{ isset($car->images_json['custom_image17'])? '/' . $car->images_json['custom_image17'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image17']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image17');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image17" id="custom_image17"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image18">{{ __('Imagen 18') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image18'])? '/' . $car->images_json['custom_image18'] : '#' }}" target="_blank">
											<img id="image_custom_image18" src="{{ isset($car->images_json['custom_image18'])? '/' . $car->images_json['custom_image18'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image18']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image18');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image18" id="custom_image18"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image19">{{ __('Imagen 19') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image19'])? '/' . $car->images_json['custom_image19'] : '#' }}" target="_blank">
											<img id="image_custom_image19" src="{{ isset($car->images_json['custom_image19'])? '/' . $car->images_json['custom_image19'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image19']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image19');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image19" id="custom_image19"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-control-label" for="custom_image20">{{ __('Imagen 20') }}</label>
									</div>
									<div class="col-md-3">
										<a href="{{ isset($car->images_json['custom_image20'])? '/' . $car->images_json['custom_image20'] : '#' }}" target="_blank">
											<img id="image_custom_image20" src="{{ isset($car->images_json['custom_image20'])? '/' . $car->images_json['custom_image20'] : '/argon/img/not_found.png' }}" height="50px" />
										</a>
									</div>
									<div class="col-md-1">
										@if(isset($car->images_json['custom_image20']))
											<a style="color: #a72727;" href="javascript:void(0);" onclick="deleteCarImage('custom_image20');">
												<i class="fas fa-trash" style="padding-top: 1rem;"></i>
											</a>
										@endif
									</div>
									<div class="col-md-8">
										<input type="file" class="form-control" name="custom_image20" id="custom_image20"  accept="image/*" onchange="validateWeight(this);">	
									</div>
								</div>
                            </div>
							<div class="col-md-12 row">
								<div class="col-md-12">
									<div class="text-center">
										<button type="button" 
                                            data-toggle="modal" 
											data-target="#updateModal"
											data-keyboard="false" 
											data-backdrop="static"
											class="btn btn-success mt-4">{{ __('Guardar cambios') }}</button>
									</div>
									<br>
								</div>
							</div>

						</div>
					</form>
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
<script>
	function validateWeight(element) {
		if (element.files[0]) {
			if (element.files[0].size > 500000 ) {
				alert("Imagen muy grande " + element.files[0].size/1000 + "kb. Tamaño máximo recomendado: 500kb");	
				element.value = null;
			}
		}
	}
</script>
@endpush