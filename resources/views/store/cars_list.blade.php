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
								<li class="active">Vehículos</li>
							</ul>
						</div>
						<div class="col-lg-6">
						</div>
					</div>
				</div>
				<!-- Car grid -->
				<section class="m-t-lg-30 m-t-xs-0">
					<div class="row">
						<div class="col-sm-5 col-md-4 col-lg-3">
							<!-- Search option -->
							<div class="web search-option box-shadow m-b-lg-50 p-lg-20" style="text-align: center;">
								<input type="hidden" id="model_values" value="{{ json_encode($models) }}">
								<form action="{{ route('store.cars') }}">
									@method('get')	
									<div class="m-b-lg-15">
                                        <label class="color-blue">Marca</label>
                                        <select name="filter_brand" class="form-control" onchange="newOptions(this, 'selectSearchModel');">
                                            <option value="0">Todas</option>
											@foreach ($brands as $brand)
												@if (isset($params) && isset($params['filter_brand']) && (int)$params['filter_brand'] === $brand->id)
													<option selected style="color: #000000;" value="{{ $brand->id }}"> {{ $brand->name }} </option>
												@else
													<option style="color: #000000;" value="{{ $brand->id }}"> {{ $brand->name }} </option>
												@endif
											@endforeach
										</select>
									</div>
									<div class="m-b-lg-15">
                                        <label class="color-blue">Modelo</label>
                                        <select name="filter_model" class="form-control" id="selectSearchModel" >
                                            <option value="0">Todos</option>
											@foreach ($models as $model)
												@if (isset($params) && isset($params['filter_model']) && (int)$params['filter_model'] === $model->id)
													<option selected style="color: #000000;" value="{{ $model->id }}"> {{ $model->name }} </option>												
												@else
													@if (isset($params) && isset($params['filter_brand']) && (int)$params['filter_brand'] === (int)$model->ms_masters_id)
														<option style="color: #000000;" value="{{ $model->id }}"> {{ $model->name }} </option>
													@endif
												@endif
											@endforeach
										</select>
									</div>
									<div class="m-b-lg-15">
										<label class="color-blue">Año (Desde)</label>
										<input type="number" name="filter_year_since" class="form-control" placeholder="Desde" value="{{ (isset($params) && isset($params['filter_year_since'])) ? $params['filter_year_since'] : '' }}">
									</div>
									<div class="m-b-lg-15">
										<label class="color-blue">Año (Hasta)</label>
										<input type="number" name="filter_year_to" class="form-control" placeholder="Hasta" value="{{ (isset($params) && isset($params['filter_year_to'])) ? $params['filter_year_to'] : '' }}">
									</div>
									<div class="m-b-lg-15">
                                        <label class="color-blue">Transmisión</label>
										<select name="filter_transmition" class="form-control">
											@foreach ($transmitions as $transmition)
												@if (isset($params) && isset($params['filter_transmition']) && $params['filter_transmition'] === $transmition->id)
													<option selected style="color: #000000;" value="{{ $transmition->id }}">{{ $transmition->name }}</option>
												@else
													<option style="color: #000000;" value="{{ $transmition->id }}">{{ $transmition->name }}</option>
												@endif
											@endforeach
										</select>
									</div>
									<div class="m-b-lg-15">
                                        <label class="color-blue">Tracción</label>
										<select name="filter_trax" class="form-control">
											@foreach ($traxions as $traxion)
												@if (isset($params) && isset($params['filter_trax']) && $params['filter_trax'] === $traxion->id)
													<option selected style="color: #000000;" value="{{ $traxion->id }}">{{ $traxion->name }}</option>												
												@else
													<option style="color: #000000;" value="{{ $traxion->id }}">{{ $traxion->name }}</option>
												@endif
											@endforeach
										</select>
									</div>
									<div class="m-b-lg-15">
										<label class="color-blue">Rango de precios</label>
										<input type="text" name="filter_price" disabled class="slider_amount m-t-lg-10">
										<div class="slider-range"></div>
									</div>
									<button type="submit" class="ht-btn ht-btn-gray m-t-lg-30 background-blue"><i class="fa fa-search"></i>Buscar vehículos</button>
								</form>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="col-sm-7 col-md-8 col-lg-9 vh-minus-12">
							<div class="product product-grid product-grid-2 car">
								<div class="p-t-xs-20 p-l-xs-20" style="margin-top: 1rem; margin-bottom: 2rem;">
									<div class="row web">
										<div class="col-md-6">
											<h3 class="p-l-lg-20 fontBold">Listado de vehículos <b style="color: red;" class="f-20">({{ $totalCount }})</b></h3>
										</div>
										<div class="col-md-3">
										</div>
										<div class="col-md-3">
											<label class="p-l-lg-20" ><i class="fa fa-sort-alpha-asc" ></i> Ordenar por </label>
											<div class="p-l-lg-20">
												<select class="form-control" name="filter_order_by" id="filter_order_by" onchange="callFilter('filter_order_by');">
													@foreach ($ordersBy as $orderBy)
														@if (isset($params) && isset($params['filter_order_by']) && $params['filter_order_by'] === $orderBy->id)
															<option selected value="{{ $orderBy->id }}" style="color: #000000;">{{ $orderBy->name }}</option>
														@else
															<option value="{{ $orderBy->id }}" style="color: #000000;">{{ $orderBy->name }}</option>
														@endif
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="mobileBanner">
										<div class="col-md-6">
											<h3 class="p-l-lg-20 fontBold">Listado de vehículos <b style="color: red;" class="f-20">({{ $totalCount }})</b></h3>
										</div>
										<div class="row">
											<div class="col-xs-3">
												<label class="f-10">Ordenar por </label>
											</div>
											<div class="col-xs-6">
												<select class="form-control" name="filter_order_by" id="filter_order_by" onchange="callFilter('filter_order_by');">
													@foreach ($ordersBy as $orderBy)
														@if (isset($params) && isset($params['filter_order_by']) && $params['filter_order_by'] === $orderBy->id)
															<option selected value="{{ $orderBy->id }}" style="color: #000000;">{{ $orderBy->name }}</option>
														@else
															<option value="{{ $orderBy->id }}" style="color: #000000;">{{ $orderBy->name }}</option>
														@endif
													@endforeach
												</select>
											</div>
											<div class="col-xs-3">
												<label class="f-10"
													data-toggle="collapse" 
													data-target="#bs-example-navbar-collapse-1" 
													aria-expanded="false">Filtros (+)</label>
											</div>
											<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
												<div class="mobileBanner search-option box-shadow m-b-lg-50 p-lg-20" style="text-align: center;">
													<form action="{{ route('store.cars') }}">
														@method('get')	
														<div class="m-b-lg-15">
															<label class="color-blue">Marca</label>
															<select name="filter_brand" class="form-control" onchange="newOptions(this, 'selectSearchModelMobile');">
																<option value="0">Todas</option>
																@foreach ($brands as $brand)
																	@if (isset($params) && isset($params['filter_brand']) && (int)$params['filter_brand'] === $brand->id)
																		<option selected style="color: #000000;" value="{{ $brand->id }}"> {{ $brand->name }} </option>
																	@else
																		<option style="color: #000000;" value="{{ $brand->id }}"> {{ $brand->name }} </option>
																	@endif
																@endforeach
															</select>
														</div>
														<div class="m-b-lg-15">
															<label class="color-blue">Modelo</label>
															<select name="filter_model" class="form-control" id="selectSearchModelMobile">
																<option value="0">Todos</option>
																@foreach ($models as $model)
																	@if (isset($params) && isset($params['filter_model']) && (int)$params['filter_model'] === $model->id)
																		<option selected style="color: #000000;" value="{{ $model->id }}"> {{ $model->name }} </option>												
																	@else
																		@if (isset($params) && isset($params['filter_brand']) && (int)$params['filter_brand'] === (int)$model->ms_masters_id)
																			<option style="color: #000000;" value="{{ $model->id }}"> {{ $model->name }} </option>
																		@endif
																	@endif
																@endforeach
															</select>
														</div>
														<div class="m-b-lg-15">
															<label class="color-blue">Año (Desde)</label>
															<input type="number" name="filter_year_since" class="form-control" placeholder="Desde" value="{{ (isset($params) && isset($params['filter_year_since'])) ? $params['filter_year_since'] : '' }}">
														</div>
														<div class="m-b-lg-15">
															<label class="color-blue">Año (Hasta)</label>
															<input type="number" name="filter_year_to" class="form-control" placeholder="Hasta" value="{{ (isset($params) && isset($params['filter_year_to'])) ? $params['filter_year_to'] : '' }}">
														</div>
														<div class="m-b-lg-15">
															<label class="color-blue">Transmisión</label>
															<select name="filter_transmition" class="form-control">
																@foreach ($transmitions as $transmition)
																	@if (isset($params) && isset($params['filter_transmition']) && $params['filter_transmition'] === $transmition->id)
																		<option selected style="color: #000000;" value="{{ $transmition->id }}">{{ $transmition->name }}</option>
																	@else
																		<option style="color: #000000;" value="{{ $transmition->id }}">{{ $transmition->name }}</option>
																	@endif
																@endforeach
															</select>
														</div>
														<div class="m-b-lg-15">
															<label class="color-blue">Tracción</label>
															<select name="filter_trax" class="form-control">
																@foreach ($traxions as $traxion)
																	@if (isset($params) && isset($params['filter_trax']) && $params['filter_trax'] === $traxion->id)
																		<option selected style="color: #000000;" value="{{ $traxion->id }}">{{ $traxion->name }}</option>												
																	@else
																		<option style="color: #000000;" value="{{ $traxion->id }}">{{ $traxion->name }}</option>
																	@endif
																@endforeach
															</select>
														</div>
														<div class="m-b-lg-15">
															<label class="color-blue">Rango de precios</label>
															<input type="text" name="filter_price" disabled class="slider_amount m-t-lg-10">
															<div class="slider-range"></div>
														</div>
														<button type="submit" class="ht-btn ht-btn-gray m-t-lg-30 background-blue"><i class="fa fa-search"></i>Buscar vehículos</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<!-- Car listing -->
								<div class="row">
								@foreach ($cars as $car)
									@include('store.partials.car_item_list_mini')
								@endforeach
								@if ($totalCount === 0)
									<p style="padding: 2em;">No encontramos vehículos que coincidan con nuestros registros. Prueba con otras características.</p>
								@endif
								</div>
								<nav aria-label="Page navigation">
									<ul class="pagination ht-pagination">
										@if (((int)$page - 1) > 0)
										<li>
											<a href="/store/cars/{{ ((int)$page - 1) }}?{{ $_SERVER['QUERY_STRING'] }}" aria-label="Previous">
												<span aria-hidden="true"><i class="fa fa-chevron-left"></i></span>
											</a>
										</li>
										@endif
										@for ($i = 1; $i <= ceil($totalCount/9); $i++)
											@if ($i === (int)$page)
												<li class="active"><a href="/store/cars/{{ $i }}?{{ $_SERVER['QUERY_STRING'] }}">{{ $i }}</a></li>
											@else
												<li><a href="/store/cars/{{ $i }}?{{ $_SERVER['QUERY_STRING'] }}">{{ $i }}</a></li>
											@endif
										@endfor
										@if (((int)$page + 1) <= ceil($totalCount/9))
										<li>
											<a href="/store/cars/{{ ((int)$page + 1) }}?{{ $_SERVER['QUERY_STRING'] }}" aria-label="Next">
												<span aria-hidden="true"><i class="fa fa-chevron-right"></i></span>
											</a>
										</li>
										@endif
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
@endsection