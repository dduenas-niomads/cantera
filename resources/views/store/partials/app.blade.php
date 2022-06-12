<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
        @include('store.partials.styles')
	</head>
	<body class="bg-3">
		<!-- Preloader -->
		<div id="wrap" class="color1-inher">
			<!-- Header-->
			@include('store.partials.header')
			<!-- Search-->
			@include('store.partials.search')
			<!-- Main content-->
            @yield('content')
			<!-- Footer-->
			@include('store.partials.footer')
		</div>
        <!-- scripts -->
        @include('store.partials.scripts')
	</body>
</html>