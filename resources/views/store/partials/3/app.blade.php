<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
        @include('store.partials.3.styles')
	</head>
	<body class="bg-3">
		<!-- Preloader -->
		<div id="wrap" class="color1-inher">
			<!-- Header-->
			@include('store.partials.3.header')
			<!-- Search-->
			@include('store.partials.3.search')
			<!-- Main content-->
            @yield('content')
			<!-- Footer-->
			@include('store.partials.3.footer')
		</div>
        <!-- scripts -->
        @include('store.partials.3.scripts')
	</body>
</html>