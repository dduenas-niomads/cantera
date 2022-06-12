<div class="col-md-12">
    <div class="row">
        @include('purchases.partials.holder_form')
        @include('purchases.partials.owner_form')
    </div>
</div>
<div class="col-md-12 row">
    <div class="col-md-12">
        <div class="text-center">
            <button type="button" class="btn btn-default" onclick="stepperValidation(false);">Regresar</button>
            <button type="button" class="btn btn-default" onclick="stepperValidation();">Continuar</button>
        </div>
        <br>
    </div>
</div>