@extends('store.partials.4.app')

@section('content')
	<!-- Main content -->
	<div id="wrap-body">
		<div class="container">
			<div class="wrap-body-inner">
				<!-- Recent cars -->
				<div class="product product-grid product-grid-2 car m-t-lg-40 p-t-sm-35 m-b-lg-20">
					<div class="heading">
						<h3>STOCK DE VEHÍCULOS</h3>
					</div>
					<div class="row">
						@foreach ($brands as $brand)
							<div class="col-xs-4 height-10vh">
								<a href="/store/cars?filter_brand={{ $brand->id }}">
									<p class="justifyCenter">{{ $brand->name }} <br> 
										<b style="color: red;">{{ count($brand->carsCount) }} </b>
									</p>
								</a>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection