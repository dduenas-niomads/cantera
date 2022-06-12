<div class="col-md-4 web">
    <div class="product-item hover-img" style="text-align: left; margin-bottom: 30px;">
        <div class="row">
            <!-- <div class="col-sm-2 col-md-2 col-lg-2">
            </div> -->
            @if (is_null($car->sale))
                <div class="col-sm-12 col-md-12 col-lg-12" style="height: 260px !important;">
                    <a href="/store/car-detail/{{ $car->id }}" class="product-img">
                    @if(!is_null($car->images_json) 
                        && isset($car->images_json['custom_image1']))
                        <img style="border-radius: 5px;" src="{{ '/' . $car->images_json['custom_image1'] }}">
                    @else
                        <img style="border-radius: 5px;" src="/store/images/default.png" alt="jc ugarte">
                    @endif
                    </a>
                </div>
            @else
                <div class="col-sm-12 col-md-12 col-lg-12" style="height: 260px !important;">
                    <div class="product-img container">
                    @if(!is_null($car->images_json) 
                        && isset($car->images_json['custom_image1']))
                        <img style="border-radius: 5px;" src="{{ '/' . $car->images_json['custom_image1'] }}">
                    @else
                        <img style="border-radius: 5px;" src="/store/images/default.png" alt="jc ugarte">
                    @endif
                        <div class="content">
                            <h1>VENDIDO</h1>
                        </div>
                    </div>
                </div>
            @endif
            <!-- <div class="col-sm-2 col-md-2 col-lg-2">
            </div> -->
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="product-caption">
                        <h4 class="product-name" style="padding-left: 0px; font-size: 2rem;">
                            <a href="/store/car-detail/{{ $car->id }}" class="f-24" style="width: 100% !important;">{{ $car->brand }} {{ $car->model }}</a>
                        </h4>
                    @if (is_null($car->sale))
                        @if ($car->price_promotion > 0)
                            <b class="product-price color-gray" style="text-decoration:line-through;">{{ number_format($car->price_sale) }} </b>
                            <b class="product-price color-red">{{ number_format($car->price_promotion) }} {{ $car->currency }}</b>
                        @else
                            <b class="product-price color-red">{{ number_format($car->price_sale) }} {{ $car->currency }} </b>
                        @endif
                    @else
                        @if ($car->price_promotion > 0)
                            <b class="product-price color-red"  style="text-decoration:line-through;">{{ number_format($car->price_promotion) }} {{ $car->currency }}</b>
                        @else
                            <b class="product-price color-red"  style="text-decoration:line-through;">{{ number_format($car->price_sale) }} {{ $car->currency }} </b>
                        @endif
                    @endif
                    <ul class="static-caption m-t-lg-20">
                        <li style="font-size: 12.5px !important;"><i class="fa fa-clock-o"></i>{{ $car->fab_year }}-{{ $car->model_year }}</li>
                        <li style="font-size: 12.5px !important;"><i class="fa fa-car"></i>{{ isset($car->details) ? $car->details->transmition : "--" }}</li>
                        <li style="font-size: 12.5px !important;"><i class="fa fa-road"></i>{{ isset($car->details) ? $car->details->traction : "--" }}</li>
                        <li style="font-size: 12.5px !important;"><i class="fa fa-tachometer"></i>{{ isset($car->details) ? $car->details->kilometers : "--" }}</li>
                    </ul>
                    <div class="col-md-12 col-xs-12" style="text-align: center;">
                    <br>
                        @if (is_null($car->sale))
                            @if ($car->price_promotion > 0)
                                <button type="button" onClick="window.location.href = '/store/car-detail/{{ $car->id }}';" class="ht-btn btn-lg background-red">
                                    <i class="fa fa-car"></i> ¡VEHÍCULO EN OFERTA!
                                </button>
                            @else
                                <button type="button" onClick="window.location.href = '/store/car-detail/{{ $car->id }}';" class="ht-btn btn-lg background-blue">
                                    <i class="fa fa-car"></i> Ver detalles
                                </button>
                            @endif
                        @else
                            <button type="button" class="ht-btn btn-lg background-gray">
                                <i class="fa fa-car"></i> VEHÍCULO VENDIDO
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-4 mobileBanner optionalPadding" style="margin-bottom: 10px;">
    <div class="product-item hover-img">
        <div class="row">
            <div class="product-caption">
                <!-- description -->
                <div class="justifyCenter">
                    <h4 class="product-name">
                        <a href="#" class="f-10 justifyCenter" 
                            style="width: 100% !important;">
                            @php
                                $carName = $car->brand . " " . $car->model;
                                $carName = substr($carName, 0, 20);
                            @endphp
                            {{ $carName }}
                        </a>
                    </h4>
                </div>
                <!-- image -->
                    @if (is_null($car->sale))
                        <div class="justifyCenter">
                            <a href="/store/car-detail/{{ $car->id }}" class="">
                            @if(!is_null($car->images_json) 
                                && isset($car->images_json['custom_image1']))
                                <img class="product-img-alternative" src="{{ '/' . $car->images_json['custom_image1'] }}">
                            @else
                                <img class="product-img-alternative" src="/store/images/default.png" alt="jc ugarte">
                            @endif
                            </a>
                        </div>
                        <div class="justifyCenter">
                            @if ($car->price_promotion > 0)
                                <b class="product-price color-red f-10">{{ number_format($car->price_promotion, 0) }} {{ $car->currency }}</b>
                                <b class="product-price color-gray f-10" style="text-decoration:line-through;">{{ number_format($car->price_sale, 0) }} </b>
                            @else
                                <b class="product-price color-red f-10">{{ number_format($car->price_sale, 0) }} {{ $car->currency }} </b>
                            @endif
                        </div>
                        <div class="justifyCenter">
                            @if ($car->price_promotion > 0)
                                <button type="button" onClick="window.location.href = '/store/car-detail/{{ $car->id }}';" 
                                    class="ht-btn btn-sm background-red f-8" style="padding: 5px !important;">
                                    ¡EN OFERTA!
                                </button>
                            @else
                                <button type="button" onClick="window.location.href = '/store/car-detail/{{ $car->id }}';" 
                                    class="ht-btn btn-sm background-blue f-8" style="padding: 5px !important;">
                                    Ver detalles
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="justifyCenter">
                            <div class="container">
                            @if(!is_null($car->images_json) 
                                && isset($car->images_json['custom_image1']))
                                <img class="product-img-alternative" src="{{ '/' . $car->images_json['custom_image1'] }}">
                            @else
                                <img class="product-img-alternative" src="/store/images/default.png" alt="jc ugarte">
                            @endif
                                <div class="content2">
                                    <h4>VENDIDO</h4>
                                </div>
                            </div>
                        </div>
                        <div class="justifyCenter">
                            @if ($car->price_promotion > 0)
                                <b class="product-price color-red f-10" style="text-decoration:line-through;">{{ number_format($car->price_promotion, 0) }} {{ $car->currency }}</b>
                            @else
                                <b class="product-price color-red f-10" style="text-decoration:line-through;">{{ number_format($car->price_sale, 0) }} {{ $car->currency }} </b>
                            @endif
                        </div>
                        <div class="justifyCenter">
                            <button type="button" 
                                class="ht-btn btn-sm background-gray f-8" style="padding: 5px !important;">
                                VENDIDO
                            </button>
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>