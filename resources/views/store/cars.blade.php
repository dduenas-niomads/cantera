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
							<div class="search-option m-b-lg-50 p-lg-20">
								<form action="{{ route('store.cars') }}">
									@method('get')	
									<div class="m-b-lg-15">
										<select name="filter_brand" class="form-control">
											<option value="0">Marca</option>
											@foreach ($brands as $brand)
												<option style="color: #000000;" value="{{ $brand->id }}"> {{ $brand->name }} </option>
											@endforeach
										</select>
									</div>
									<div class="m-b-lg-15">
										<select name="filter_model" class="form-control">
											<option value="0">Modelo</option>
											@foreach ($models as $model)
												<option style="color: #000000;" value="{{ $model->id }}"> {{ $model->name }} </option>
											@endforeach
										</select>
									</div>
									<div class="m-b-lg-15">
										<select name="filter_year" class="form-control">
											<option value="0">Año</option>
										</select>
									</div>
									<div class="m-b-lg-15">
										<select name="filter_transmition" class="form-control">
											<option value="0">Transmisión</option>
											<option style="color: #000000;" value="AT">AUTOMÁTICO</option>
											<option style="color: #000000;" value="MT">MANUAL</option>
											<option style="color: #000000;" value="SE">SECUENCIAL</option>
										</select>
									</div>
									<div class="m-b-lg-15">
										<select name="filter_trax" class="form-control">
											<option value="0">Tracción</option>
											<option style="color: #000000;" value="4X2">4X2</option>
											<option style="color: #000000;" value="4X4">4X4</option>
											<option style="color: #000000;" value="AWD">AWD</option>
										</select>
									</div>
									<input type="text" name="filter_price" disabled class="slider_amount m-t-lg-10">
									<div class="slider-range"></div>
									<button type="submit" class="ht-btn ht-btn-gray m-t-lg-30"><i class="fa fa-search"></i>Buscar vehículos</button>
								</form>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="col-sm-7 col-md-8 col-lg-9">
							<div class="product product-grid product-grid-2 car">
								<div class="heading heading-2 m-b-lg-0">
									<h3 class="p-l-lg-20">Listado de vehículos (45)</h3>
								</div>
								<!-- Car filter -->
								<div class="product-filter p-t-xs-20 p-l-xs-20">
									<div class="pull-right">
										<div class="m-b-xs-10 m-r-lg-20 pull-left">
											<label class="pull-left p-t-lg-10 m-r-lg-5"><i class="fa fa-sort-alpha-asc"></i>Ordenar por: </label>
											<div class="pull-left">
												<select class="form-control" name="order_by">
													<option value="0" style="color: #000000;">Destacados</option>
													<option value="2" style="color: #000000;">Menor precio</option>
													<option value="3" style="color: #000000;">Mayor precio</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="row">
									<!-- Car listing -->
									@foreach ($cars as $car)
										@include('store.partials.car_item', ['class' => 'col-sm-12 col-md-4 col-lg-4', 'height' => '140px'])
									@endforeach
								</div>
								<!-- <nav aria-label="Page navigation">
									<ul class="pagination ht-pagination">
										<li>
											<a href="#" aria-label="Previous">
												<span aria-hidden="true"><i class="fa fa-chevron-left"></i></span>
											</a>
										</li>
										<li class="active"><a href="#">1</a></li>
										<li><a href="#">2</a></li>
										<li><a href="#">3</a></li>
										<li><a href="#">4</a></li>
										<li><a href="#">5</a></li>
										<li>
											<a href="#" aria-label="Next">
												<span aria-hidden="true"><i class="fa fa-chevron-right"></i></span>
											</a>
										</li>
									</ul>
								</nav> -->
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
@endsection