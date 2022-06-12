<div class="col-md-12">
    <div class="product-item hover-img" style="text-align: left;">
        <div class="row">
            <div class="col-sm-12 col-md-5 col-lg-5">
                <a href="/store/car-detail/{{ $car->id }}" class="product-img">
                @if(!is_null($car->images_json) 
                    && isset($car->images_json['custom_image1']))
                    <img src="{{ '/' . $car->images_json['custom_image1'] }}">
                @else
                    <img src="/store/images/default.png" alt="jc ugarte">
                @endif
                </a>
            </div>
            <div class="col-sm-12 col-md-7 col-lg-7">
                <div class="product-caption">
                    @if (is_null($car->price_promotion))
                        <h4 class="product-name" style="padding-left: 0px; background-color: #f5f5f5; font-size: 2rem;">
                            <a href="/store/car-detail/{{ $car->id }}" class="f-24">{{ $car->brand }} {{ $car->model }} {{ $car->model_year }}</a>
                        </h4>
                        <b class="product-price color-red">{{ $car->currency }} {{ number_format($car->price_sale) }}</b>
                    @else
                        <h4 class="" style="background-color: #f0ad4e; text-align: center; color: #fff;">
                            <b class="f-24">¡OFERTA DEL DÍA!</b>
                        </h4>
                        <h4 class="product-name" style="padding-left: 0px; background-color: #f5f5f5; font-size: 2rem;">
                            <a href="/store/car-detail/{{ $car->id }}" class="f-24">{{ $car->brand }} {{ $car->model }} {{ $car->model_year }}</a>
                        </h4>
                        <b class="product-price color-gray" style="text-decoration:line-through;">{{ $car->currency }} {{ number_format($car->price_sale) }} </b> 
                        <b class="product-price color-red">{{ $car->currency }} {{ number_format($car->price_promotion) }}</b>
                    @endif
                    <p class="product-txt m-t-lg-10">{{ (isset($car->details) && strlen($car->details->description)) ? $car->details->description : "Descripción no disponible" }}</p>
                    <ul class="static-caption m-t-lg-20">
                        <li><i class="fa fa-clock-o"></i>{{ $car->model_year }}</li>
                        <li><i class="fa fa-car"></i>{{ isset($car->details) ? $car->details->transmition : "--" }}</li>
                        <li><i class="fa fa-road"></i>{{ isset($car->details) ? $car->details->traction : "--" }}</li>
                        <li><i class="fa fa-tachometer"></i>{{ isset($car->details) ? $car->details->kilometers : "--" }}</li>
                        
                    </ul>
                    <div class="col-md-12 col-xs-12" style="padding-left: 0px;">
                    <br>
                        <button type="button" onClick="window.location.href = '/store/car-detail/{{ $car->id }}';" class="ht-btn btn-lg background-blue">
                            <i class="fa fa-car"></i> Ver detalles
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>