@extends('store.partials.app_list')

@section('content')
	<!-- Main content -->
	<div id="wrap-body" class="p-t-lg-30">
		<div class="container">
			<div class="wrap-body-inner">
				<!-- Breadcrumb-->
				<div class="hidden-xs">
					<div class="row">
						<div class="col-lg-6">
							<ul class="ht-breadcrumb pull-left">
								<li class="home-act"><a href="#"><i class="fa fa-home"></i></a></li>
								<li class="home-act"><a href="#">JC Ugarte</a></li>
								<li class="active">Vehículo</li>
							</ul>
						</div>
						<div class="col-lg-6">
						</div>
					</div>
				</div>
				<!-- Car detail -->
				<section class="m-t-lg-30 m-t-xs-0">
					<div class="product_detail no-bg p-lg-0">
						<!-- Car name -->
						<h3 class="product-name color1-f">{{ $car->brand }} {{ $car->model }} {{ $car->model_year }} -  
						
						@if ((int)$car->flag_active === 1)
							@if ($car->price_promotion > 0)
								<span class="product-price color-red">{{ $car->currency }} {{ number_format($car->price_promotion) }}</span>
							@else
								<span class="product-price color-red">{{ $car->currency }} {{ number_format($car->price_sale) }}</span>
							@endif
						@else
							@if ($car->price_promotion > 0)
								<span class="product-price"  style="text-decoration:line-through;">{{ $car->currency }} {{ number_format($car->price_promotion) }}</span>
							@else
								<span class="product-price"  style="text-decoration:line-through;">{{ $car->currency }} {{ number_format($car->price_sale) }}</span>
							@endif
							<span class="product-price color-red"> - VEHICULO VENDIDO</span>
						@endif
						</h3>
						<div class="row">
							<div class="col-md-7 col-lg-8">
								<!-- Car image gallery -->
								<div class="product-img-lg bg-gray-f5 bg1-gray-15">
									<div class="image-zoom row m-t-lg-5 m-l-lg-ab-5 m-r-lg-ab-5">
										@php
											$iterator = 0;
											$counterImages = 0;
											if (!is_null($car->images_json)) {
												$counterImages = count($car->images_json);
											}
											$orderedImages_ = [];
											for ($i = 1; $i <= 20; $i++) {
												if (isset($car->images_json['custom_image' . $i])) {
													array_push($orderedImages_, $car->images_json['custom_image' . $i]);
												}
											}
										@endphp
										@if (!is_null($car->images_json))
											@foreach ($orderedImages_ as $key => $imageJson)
													@if ($key === 0)	
														<div class="col-md-12 col-lg-12 p-lg-5">
													@else
														<div class="col-sm-3 col-md-3 col-lg-3 p-lg-5">
													@endif
															<a href="{{ '/' . $imageJson }}">
																<img src="{{ '/' . $imageJson }}" alt="Jc Ugarte">
															</a>
														</div>
													@php
														$iterator++;
													@endphp
											@endforeach
										@endif
									</div>
								</div>
							</div>
							<!-- Car description -->
							<div class="col-md-5 col-lg-4">
								<ul class="product_para-1 p-lg-15 bg-gray-f5 bg1-gray-15">
									<li><span>Marca :</span>{{ !is_null($car->brand) ? $car->brand : '--' }}</li>
									<li><span>Modelo :</span>{{ !is_null($car->model) ? $car->model : '--' }}</li>
									<li><span>Color :</span>{{ !is_null($car->color) ? $car->color : '--' }}</li>
									<li><span>Kilometraje :</span>{{ !is_null($car->details) ? $car->details->kilometers : '--' }} km</li>
									<li><span>Año fab:</span>{{ !is_null($car->fab_year) ? $car->fab_year : '--' }}</li>
									<li><span>Año Modelo:</span>{{ !is_null($car->model_year) ? $car->model_year : '--' }}</li>
									<li><span>Motor :</span>{{ !is_null($car->details) ? $car->details->cc : '--' }} cc</li>
									<li><span>Cilindros :</span>{{ !is_null($car->details) ? $car->details->cylinders : '--' }} cilindros</li>
									<li><span>Potencia :</span>{{ !is_null($car->details) ? $car->details->hp : '--' }} hp</li>
									<li><span>Torque :</span>{{ !is_null($car->details) ? $car->details->torque : '--' }} Nm</li>
									<li><span>Puertas :</span>{{ !is_null($car->details) ? $car->details->doors_number : '--' }} puertas</li>
									<li><span>Transmisión :</span>{{ !is_null($car->details) ? $car->details->transmition : '--' }}</li>
									<li><span>Tracción :</span>{{ !is_null($car->details) ? $car->details->traction : '--' }}</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- Car description tabs -->
					<div class="row m-t-lg-30 m-b-lg-50">
						<div class="col-md-8">
							<div class="m-b-lg-30">
								<div class="heading-1"><h3>Descripción</h3></div>
									<div class="m-b-lg-30 bg-gray-fa bg1-gray-2 p-lg-30 p-xs-15">
									<p class="color1-9" style="text-align: justify;">
										@if (!is_null($car->details))
											{{ !is_null($car->details->description) ? $car->details->description : 'Descripción no disponible'}}
										@else
											Descripción no disponible
										@endif 
									</p>
								</div>
							</div>
							<!-- Features & Options -->
							<div class="m-b-lg-30">
								<div class="heading-1"><h3>Características del vehículo</h3></div>
								<div class="bg-gray-fa bg1-gray-2 p-lg-30 p-xs-15">
									<ul class="list-feature">
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['manuals']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
												Manuales
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['air_conditioner']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Aire acondicionado
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['wheel_secure']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Seguro de llantas
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['cat']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Gata
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['tools']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Herramientas
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['extra_key']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Llave extra
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['extra_tire']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Llanta de repuesto
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['logo']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Emblemas
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['wheel_key']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Llave de ruedas
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['smoke_path']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Cenicero
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['floors']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Pisos
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['property_card']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Tarjeta de propiedad
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['fog_lights']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Faros antiniebla
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['security_foils']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Láminas de seguridad
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['triangule']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Triángulo
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['lighter']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Encendedor
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['hoop_caps']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Tapas de aro
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['alloy_hoops']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Aros de aleación
										</li>
										<li>
											@if (!is_null($car->details) && !is_null($car->details->options_json))
												@if (isset($car->details->options_json['reverse_camera']))
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-square"></i>
												@endif
											@else
												<i class="fa fa-square"></i>
											@endif
											Cámara de retroceso
										</li>
									</ul>
								</div>
							</div>
							<!-- Technical Specifications -->
							<!-- <div class="m-b-lg-0">
								<div class="heading-1"><h3>Technical Specifications</h3></div>
								<div class="bg-gray-fa bg1-gray-2 p-lg-30 p-xs-15">
									<div class="heading-1"><h3 class="f-18">Engine</h3></div>
									<ul class="product_para-1">
										<li><span>Layout / number of cylinders :</span>Nissan</li>
										<li><span>Displacement :</span>Civic</li>
										<li><span>Engine Layout :</span>Sedan</li>
										<li><span>Horespower :</span>Mileage</li>
										<li><span>@ rpm :</span>3.4L Mid-Engine V6</li>
										<li><span>Torque :</span>3.4L Mid-Engine V6</li>
										<li><span>Compression ratio :</span>3.4L Mid-Engine V6</li>
									</ul>
									<div class="heading-1 m-t-lg-20"><h3 class="f-18">Performance</h3></div>
									<ul class="product_para-1">
										<li><span>Top Track Speed :</span>Nissan</li>
										<li><span>0 - 60 mph :</span>Civic</li>
									</ul>
									<div class="heading-1 m-t-lg-20"><h3 class="f-18">Transmission</h3></div>
									<ul class="product_para-1">
										<li><span>Manual Gearbox :</span>6-speed with dual-mass flywheel</li>
									</ul>
									<div class="heading-1 m-t-lg-20"><h3 class="f-18">Fuel consumption</h3></div>
									<ul class="product_para-1">
										<li><span>City (estimate) :</span>Nissan</li>
										<li><span>Highway (estimate) :</span>Civic</li>
									</ul>
									<div class="heading-1 m-t-lg-20"><h3 class="f-18">Body</h3></div>
									<ul class="product_para-1">
										<li><span>Length :</span>Nissan</li>
										<li><span>Width :</span>Civic</li>
										<li><span>Height :</span>Sedan</li>
										<li><span>Wheelbase :</span>Mileage</li>
										<li><span>Maximum payload :</span>3.4L Mid-Engine V6</li>
									</ul>
								</div>
							</div> -->
						</div>
						<!-- Dealer Infomation -->
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="heading-1">
								<h3><i class="fa fa-info-circle"></i>Información de contacto</h3>
							</div>
							<a href="#" class="bg-gray-fa bg1-gray-2 p-lg-15 text-center m-b-lg-20 display-block">
								<img src="/store/images/logo.png" alt="image">
							</a>
							<div class="clearfix"></div>
							<ul class="list-default m-t-lg-0">
								@if (!is_null($car->createdBy))
								<li><i class="fa fa-user-circle-o m-r-lg-10  icon"></i> {{ $car->createdBy->name }} {{ $car->createdBy->lastname }}</li>
								<li><i class="fa fa-phone m-r-lg-10 icon"></i>{{ $car->createdBy->phone }}</li>
								<li><i class="fa fa-envelope-o m-r-lg-10 icon"></i>{{ $car->createdBy->email }}</li>
								<li><i class="fa fa-home m-r-lg-10 icon"></i>Av. Nicolas Arriola N° 330</li>
								<li><a href="http://jcugarte.com"><i class="fa fa-globe m-r-lg-10 icon"></i>https://jcugarte.com</a></li>
								@endif
							</ul>
							<!-- Form contact dealer-->
							<!-- <div class="m-t-lg-30">
								<div class="heading-1">
									<h3><i class="fa fa-envelope-o"></i>Enviar mensaje</h3>
								</div>
								<div class="bg-gray-fa bg1-gray-2 p-lg-20">
									<form>
										<div class="form-group">
											<input type="text" class="form-control form-item" placeholder="Nombres completos">
										</div>
										<div class="form-group">
											<input type="email" class="form-control form-item" placeholder="Correo electrónico">
										</div>
										<div class="form-group">
											<input type="text" class="form-control form-item" placeholder="Teléfono de contacto">
										</div>
										<div class="form-group">
											<input type="text" class="form-control form-item" placeholder="Dirección">
										</div>
										<textarea class="form-control form-item h-200 m-b-lg-10" placeholder="Mensaje" rows="3"></textarea>
										<button type="button" class="ht-btn ht-btn-default">Enviar mensaje</button>
									</form>
								</div>
							</div> -->
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
@endsection