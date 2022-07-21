@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link rel="stylesheet" href="{{ asset('argon') }}/css/myCss.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/css/bs-stepper.min.css">
@endpush

@section('href_title_name')
/movements
@endsection

@section('view_title_name')
Módulo de movimientos
@endsection

@section('nav-movements')
active
@endsection

@section('content')

@include('layouts.headers.empty')

<div class="container-fluid mt--6">
	<div class="row">
		<div class="col">
			<div class="card shadow">
				<div class="card-header">
					<h3 class="mb-0">Nuevo movimiento de mercadería por excel</h3>
				</div>
				<div class="card-body">
					<div class="col-12">
						@if (isset($message) && isset($messageClass))
							<div class="alert alert-{{ $messageClass }} alert-dismissible fade show" role="alert">
								<strong>Notificación:</strong> {{ $message }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						@endif
					</div>
					<div class="col-12">
						<form method="post" action="{{ route('movements.postCreateExcel') }}" 
							id="storeForm" autocomplete="off" enctype="multipart/form-data">
							@csrf
							@method('post')
							<div class="form-group">
								<br>
								<div class="row">
									<div class="col-md-6">
										<label class="form-control-label" for="">{{ __('Tipo de movimiento') }}</label>
										<select name="type_movement" id="input-type_movement" class="form-control">
											<option value="1">Ingreso de mercadería</option>
											<option value="2">Salida de mercadería</option>
											<option value="3">Recuento de mercadería</option>
										</select>
									</div>
									<div class="col-md-6">
										<label class="form-control-label" for="">{{ __('Fecha de movimiento') }}</label>
										<input type="date" class="form-control" name="date_start" id="input-date_start" placeholder="Fecha de movimiento">
									</div>
									<div class="col-md-6">
									<br>
										<label class="form-control-label" for="">{{ __('Detalle de movimiento') }}</label>
										<input type="text" name="description" class="form-control" placeholder="Describa este movimiento de mercadería">
									</div>
									<div class="col-md-6">
									<br>
										<label class="form-control-label" for="">{{ __('Archivo Excel') }}</label>
										<input type="file" class="form-control" name="file">
									</div>
								</div>
							</div>
							<div class="col-md-12 row">
								<div class="col-md-12">
									<div class="text-center">
										<button type="button" class="btn btn-default" onclick="goBack();">Regresar</button>
										<!-- true, true, ['ti_1'] -->
										<button type="submit" class="btn btn-success" onclick="changeTitle(this);">Cargar archivo</button>
									</div>
									<br>
								</div>
							</div>
							<div class="col-md-12">
								<p>Si no cuenta con una plantilla para productos, puede descargarla <a href="{{ asset('argon') }}/vendor/plantilla_de_productos_vacia.xlsx">aquí</a></p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="modal fade" id="modal-on-load">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title">Estamos procesando el registro.</h1>
				</div>
                <div class="modal-body">
                    <h4>¡En breve te daremos los resultados!</h4>
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
<script src="{{ asset('argon') }}/js/bs-stepper.min.js"></script>

<script>
	function changeTitle(element) {
		// element.innerHTML = "Cargando archivo, porfavor espere...";
		// element.disabled = true;
		$('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
	}

	function goBack() {
        window.location.replace("/movements");
	}
    </script>
@endpush