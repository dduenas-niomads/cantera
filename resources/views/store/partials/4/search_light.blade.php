<div class="m-t-sm-40">
    <div class="container">
        <div class="web search-option box-shadow vh-50 p-lg-30 p-b-lg-15 p-b-sm-30 p-r-sm-45 p-xs-15">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <form action="{{ route('store.cars') }}">
                        @method('get')
                        <div class="col-md-8 col-lg-8">
                            <div class="row">
                                <div class="col-sm-2 col-md-2 col-lg-2 m-b-lg-15 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <br class="mobileBanner">
                                        <label class="color-blue">Marca</label>
                                        <select name="filter_brand" id="selectSearchBrand" class="form-control" onchange="newOptions(this, 'selectSearchModel');">
                                            <option value="0">Todas</option>
                                            @foreach ($brands as $brand)
                                                <option style="color: #000000;" value="{{ $brand->id }}"> {{ $brand->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 m-b-lg-15 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <label class="color-blue">Modelo</label>
                                        <select name="filter_model" id="selectSearchModel" class="form-control">
                                            <option value="0">Todos</option>
                                        </select>
                                        <input type="hidden" id="model_values" value="{{ json_encode($models) }}">
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 m-b-lg-15 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <label class="color-blue">Año (Desde)</label>
                                        <input type="number" name="filter_year_since" class="form-control" placeholder="Desde">
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 m-b-lg-15 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <label class="color-blue">Año (Hasta)</label>
                                        <input type="number" name="filter_year_to" class="form-control" placeholder="Hasta">
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 m-b-lg-15 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <br class="mobileBanner">
                                        <label class="color-blue">Transmisión</label>
                                        <select name="filter_transmision" id="" class="form-control">
                                            <option style="color: #000000;" value="ALL">TODOS</option>
                                            <option style="color: #000000;" value="AT">AUTOMÁTICO</option>
                                            <option style="color: #000000;" value="MT">MANUAL</option>
                                            <option style="color: #000000;" value="SE">SECUENCIAL</option>
                                            <option style="color: #000000;" value="A&S">AT & SEC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 m-b-lg-15 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <label class="color-blue">Tracción</label>
                                        <select name="filter_trax" id="" class="form-control">
                                            <option style="color: #000000;" value="ALL">TODAS</option>
                                            <option style="color: #000000;" value="4X2">4X2</option>
                                            <option style="color: #000000;" value="4X4">4X4</option>
                                            <option style="color: #000000;" value="AWD">AWD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <label class="color-blue">Rango de precios</label>
                            <input type="text" name="filter_price" disabled class="slider_amount m-t-xs-0 m-t-sm-10">
                            <div class="slider-range"></div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                        
                            <button type="submit" class="ht-btn btn-lg pull-right pull-left background-blue">
                                <i class="fa fa-search"></i> Buscar vehículos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mobileBanner search-option vh-5 box-shadow p-lg-30 p-b-lg-15 p-b-sm-30 p-r-sm-45 p-xs-15">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="col-xs-12 col-md-12" style="text-align: center;">
                        <a href="/">
                            <img src="/store/images/logo_web.png" alt="JC Ugarte" width="150px" style="padding-top: 5px">
                        </a>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <h3 class="color-blue" style="text-align: center; font-size: 15px;">
                            Respaldamos tu inversión
                        </h3>
                    </div>
                </div>
                <div class="col-xs-12 col-md-12">
                    <form action="{{ route('store.cars') }}">
                        @method('get')
                        <div class="col-md-8 col-lg-8">
                            <div class="row">
                                <div class="col-sm-2 col-md-2 col-lg-2 p-r-lg-0 col-xs-12">
                                    <div class="form-group">
                                        <label class="color-blue" style="font-size: 12px !important;">Marca</label>
                                        <select name="filter_brand" id="selectSearchBrandMobile" class="form-control" onchange="newOptions(this, 'selectSearchModelMobile');">
                                            <option value="0">Todas</option>
                                            @foreach ($brands as $brand)
                                                <option style="color: #000000;" value="{{ $brand->id }}"> {{ $brand->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 p-r-lg-0 col-xs-12">
                                    <div class="form-group">
                                        <label class="color-blue" style="font-size: 12px !important;">Modelo</label>
                                        <select name="filter_model" id="selectSearchModelMobile" class="form-control">
                                            <option value="0">Todos</option>
                                            @foreach ($models as $model)
                                                <option style="color: #000000;" value="{{ $model->id }}"> {{ $model->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <label class="color-blue" style="font-size: 12px !important;">Año (Desde)</label>
                                        <input type="number" name="filter_year_since" class="form-control" placeholder="Desde">
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <label class="color-blue" style="font-size: 12px !important;">Año (Hasta)</label>
                                        <input type="number" name="filter_year_to" class="form-control" placeholder="Hasta">
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <label class="color-blue" style="font-size: 12px !important;">Transmisión</label>
                                        <select name="filter_transmision" id="" class="form-control">
                                            <option style="color: #000000;" value="ALL">TODOS</option>
                                            <option style="color: #000000;" value="AT">AUTOMÁTICO</option>
                                            <option style="color: #000000;" value="MT">MANUAL</option>
                                            <option style="color: #000000;" value="SE">SECUENCIAL</option>
                                            <option style="color: #000000;" value="A&S">AT & SEC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <label class="color-blue" style="font-size: 12px !important;">Tracción</label>
                                        <select name="filter_trax" id="" class="form-control">
                                            <option style="color: #000000;" value="ALL">TODAS</option>
                                            <option style="color: #000000;" value="4X2">4X2</option>
                                            <option style="color: #000000;" value="4X4">4X4</option>
                                            <option style="color: #000000;" value="AWD">AWD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2" style="text-align: center;">
                            <button type="submit" class="ht-btn btn-lg background-blue" style="font-size: 12px !important;">
                                <i class="fa fa-search"></i> Buscar vehículos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>