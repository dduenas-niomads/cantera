<div class="{{ $class ?? 'col-lg-12' }}">
    <!-- Product item -->
    <div class="product-item hover-img">
        <a href="/store/car-detail/{{ $car->id }}" class="product-img">
            @if(!is_null($car->images_json) 
                && isset($car->images_json['custom_image1']))
                <img class="web" height="300px" src="{{ '/' . $car->images_json['custom_image1'] }}">
                <img class="mobileBanner" src="{{ '/' . $car->images_json['custom_image1'] }}">
            @else
                <img src="/store/images/default.png" alt="jc ugarte">
            @endif
        </a>	
        <div class="product-caption">
            <h4 class="product-name">
                <a href="/store/car-detail/{{ $car->id }}">{{ $car->brand }} {{ $car->model }} {{ $car->model_year }}</a><span class="f-15"> {{ $car->currency }} {{ number_format($car->price_sale) }}</span>
            </h4>
        </div>
        <ul class="absolute-caption">
            <li><i class="fa fa-clock-o"></i>{{ $car->model_year }}</li>
            <li><i class="fa fa-car"></i>{{ isset($car->details) ? $car->details->transmition : "--" }}</li>
            <li><i class="fa fa-road"></i>{{ isset($car->details) ? $car->details->traction : "--" }}</li>
        </ul>
    </div>
</div>