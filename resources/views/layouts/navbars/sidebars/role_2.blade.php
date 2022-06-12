<ul class="navbar-nav navbar-dark">
    <li class="nav-item @yield('nav-dashboard')">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="ni ni-tv-2 text-danger"></i> {{ __('Dashboard') }}
        </a>
    </li>
    <li class="nav-item @yield('nav-reservations')">
        <a class="nav-link" href="/reservations">
            <i class="ni ni-calendar-grid-58 text-danger"></i> {{ __('Reservas') }}
        </a>
    </li>
    <li class="nav-item @yield('nav-sales')">
        <a class="nav-link" href="{{ route('sales.index') }}">
            <i class="ni ni-money-coins text-danger"></i> {{ __('Ventas') }}
        </a>
    </li>
    <li class="nav-item @yield('nav-clients')">
        <a class="nav-link" href="{{ route('clients.index') }}">
            <i class="ni ni-satisfied text-danger"></i> {{ __('Clientes') }}
        </a>
    </li>
    <li class="nav-item @yield('nav-movements')">
        <a class="nav-link" href="{{ route('movements.index') }}">
            <i class="ni ni-app text-danger"></i> {{ __('Movimientos') }}
        </a>
    </li>
</ul>