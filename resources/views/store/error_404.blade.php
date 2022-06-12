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
							<li class="active">Error 404</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- Error 404 -->
				<div class="error_404 m-t-lg-30 m-t-xs-0 p-b-lg-45">
					<div class="bg-gray-f5 bg1-gray-15 p-lg-50 text-center">
						<h3 class="f-40">Vehículo no encontrado</h3>
						<p>El vehículo no fue encontrado en nuestra base de datos.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection