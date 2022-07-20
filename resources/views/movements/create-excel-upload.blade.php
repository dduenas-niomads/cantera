@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link rel="stylesheet" href="{{ asset('argon') }}/css/myCss.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/css/bs-stepper.min.css">
@endpush

@section('href_title_name')
/movements
@endsection

@section('view_title_name')
Módulo de movimientos
@endsection

@section('nav-movements')
active
@endsection

@section('content')

@include('layouts.headers.empty')

<div class="container-fluid mt--6">
	<div class="row">
		<div class="col">
			<div class="card shadow">
				<div class="card-header">
					<h3 class="mb-0">Nuevo movimiento de mercadería por excel</h3>
				</div>
				<div class="card-body">
					<div class="col-12">
						@if (isset($message) && isset($messageClass))
							<div class="alert alert-{{ $messageClass }} alert-dismissible fade show" role="alert">
								<strong>Notificación:</strong> {{ $message }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						@endif
					</div>
					<div class="col-12">
						<form method="post" action="{{ route('movements.postCreateExcel') }}" 
							id="storeForm" autocomplete="off" enctype="multipart/form-data">
							@csrf
							@method('post')
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
									<div class="col-md-6">
									<br>
										<label class="form-control-label" for="">{{ __('Detalle de movimiento') }}</label>
										<input type="text" name="description" class="form-control" placeholder="Describa este movimiento de mercadería">
									</div>
									<div class="col-md-6">
									<br>
										<label class="form-control-label" for="">{{ __('Archivo Excel') }}</label>
										<input type="file" class="form-control" name="file">
									</div>

								</div>
							</div>
							<div class="col-md-12 row">
								<div class="col-md-12">
									<div class="text-center">
										<!-- true, true, ['ti_1'] -->
										<button type="submit" class="btn btn-success" onclick="changeTitle(this);">Cargar archivo</button>
									</div>
									<br>
								</div>
							</div>
							<div class="col-md-12">
								<p>Si no cuenta con una plantilla para productos, puede descargarla <a href="{{ asset('argon') }}/vendor/plantilla_de_productos_vacia.xlsx">aquí</a></p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="modal fade" id="modal-on-load">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h1 class="modal-title">Estamos procesando el registro. ¡En breve te daremos los resultados!</h4>
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
	var reservationCode = null;
	function changeTitle(element) {
		// element.innerHTML = "Cargando archivo, porfavor espere...";
		// element.disabled = true;
		$('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
	}
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
	function goToExcelUpload() {
        window.location.replace("/movements/create/excel-upload");
	}
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
		stepperValidation();
		// show total
		var totalAmount = 0;
		items_.forEach(element => {
			totalAmount = totalAmount + (parseFloat(element.quantity) * parseFloat(element.price));
		});
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
	}

	function createSale() {
		var saleData = {
			info: {
				type_document: document.getElementById('input-type_movement').value,
				date_start: document.getElementById('input-date_start').value,
			},
			items: items_
		};
		// send sale
		document.getElementById('submitButton').disabled = true;
		document.getElementById('submitButton').innerHTML = "Procesando...";
		$.post("/api/movements", saleData, function(data, status){
			alert(data.message);
			document.getElementById('submitButton').disabled = false;
			document.getElementById('submitButton').innerHTML = "Crear movimiento";
			goToReservations();
		}).fail(function(data, status) {
			alert(data.responseJSON.message);
			document.getElementById('submitButton').disabled = false;
			document.getElementById('submitButton').innerHTML = "Crear movimiento";
		});
	}

	function goToReservations() {
        window.location.replace("/movements");
	}

	function saveNewPayment() {
		var newPayment = document.getElementById('input_new_payment').value;
		if (parseFloat(newPayment) > 0) {
			// monto del adelanto
			var trCode = new Date();
			document.getElementById('input_new_payment').value = "0";
			addNewItem({
				"id": "999999",
				"name": "Adelanto",
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