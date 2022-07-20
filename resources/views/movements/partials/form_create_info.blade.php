<div class="col-12">
    <div class="form-group">
        <br>
        <div class="row">
            <div class="col-md-6">
                <label class="form-control-label" for="">{{ __('Tipo de movimiento') }}</label>
                <select name="type_movement" id="input-type_movement" class="form-control">
                    <option value="1">Ingreso de mercadería</option>
                    <option value="2">Salida de mercadería</option>
                    <option value="3">Recuento de mercadería</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-control-label" for="">{{ __('Fecha de movimiento') }}</label>
                <input type="date" class="form-control" name="date_start" id="input-date_start" placeholder="Fecha de movimiento">
            </div>
            <div class="col-md-12">
            <br>
                <label class="form-control-label" for="">{{ __('Detalle de movimiento') }}</label>
                <input type="text" name="description" id="input-description" class="form-control" placeholder="Describa este movimiento de mercadería">
            </div>
        </div>
    </div>
    <div class="col-md-12 row">
        <div class="col-md-12">
            <div class="text-center">
                <button type="button" class="btn btn-success" 
                    onclick="goToExcelUpload();">Cargar archivo excel</button>
                    <!-- true, true, ['ti_1'] -->
                <button type="button" class="btn btn-default" 
                    onclick="stepperValidation();">Continuar manualmente</button>
            </div>
            <br>
        </div>
    </div>
</div>