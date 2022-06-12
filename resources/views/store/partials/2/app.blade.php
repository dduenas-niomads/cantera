<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
        @include('store.partials.2.styles')
	</head>
	<body class="bg-2">
		<!-- Preloader -->
		<div id="wrap" class="color1-inher">
			<!-- Header-->
			@include('store.partials.2.header')
			<!-- Search-->
			@include('store.partials.2.search')
			<!-- Main content-->
            @yield('content')
			<!-- Footer-->
			@include('store.partials.2.footer')
		</div>
        <!-- scripts -->
        @include('store.partials.2.scripts')
	</body>
</html>