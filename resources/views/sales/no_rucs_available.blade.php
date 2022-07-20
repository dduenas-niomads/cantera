@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link rel="stylesheet" href="{{ asset('argon') }}/css/myCss.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/css/bs-stepper.min.css">
@endpush

@section('href_title_name')
/sales
@endsection

@section('view_title_name')
Módulo de ventas
@endsection

@section('nav-sales')
active
@endsection

@section('content')

@include('layouts.headers.empty')

<div class="container-fluid mt--6">
	<div class="row">
		<div class="col">
			<div class="card shadow">
                <div class="card-header border-0">
					<h2>Su cuenta aún no tiene RUCS disponibles.</h2>
                </div>
                <div class="card-body">
					<div class="col-12">
						<p>Porfavor, diríjase al módulo de RUCS para configurar uno.</p>
					</div>
                </div>
                <div class="card-footer py-4">
					<a href="{{ route('taxes.index') }}" class="btn btn-default">Ir a RUCS</a>
                </div>
			</div>
		</div>
	</div>
</div>

@include('layouts.modals.default')

@endsection