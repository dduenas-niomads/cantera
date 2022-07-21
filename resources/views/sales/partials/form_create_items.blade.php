<div class="col-md-12">
    <div class="row">
        @if (!is_null($reservation))
        <div class="col-md-12">
            <h5 for="">Datos de reserva</h5>
            <div class="row">
                <div class="col-md-4 col-6">
                    <label for="">Código</label>
                    <p>{{ str_pad($reservation->id, 6, "0", STR_PAD_LEFT) }}</p>
                </div>
                <div class="col-md-4 col-6">
                    <label for="">Fecha y hora</label>
                    <input type="hidden" id="reservationName_" value='{{ $reservation->reservation_date }} {{ $reservation->reservation_hour_hh }}:{{ str_pad($reservation->reservation_hour_mm, 2, "0", STR_PAD_LEFT) }} {{ $reservation->reservation_hour_ampm }}'>
                    <input type="hidden" id="reservationTime_" value='{{ $reservation->reservation_time }} minutos y {{ $reservation->additional_time }} extra'>
                    <p>{{ $reservation->reservation_date }} {{ $reservation->reservation_hour_hh }}:{{ str_pad($reservation->reservation_hour_mm, 2, "0", STR_PAD_LEFT) }} {{ $reservation->reservation_hour_ampm }}</p>
                </div>
                <div class="col-md-4 col-6">
                    <label for="">Tiempo</label>
                    <p>{{ $reservation->reservation_time }} minutos y {{ $reservation->additional_time }}' extra</p>
                </div>
                <div class="col-md-4 col-6">
                    <label for="">Costo por hora</label>
                    <div class="row">
                        <input type="hidden" id="unit_time" value="{{ $reservation->unit_time }}">
                        <input type="hidden" id="cost_pr_hour" value="{{ $reservation->price_pr_hour }}">
                        <div class="col-md-8 col-8" id="pCostPrHour">S/ {{ $reservation->price_pr_hour }}</div>
                        <div class="col-md-4 col-4"><button type="button" class="btn btn-secondary btn-sm" onclick="changeCostPrHour();"><i class="fas fa-edit"></i></button></div>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <label for="">Adelantos</label>
                    <input type="hidden" id="payments" value="{{ (float)$reservation->payment }}">
                    <p>S/ {{ (float)$reservation->payment }}</p>
                </div>
                <div class="col-md-4 col-6">
                    <label for="">Pendiente</label>
                    <p id="pPendingCost">S/ {{ $reservation->pending_cost }}</p>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-success"  onclick="newPayment();">Agregar adelanto</button>
            <br>
            <br>
        </div>
        @endif
        <div class="col-md-12">
            <h5 for="">Items de venta</h5>
            <div class="table-responsive-sm">
                <table class="myTable align-items-center table-bordered table-hover table-sm" id="itemsListDataTable">
                    <thead>
                        <th scope="col" class="thTaxationLeft">Código</th>
                        <th scope="col" class="thTaxationMiddle">Familia</th>
                        <th scope="col" class="thTaxationMiddle">Subfamilia</th>
                        <th scope="col" class="thTaxationMiddle">Genérico</th>
                        <th scope="col" class="thTaxationMiddle">Marca/Lab</th>
                        <th scope="col" class="thTaxationMiddle">Nombre</th>
                        <th scope="col" class="thTaxationMiddle">Cantidad</th>
                        <th scope="col" class="thTaxationMiddle">Precio unitario</th>
                        <th scope="col" class="thTaxationRight"><a id="buttonNew" class="button btn btn-success btn-sm" href="javascript:void(0);" onclick="newItemTd();"><i class="fas fa-plus"></i></a></th>
                    </thead>
                    <tbody id="expenses_json">
                    </tbody>
                </table>
            </div>
            <br>
        </div>
    </div>
</div>
<div class="col-md-12 row">
    <div class="col-md-12">
        <div class="text-center">
            <button type="button" class="btn btn-default" onclick="stepperValidation(false);">Regresar</button>
            <button type="button" class="btn btn-success" onclick="lastStep();">Continuar</button>
        </div>
        <br>
    </div>
</div>