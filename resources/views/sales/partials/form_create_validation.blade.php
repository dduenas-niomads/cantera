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
            <label for="">Comentarios adicionales</label>
            <input type="text" class="form-control" id="input-commentary" placeholder="Agrega los tipos de pago o detalles adicionales de la venta">
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