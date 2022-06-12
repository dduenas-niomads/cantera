<!-- MODALS -->
<x_section>
    <div class="x_content">
        <div class="modal fade"  id="expensesModal"  tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="x_modal-body-wrapper">
                        <div class="x_modal-body-expenses" id="printThisExpenses">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    {{ __('Resultado de gastos del vehículo: ') }} <b id="em_carName"></b><br>
                                    {{ __('Fecha de ingreso: ') }} <b id="em_carRegisterDate"></b><br>
                                    {{ __('Fecha de compra: ') }} <b id="em_purchaseDate"></b><br>
                                    {{ __('Fecha de venta: ') }} <b id="em_saleDate"></b>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <input type="hidden" name="date_diff" id="date_diff" value="{{ isset($dateDiff) ? $dateDiff : 0 }}">
                            <div class="modal-body">
                                <label for="">Resumen de gastos en dólares</label>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered align-items-center">
                                        <thead class="">
                                            <th class="thTaxationLeft">Precio compra</th>
                                            <th class="thTaxationMiddle">Precio venta</th>
                                            <th class="thTaxationMiddle">Precio costo</th>
                                            <th class="thTaxationMiddle">Ingreso</th>
                                            <th class="thTaxationMiddle">Costo diario</th>
                                            <th class="thTaxationMiddle">Gastos diarios</th>
                                            <th class="thTaxationMiddle">Gastos añadidos</th>
                                            <th class="thTaxationMiddle"><b>Total de gastos</b></th>
                                            <th class="thTaxationRight"><b>Utilidad</b></th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td id="expenses_pc">0.00</td>
                                                <td id="expenses_pv">0.00</td>
                                                <td id="expenses_pcost">0.00</td>
                                                <td id="expenses_gd">0.00</td>
                                                <td id="expenses_days">0.00</td>
                                                <td id="expenses_days_x_gd">0.00</td>
                                                <td id="expenses_amount">0.00</td>
                                                <td><b id="total_expenses">0.00</b></td>
                                                <td><b id="total_utility">0.00</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <label for="">Detalle de gastos añadidos</label>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered align-items-center table-striped">
                                        <thead class="">
                                            <th class="thTaxationLeft">Nombre</th>
                                            <th class="thTaxationMiddle">Detalle</th>
                                            <th class="thTaxationMiddle">Fecha</th>
                                            <th class="thTaxationMiddle">Monto</th>
                                            <th class="thTaxationMiddle">T.cambio</th>
                                            <th class="thTaxationRight">Monto USD</th>
                                        </thead>
                                        <tbody id="tbodyExpensesDetail">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('REGRESAR') }}</button>
                        <button type="button" class="btn btn-success" id="btnPrintModalExpenses">{{ __('IMPRIMIR') }}</button>
                        <a id="carExpensesAhref" type="button" class="btn btn-default" href=""></a> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</x_section>
<div class="modal fade"  id="deleteModal"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('¿Desea eliminar este registro?') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>{{ __('Porfavor, confirme si desea eliminar este registro') }}</p>
        </div>
        <div class="modal-footer">
            <button type="button" onClick="submitForm('deleteForm');" class="btn btn-danger">{{ __('ELIMINAR') }}</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('REGRESAR') }}</button>
        </div>
        </div>
    </div>
</div>
<div class="modal fade"  id="updateModal"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('¿Desea guardar los cambios de este registro?') }}</h5>
        </div>
        <div class="modal-body">
            <p>{{ __('Porfavor, confirme si desea continuar con el guardado de la información.') }}</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="updateSpinnerButton" style="display: none;" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Guardando. Por favor, espere...
            </button>
            <button type="button" onClick="submitForm('updateForm');" id="updateActionButton" 
                class="btn btn-success">
                {{ __('GUARDAR') }}
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="updateCancelButton">
                {{ __('REGRESAR') }}
            </button>
        </div>
        </div>
    </div>
</div>
<div class="modal fade"  id="reintegroModal"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('¿Desea hacer el reintegro de este vehículo?') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>{{ __('Porfavor, confirme si desea continuar con el guardado de la información.') }}</p>
        </div>
        <div class="modal-footer">
            <button type="button" onClick="submitForm('updateForm2');" class="btn btn-success">{{ __('REINTEGRAR') }}</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('REGRESAR') }}</button>
        </div>
        </div>
    </div>
</div>
<div class="modal fade"  id="alertModal"  tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
			<div class="modal-body">
				<h2 id="messageAlertModal"></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">{{ __('REVISAR') }}</button>
			</div>
        </div>
    </div>
</div>
<div class="modal fade"  id="carNullModalInfo"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('No tiene un vehículo asociado') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>{{ __('Porfavor, ingrese el código de un vehículo para iniciar con la tasación') }}</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('REGRESAR') }}</button>
        </div>
        </div>
    </div>
</div>
<div class="modal fade"  id="publishCarModal"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('¿Desea publicar el vehículo? ') }} <b id="idPublishCarModalB"></b> </h5>
            </div>
            <div class="modal-body">
                <form method="post" action="" autocomplete="off" id="publishCarModalForm">
                    @csrf
                    @method('put')
                    <input type="hidden" name="for_sale" value="1">
                    <!-- <label for="">Ingrese un comentario para la publicación</label>
                    <input type="text" class="form-control"
                        name="commentary" id="commentaryCarDetail"
                        placeholder="Comentario opcional para la publicación"> -->
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">{{ __('PUBLICAR') }}</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('REGRESAR') }}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade"  id="unpublishCarModal"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('¿Desea ocultar el vehículo? ') }} <b id="idUnpublishCarModalB"></b> </h5>
            </div>
            <div class="modal-body">
                <form method="post" action="" autocomplete="off" id="unpublishCarModalForm">
                    @csrf
                    @method('put')
                <input type="hidden" name="for_sale" value="0">
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">{{ __('OCULTAR') }}</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('REGRESAR') }}</button>
            </div>
        </div>
    </div>
</div>