<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <label>Items</label>
            <table class="table table-sm table-responsive">
                <thead>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </thead>
                <tbody id="tbodyDetail"></tbody>
            </table>
            <br>
            <label for="">Total por cobrar:</label>
            <h1 id="totalAmount">S/ 0.00</h1>
            <br>
            <label for="">Canal de pagos</label>
            <select id="gateway_id" class="form-control">
                @foreach ($gateways as $gatewayInfo)
                    <option value="{{ $gatewayInfo->id }}">{{ $gatewayInfo->name }}</option>
                @endforeach
            </select>
            <br>
            <label for="">Detalle o comentarios adicionales</label>
            <input type="text" class="form-control" id="input-commentary" placeholder="Agrega comentarios sobre esta venta. (Opcional)">
            <br>
        </div>
    </div>
</div>
<div class="col-md-12 row">
    <div class="col-md-12">
        <div class="text-center">
            <button type="button" class="btn btn-default" onclick="stepperValidation(false);">Regresar</button>
            <button type="button" id="submitButton" class="btn btn-success" onclick="createSale();">Crear venta</button>
        </div>
        <br>
    </div>
</div>