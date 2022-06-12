<div class="m-t-sm-40">
    <div class="container">
        <div class="search-option vh-35 p-lg-30 p-b-lg-15 p-b-sm-30 p-r-sm-45 p-xs-15">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <form action="{{ route('store.cars') }}">
                        @method('get')
                        <div class="col-md-8 col-lg-8">
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4 m-b-lg-15 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <br class="mobileBanner">
                                        <label class="color-blue">Transmisión</label>
                                        <select name="filter_transmision" id="" class="form-control">
                                            <option style="color: #000000;" value="AT">AUTOMÁTICO</option>
                                            <option style="color: #000000;" value="MT">MANUAL</option>
                                            <option style="color: #000000;" value="SE">SECUENCIAL</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4 m-b-lg-15 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <br class="mobileBanner">
                                        <label class="color-blue">Marca</label>
                                        <select name="filter_brand" id="" class="form-control">
                                            <option value="0">Todas las marcas</option>
                                            @foreach ($brands as $brand)
                                                <option style="color: #000000;" value="{{ $brand->id }}"> {{ $brand->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4 m-b-lg-15 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <label class="color-blue">Año (Desde)</label>
                                        <input type="text" name="filter_year_since" class="form-control" placeholder="Desde">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4 m-b-lg-15 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <label class="color-blue">Tracción</label>
                                        <select name="filter_trax" id="" class="form-control">
                                            <option style="color: #000000;" value="4X2">4X2</option>
                                            <option style="color: #000000;" value="4X4">4X4</option>
                                            <option style="color: #000000;" value="AWD">AWD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4 m-b-lg-15 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <label class="color-blue">Modelo</label>
                                        <select name="filter_model" id="" class="form-control">
                                            <option value="0">Todos los modelos</option>
                                            @foreach ($models as $model)
                                                <option style="color: #000000;" value="{{ $model->id }}"> {{ $model->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4 m-b-lg-15 p-r-lg-0 col-xs-6">
                                    <div class="form-group">
                                        <label class="color-blue">Año (Hasta)</label>
                                        <input type="text" name="filter_year_to" class="form-control" placeholder="Hasta">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <label class="color-blue">Rango de precios</label>
                            <input type="text" name="filter_price" disabled class="slider_amount m-t-xs-0 m-t-sm-10">
                            <div class="slider-range"></div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                        <br><br>
                            <button type="submit" class="ht-btn btn-lg pull-right pull-left background-blue">
                                <i class="fa fa-search"></i> Buscar vehículos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>