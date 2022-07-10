<ul class="navbar-nav navbar-dark">
    <li class="nav-item @yield('nav-dashboard')">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="ni ni-tv-2 text-danger"></i> {{ __('Dashboard') }}
        </a>
    </li>
    <li class="nav-item @yield('nav-reports')">
        <a class="nav-link" href="#navbar-reports"
            data-toggle="collapse" role="button" 
            aria-expanded="false" aria-controls="navbar-reports">
            <i class="ni ni-chart-bar-32 text-danger"></i> {{ __('Reportes') }}
        </a>
        <div class="collapse @yield('nav-reports-collapse')" id="navbar-reports">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item @yield('nav-reports-clients')">
                    <a href="#" class="nav-link">
                        <span class="sidenav-normal"> Historial de clientes </span>
                    </a>
                </li>
                <li class="nav-item @yield('nav-reports-fe')">
                    <a href="/reports/fe" class="nav-link">
                        <span class="sidenav-normal"> Facturación electrónica </span>
                    </a>
                </li>
                <li class="nav-item @yield('nav-reports-sales')">
                    <a href="/reports/sales" class="nav-link">
                        <span class="sidenav-normal"> Reporte de ventas </span>
                    </a>
                </li>
                <li class="nav-item @yield('nav-reports-cars')">
                    <a href="#" class="nav-link">
                        <span class="sidenav-normal"> Reporte de stock </span>
                    </a>
                </li>
            </ul>
        </div>
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
    <li class="nav-item @yield('nav-products')">
        <a class="nav-link" href="{{ route('products.index') }}">
            <i class="ni ni-cart text-danger"></i> {{ __('Productos') }}
        </a>
    </li>
    <li class="nav-item @yield('nav-movements')">
        <a class="nav-link" href="{{ route('movements.index') }}">
            <i class="ni ni-app text-danger"></i> {{ __('Movimientos') }}
        </a>
    </li>
    <li class="nav-item @yield('nav-taxes')">
        <a class="nav-link" href="{{ route('taxes.index') }}">
            <i class="ni ni-books text-danger"></i> {{ __('RUCS') }}
        </a>
    </li>
    <li class="nav-item @yield('nav-users')">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="ni ni-single-02 text-danger"></i> {{ __('Usuarios') }}
        </a>
    </li>
</ul>