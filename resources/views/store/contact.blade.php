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
								<li class="active">Contacto</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- Contact -->
				<section class="block-contact m-t-lg-30 m-t-xs-0 p-b-lg-50">
					<div class="">
						<div class="row">
							<!-- Contact form -->
							<div class="col-sm-6 col-md-6 col-lg-6">
								<div class="heading">
									<h3>Contáctenos</h3>
								</div>
								<div class="contact-form p-lg-30 p-xs-15 bg-gray-fa bg1-gray-2">
									<form>
										<div class="form-group">
											<input type="email" class="form-control form-item" placeholder="Correo electrónico">
										</div>
										<div class="form-group">
											<input type="text" class="form-control form-item" placeholder="Teléfonos de contacto">
										</div>
										<div class="form-group">
											<input type="text" class="form-control form-item" placeholder="Dirección">
										</div>
										<div class="form-group">
											<input type="text" class="form-control form-item" placeholder="Nombres completos">
										</div>
										<textarea class="form-control form-item h-200 m-b-lg-10" placeholder="Mensaje" rows="3"></textarea>
										<button type="button" class="ht-btn ht-btn-default">Enviar mensaje</button>
									</form>
								</div>
							</div>
							<div class="col-sm-6">
								<img src="/store/images/session/IMG_3661.jpg" alt="" srcset="">
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
@endsection