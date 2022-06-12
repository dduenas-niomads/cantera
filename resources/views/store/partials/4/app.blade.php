<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
        @include('store.partials.4.styles')
	</head>
	<body class="bg-3">
		<!-- Preloader -->
		<div id="wrap" class="color1-inher">
			<!-- Header-->
			@include('store.partials.4.header')
			<!-- Search-->
			<!-- Main content-->
            @yield('content')
			<!-- Footer-->
			@include('store.partials.4.footer')
		</div>
        <!-- scripts -->
        @include('store.partials.4.scripts')
	</body>
</html>