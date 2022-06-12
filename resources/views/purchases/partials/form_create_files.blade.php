
<div class="col-md-12">
    <div class="form-group" id="files_json">
        <label class="form-control-label" for="input-price_sale">{{ __('Documentos de compra obligatorios') }}</label>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="files_json[0][name]" 
                    class="form-control" placeholder="Nombre del documento" 
                    value="TARJETA DE PROPIEDAD" readonly>
            </div>
            <div class="col-md-6">
                <input type="file" name="files_json[0][value]" class="form-control" placeholder="Seleccione un documento" value="" >
            </div>
        </div><br/>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="files_json[1][name]" 
                    class="form-control" placeholder="Nombre del documento" 
                    value="SOAT" readonly>
            </div>
            <div class="col-md-6">
                <input type="file" name="files_json[1][value]" class="form-control" placeholder="Seleccione un documento" value="" >
            </div>
        </div><br/>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="files_json[2][name]" 
                    class="form-control" placeholder="Nombre del documento" 
                    value="GRAVAMEN SUNARP" readonly>
            </div>
            <div class="col-md-6">
                <input type="file" name="files_json[2][value]" class="form-control" placeholder="Seleccione un documento" value="" >
            </div>
        </div><br/>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="files_json[3][name]" 
                    class="form-control" placeholder="Nombre del documento" 
                    value="PAPELETA SAT" readonly>
            </div>
            <div class="col-md-6">
                <input type="file" name="files_json[3][value]" class="form-control" placeholder="Seleccione un documento" value="" >
            </div>
        </div><br/>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="files_json[4][name]" 
                    class="form-control" placeholder="Nombre del documento" 
                    value="PAPELETA CALLAO" readonly>
            </div>
            <div class="col-md-6">
                <input type="file" name="files_json[4][value]" class="form-control" placeholder="Seleccione un documento" value="" >
            </div>
        </div><br/>
        <label class="form-control-label" for="input-price_sale">{{ __('Documentos de compra opcionales') }}</label>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="files_json[5][name]" 
                    class="form-control" placeholder="Nombre del documento" 
                    value="REVISIÓN TÉCNICA" readonly>
            </div>
            <div class="col-md-6">
                <input type="file" name="files_json[5][value]" class="form-control" placeholder="Seleccione un documento" value="" >
            </div>
        </div><br/>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="files_json[6][name]" 
                    class="form-control" placeholder="Nombre del documento" 
                    value="PERMISO DE LUNAS" readonly>
            </div>
            <div class="col-md-6">
                <input type="file" name="files_json[6][value]" class="form-control" placeholder="Seleccione un documento" value="" >
            </div>
        </div><br/>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="files_json[7][name]" 
                    class="form-control" placeholder="Nombre del documento" 
                    value="IMPUESTO VEHICULAR" readonly>
            </div>
            <div class="col-md-6">
                <input type="file" name="files_json[7][value]" class="form-control" placeholder="Seleccione un documento" value="" >
            </div>
        </div><br/>
        <label class="form-control-label" for="input-price_sale">{{ __('¿Más documentos?') }}  
            <a href="javascript:void(0);" onclick="newElement();"><i class="fas fa-plus"></i> (Clic para añadir nuevo)</a></label>
    </div>
</div>
<div class="col-md-12 row">
    <div class="col-md-12">
        <div class="text-center">
            <button type="button" class="btn btn-default" onclick="stepperValidation(false);">Regresar</button>
            <button type="button" class="btn btn-success" onclick="submitForm('storeForm');">Finalizar</button>
        </div>
        <br>
    </div>
</div>