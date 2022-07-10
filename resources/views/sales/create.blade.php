@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link rel="stylesheet" href="{{ asset('argon') }}/css/myCss.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/css/bs-stepper.min.css">
@endpush

@section('href_title_name')
/sales
@endsection

@section('view_title_name')
Módulo de ventas
@endsection

@section('nav-sales')
active
@endsection

@section('content')

@include('layouts.headers.empty')

<div class="container-fluid mt--6">
	<div class="row">
		<div class="col">
			<div class="card shadow">
				<br>
                <div class="col-12">
					@if (isset($message) && isset($messageClass))
						<div class="alert alert-{{ $messageClass }} alert-dismissible fade show" role="alert">
							<strong>Notificación:</strong> {{ $message }}
							<button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					@endif
                    <div class="row">
                        <div class="col-md-6">
                            <form method="get" action="{{ route('sales.create') }}" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" maxlength="20" name="reservation_code" id="input-reservation_code" 
                                                class="form-control" 
                                                placeholder="{{ __('Ingrese código de reserva') }}" value="{{ !is_null($reservation) ? str_pad($reservation->id, 6, 0, STR_PAD_LEFT) : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="submit" 
                                                class="btn btn-default">{{ __('Buscar reserva') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
				<div class="col-12">
					<form method="post" action="{{ route('sales.store') }}" 
						id="storeForm" autocomplete="off" enctype="multipart/form-data">
						@csrf
						@method('post')
						<div id="stepperDiv" class="bs-stepper">
							<div class="bs-stepper-header">
								<div class="step" data-target="#test-nl-1">
									<button type="button" class="btn step-trigger">
										<span class="bs-stepper-circle">1</span>
										<span class="bs-stepper-label">Datos de venta</span>
									</button>
								</div>
								<div class="line"></div>
								<div class="step" data-target="#test-nl-2">
									<div class="btn step-trigger">
										<span class="bs-stepper-circle">2</span>
										<span class="bs-stepper-label">Items</span>
									</div>
								</div>
								<div class="line"></div>
								<div class="step" data-target="#test-nl-3">
									<button type="button" class="btn step-trigger">
										<span class="bs-stepper-circle">3</span>
										<span class="bs-stepper-label">Cobrar</span>
									</button>
								</div>
							</div>
							<div class="bs-stepper-content">
								<div id="test-nl-1" class="content">
									@include('sales.partials.form_create_sale')
								</div>
								<div id="test-nl-2" class="content">
									@include('sales.partials.form_create_items')
								</div>
								<div id="test-nl-3" class="content">
									@include('sales.partials.form_create_validation')
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="card-footer py-4">
					<nav class="d-flex justify-content-end" aria-label="...">
					</nav>
				</div>
			</div>
		</div>
	</div>
	
    <div class="modal fade"  id="changeCostPrHourModal"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
				<div class="modal-body">
					<h5 class="modal-title">{{ __('¿Desea cambiar el costo por hora para esta venta?') }}</h5>
					<br>
					<div>
						<label for="">Costo por hora actual</label>
						<input type="number" maxlength="10" id="input_cost_pr_hour" 
							class="form-control " 
							placeholder="{{ __('Ingrese costo por hora') }}">
						<br>
					</div>
					<div>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('VOLVER') }}</button>
						<button type="button" id="submitButtonCostPrHourModal" onClick="saveCostPrHour();" class="btn btn-success">{{ __('GUARDAR CAMBIOS') }}</button>
					</div>
				</div>
            </div>
        </div>
    </div>
    <div class="modal fade"  id="newPaymentModal"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
				<div class="modal-body">
					<h5 class="modal-title">{{ __('¿Desea agregar un nuevo adelanto?') }}</h5>
					<br>
					<div>
						<label for="">Monto del adelanto</label>
						<input type="number" maxlength="10" id="input_new_payment" 
							class="form-control " 
							placeholder="{{ __('Ingrese monto del adelanto en soles') }}">
						<br>
					</div>
					<div>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('VOLVER') }}</button>
						<button type="button" id="submitButtonnNewPaymentModal" onClick="saveNewPayment();" class="btn btn-success">{{ __('AGREGAR ADELANTO') }}</button>
					</div>
				</div>
            </div>
        </div>
    </div>
    <div class="modal fade"  id="newItemModal"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title">{{ __('¿Desea agregar un nuevo item?') }}</h5>
                <br>
                <label for="">Nombre del producto</label>
                <div>
                    <div id="mainheaderProductName">
                        <input type="hidden" class="form-control" id="item_product_id" value="">
                        <input type="text" maxlength="50" id="item_product" 
                            onkeyup="autocompleteAjaxForProduct('mainheaderProductName', 'item_product', 'autocomplete', null, null, 'products');"
                            class="form-control " 
                            placeholder="{{ __('Ingrese nombre del producto') }}" autocomplete="off">
                    </div>
                </div>
                <br>
                <label for="">Código del producto</label>
                <div>
					<input type="text" maxlength="50" id="item_product_code" 
						class="form-control " 
						placeholder="{{ __('Ingrese código del producto') }}" autocomplete="off">
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Cantidad</label>
                        <input type="number" class="form-control" id="item_quantity" placeholder="Ingrese cantidad" maxlength="10" autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label for="">Precio unitario</label>
                        <input type="text" class="form-control" id="item_unit_price" placeholder="Ingrese precio"  maxlength="10" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('VOLVER') }}</button>
                <button type="button" id="submitButton" onClick="addNewItem();" class="btn btn-success">{{ __('AGREGAR ITEM') }}</button>
            </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.modals.default')

