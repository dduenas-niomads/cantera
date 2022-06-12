<div class="col-12">
    <div class="form-group">
        <br>
        <div class="row">
            <div class="col-md-6">
                <label class="form-control-label" for="">{{ __('Tipo de movimiento') }}</label>
                <select name="type_movement" id="input-type_movement" class="form-control">
                    <option value="1">Ingreso de mercadería</option>
                    <option value="2">Salida de mercadería</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-control-label" for="">{{ __('Fecha de movimiento') }}</label>
                <input type="date" class="form-control" name="date_start" id="input-date_start" placeholder="Fecha de movimiento">
            </div>
        </div>
    </div>
    <div class="col-md-12 row">
        <div class="col-md-12">
            <div class="text-center">
                <button type="button" class="btn btn-default" 
                    onclick="stepperValidation();">Continuar</button>
                    <!-- true, true, ['ti_1'] -->
            </div>
            <br>
        </div>
    </div>
</div>