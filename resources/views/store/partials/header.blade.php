<!-- Header-->
<header id="wrap-header" class="color-inher">
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <ul class="pull-right">
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu -->
    <div class="">
        <div class="container background1">
            <div class="row">
                <div class="col-md-12 col-lg-12" style="padding:0px;">
                    <div class="clearfix"></div>
                    <!-- Menu -->	
                    <div class="main-menu">
                        <div class="container1">
                            <nav class="navbar navbar-default menu">
                                <div class="container1-fluid">
                                    <div class="navbar-header row" style="max-width: 100%;">
                                        <div class="col-xs-12 mobileBanner" style="padding-top: 1.5rem; text-align: center;">
                                            <a href="/" style="padding-right: 1rem;"><b class="titleMobile">Inicio</b></a>
                                            <a href="/store/cars" style="padding-right: 1rem;"><b class="titleMobile">Vehículos</b></a>
                                            <a href="/store/about" style="padding-right: 1rem;"><b class="titleMobile">Nosotros</b></a>
                                            <a href="/store/contact" style="padding-right: 1rem;"><b class="titleMobile">Contacto</b></a>
                                            <a href="/store/contact" style="padding-right: 1rem;"><b class="titleMobile">Ingresar</b></a>
                                        </div>
                                    </div>
                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                        <ul class="nav navbar-nav">
                                            <li class="dropdown">
                                                <a href="/">Inicio</a>
                                            </li>
                                            <li class="dropdown">
                                                <a href="/store/cars">Vehículos</a>
                                            </li>
                                            <li class="dropdown">
                                                <a href="/store/about">Nosotros</a>
                                            </li>
                                            <li>
                                                <a href="/store/contact">Contacto</a>
                                            </li>
                                            <li>
                                                <a href="/login">Ingresar</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>	
                            <!-- Search -->
                            <div class="search-box">
                                <i class="fa fa-search"></i>
                                <form action="{{ route('store.cars') }}">
                                    @method('get')
                                    <input type="text" name="search-txt" placeholder="Buscar..." class="search-txt form-item">
                                    <button type="submit" class="search-btn btn-1"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Logo -->
                <div class="col-md-12 col-lg-12" align="center">
                    <div class="banner-item no-bg" style="padding: 30px;">
                    </div>
                    <br><br><br>
                    <br><br><br>
                    <br><br><br>
                    <br><br><br>
                    <br><br>
                </div>
            </div>
            <br>
            <br>
        </div>
    </div>
</header>