@endsection

@push('js')
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.ES.js" charset="UTF-8"></script>
<script src="{{ asset('argon') }}/js/default.js"></script>
<script src="{{ asset('argon') }}/js/bs-stepper.min.js"></script>

<script>
	var costPrHour = null;
	if (document.getElementById('cost_pr_hour')) {
		costPrHour = document.getElementById('cost_pr_hour').value;
	}
	var payments = 0;
	if (document.getElementById('payments')) {
		payments = document.getElementById('payments').value;
	}
	var items_ = [];
	var reservationCode = document.getElementById('input-reservation_code').value;
	var stepper = new Stepper(document.querySelector('#stepperDiv'));
	function stepperValidation(goNext = true, validateForm = false, idObjectsToValidate = []) {
		if (goNext) {
		if (validateForm) {
			var validation = true;
			idObjectsToValidate.forEach(element => {
				var inpObj = document.getElementById(element);
				var divInpObj = document.getElementById('div_' + element);
				if (!inpObj.checkValidity()) {
					var message = document.getElementById('message_' + element);
					if (message != null) {
						message.remove();
					}
					inpObj.focus();
					b = document.createElement("DIV");
					b.setAttribute("id", "message_" + element);
					b.innerHTML += '<p style="font-size: 12px;">Este dato es <b>necesario para continuar</b>.</p>';
					divInpObj.appendChild(b);
					validation = false;
					return;
				}
			});
			if (validation) {
				stepper.next();					
			}
		} else {
			stepper.next();
		}
		} else {
		stepper.previous();
		}
	}
	var positionCount = 0;
	function updateExpensesValues(element) {
		// calcular utilidad facturable
		var baseAmount = 0;
		var inputInvoicedValue = 0;
		var rentAmount = 0;
		var igvAmount = 0;
		var expensesAmount = 0;
		var inputPurchaseInvoiced = document.getElementById('input-purchase_invoiced');
		var inputInvoiced = document.getElementById('input-invoiced');
		if (inputPurchaseInvoiced != null && inputInvoiced != null 
			&& inputPurchaseInvoiced.value != "" && inputInvoiced.value != "") {
			inputInvoicedValue = parseFloat(inputInvoiced.value);
			baseAmount = parseFloat(inputInvoiced.value) - parseFloat(inputPurchaseInvoiced.value);
		}
		// calcular igv
		var labelExpensesIGVAmount = document.getElementById('label-expenses_igv_amount');
		var inputExpensesIGVAmount = document.getElementById('input-expenses_igv_amount');
		if (labelExpensesIGVAmount != null && inputExpensesIGVAmount != null) {
			igvAmount = (baseAmount - baseAmount/1.18);
			labelExpensesIGVAmount.innerHTML = "IGV SOBRE: " + baseAmount.toFixed(0);
			inputExpensesIGVAmount.value = igvAmount.toFixed(0);
			var expenses_igv_detail = document.getElementById('expenses_igv_detail');
			if (expenses_igv_detail != null) {
				expenses_igv_detail.value = baseAmount.toFixed(0);
			}
		}
		// calcular renta
		var labelExpensesRentAmount = document.getElementById('label-expenses_rent_amount');
		var inputExpensesRentAmount = document.getElementById('input-expenses_rent_amount');
		if (labelExpensesRentAmount != null && inputExpensesRentAmount != null) {
			rentAmount = (inputInvoicedValue*0.015);
			labelExpensesRentAmount.innerHTML = "RENTA SOBRE: " + (inputInvoicedValue).toFixed(0);
			inputExpensesRentAmount.value = rentAmount.toFixed(0);
		}
		// actualizar gastos y costo total
		var costWithoutTaxes = document.getElementById('cost_without_taxes');
		if (costWithoutTaxes != null) {
			// gastos
			var inputPriceExpenses = document.getElementById('input-price_expenses');
			if (inputPriceExpenses != null) {
				expensesAmount = parseFloat(costWithoutTaxes.value) + rentAmount + igvAmount;
				inputPriceExpenses.value = expensesAmount.toFixed(0);
			}
			// costo total
			var inputPriceCompra = document.getElementById('input-price_compra');
			var inputTotalCost = document.getElementById('input-total_cost');
			if (inputTotalCost != null && inputPriceCompra != null) {
				inputTotalCost.value = (parseFloat(inputPriceCompra.value) + expensesAmount).toFixed(0);
			}
		}		
	}

	function changeCostPrHour() {
		document.getElementById('input_cost_pr_hour').value = costPrHour;
        $('#changeCostPrHourModal').modal();
	}

	function saveCostPrHour() {
		var newCostPrHour = document.getElementById('input_cost_pr_hour').value;
		var unitTime = document.getElementById('unit_time').value;
		if (parseFloat(newCostPrHour) > 0) {
			// costo por hora
			costPrHour = newCostPrHour;
			document.getElementById('pCostPrHour').innerHTML = "S/ " + parseFloat(costPrHour);
			// pendiente
			document.getElementById('pPendingCost').innerHTML = "S/ " + ((parseFloat(costPrHour)*parseFloat(unitTime)) - parseFloat(payments));
        	$('#changeCostPrHourModal').modal('hide');			
		} else {
			alert("El costo debe ser mayor a S/ 0.00");
			return;
		}		
	}

	function deleteItem(itemId) {
		var itemElement = document.getElementById(itemId);
		if (itemElement) {
			for (var key in items_) {
				if (items_[key].trCode == itemId) {
					items_.splice(key, 1);
					itemElement.remove();
				}
			}
		} else {
			alert("Error en carga HTML.");
		}
	}

	function newPayment() {
		$('#newPaymentModal').modal();
	}

	function lastStep() {
		var clientName = document.getElementById('input-client_name').value;
		if (clientName == "") {
			alert("Antes de continuar, ingrese un cliente.")
			return;
		} else {
			// show total
			var totalAmount = 0;
			items_.forEach(element => {
				totalAmount = totalAmount + (parseFloat(element.quantity) * parseFloat(element.price));
			});
			if (totalAmount != 0) {
				stepperValidation();
				document.getElementById('totalAmount').innerHTML = "S/ " + totalAmount;
				// tbodyDetail
				var items_detail = document.getElementById('tbodyDetail');
				items_detail.innerHTML = "";
				if (items_detail) {
					items_.forEach(item => {
						b = document.createElement("TR");
						b.innerHTML += '<td>' + item.name + '</td>' +
							'<td>' + item.quantity + '</td>' +
							'<td>' + item.price + '</td>' +
							'<td>' + (parseFloat(item.quantity)*parseFloat(item.price)) + '</td>'; 
						items_detail.appendChild(b);
					});
				}				
			} else {
				alert("No puede crear una venta sin productos o en monto cero.");
			}
		}
	}

	function createSale() {
		var saleData = {
			info: {
				client_id : document.getElementById('input-client_name_id').value,
				client_type_document: document.getElementById('input-client_type_document').value,
				client_document_number: document.getElementById('input-client_document_number').value,
				client_name: document.getElementById('input-client_name').value,
				type_document: document.getElementById('input-type_document').value,
				document_id: document.getElementById('input-document_number').value,
				commentary: document.getElementById('input-commentary').value,
				gateway_id: document.getElementById('gateway_id').value,
				reservation_id: reservationCode,
				reservation_cost_pr_hour: costPrHour
			},
			items: items_
		};
		// send sale
		document.getElementById('submitButton').disabled = true;
		document.getElementById('submitButton').innerHTML = "Procesando...";
		$.post("/api/sales", saleData, function(data, status){
			alert(data.message);
			document.getElementById('submitButton').disabled = false;
			document.getElementById('submitButton').innerHTML = "Crear venta";
			goToReservations();
		}).fail(function(data, status) {
			alert(data.responseJSON.message);
			document.getElementById('submitButton').disabled = false;
			document.getElementById('submitButton').innerHTML = "Crear venta";
		});
	}

	function goToReservations() {
        window.location.replace("/sales");
	}

	function saveNewPayment() {
		var newPayment = document.getElementById('input_new_payment').value;
		if (parseFloat(newPayment) > 0) {
			// monto del adelanto
			var reservationTime_ = document.getElementById('reservationTime_');
			var reservationName_ = document.getElementById('reservationName_');
			var reservationTimeText_ = "";
			var reservationNameText_ = "";
			if (reservationTime_ && reservationName_) {
				reservationTimeText_ = reservationTime_.value;
				reservationNameText_ = reservationName_.value;
			}
			var trCode = new Date();
			document.getElementById('input_new_payment').value = "0";
			addNewItem({
				"id": "999999",
				"name": "Adelanto para reserva: " + reservationNameText_ + " (Tiempo: " + reservationTimeText_ + ")",
				"code": "ADELANTO-" + reservationCode,
				"quantity": 1,
				"price": newPayment,
				"trCode": trCode.getTime()
			});
        	$('#newPaymentModal').modal('hide');
		} else {
			alert("El adelanto debe ser mayor a S/ 0.00");
			return;
		}
	}

	function newItemTd() {
		$('#newItemModal').modal();
	}

	function addNewItem(item = null) {
		var expenses_json = document.getElementById('expenses_json');
		var trCode = new Date();
		if (expenses_json) {
			if (item == null) {
				item = {
					"id": document.getElementById('item_product_id').value,
					"name": document.getElementById('item_product').value,
					"code": document.getElementById('item_product_code').value,
					"quantity": document.getElementById('item_quantity').value,
					"price": document.getElementById('item_unit_price').value,
					"trCode": trCode.getTime(),
				};
				if (item.name == "") {
					alert("Ingrese un nombre de producto.");
					return;
				}
				if (item.code == "") {
					alert("Ingrese un código de producto.");
					return;
				}
				if (item.quantity == "") {
					alert("Ingrese la cantidad a vender.");
					return;
				}
				if (!(parseInt(item.quantity) > 0)) {
					alert("La cantidad debe ser mayor a cero.");
					return;
				}
				if (item.price == "") {
					alert("Ingrese el precio del producto");
					return;
				}
				if (!(parseFloat(item.price) > 0)) {
					alert("El precio debe ser mayor a S/ 0.00");
					return;
				}
				document.getElementById('item_product_id').value = "";
				document.getElementById('item_product').value = "";
				document.getElementById('item_product_code').value = "";
				document.getElementById('item_quantity').value = "";
				document.getElementById('item_unit_price').value = "";
			}
			items_.push(item);
			b = document.createElement("TR");
			b.setAttribute("id", item.trCode);
			b.innerHTML += '<td>' + item.code + '</td>' +
				'<td>' + item.name + '</td>' +
				'<td>' + item.quantity + '</td>' +
				'<td>' + item.price + '</td>' + 
				'<td><button type="button" onclick="deleteItem(' + item.trCode + ')" class="btn btn-sm btn-danger">Borrar</button></td>';
			expenses_json.appendChild(b);
			$('#newItemModal').modal('hide');
		}
	}
    </script>
@endpush