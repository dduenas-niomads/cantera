// EXCHANGE RATE
var exchangeRate = 3.90;
var exchangeRateInput = document.getElementById('exchange_rate');
if (exchangeRateInput != null) {
    exchangeRate = exchangeRateInput.value;
}
// DATEPICKER
$('.datepicker').datepicker({
    language: 'es',
    format: 'dd/mm/yyyy',
    autoclose: true,
    disableTouchKeyboard: true,
});

function localeDatePeru(date) {
    return date.toLocaleDateString() + " " + formatAMPM(date);
}
function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}
// AUTOCOMPLETE LOGIC
function autocompleteAjax(headerId, inputId, tagName, inputParent = null, parentTagName = null, resource = 'masters') {
    // mainheader
    var mainHeader = document.getElementById(headerId);
    if (mainHeader == null) { return false;}
    // parent
    var inpParent = null;
    if (inputParent != null) { inpParent = document.getElementById(inputParent);}
    // input & inputId
    var inp = document.getElementById(inputId);
    var nameInpId = inp.name.replace(tagName, tagName + '_id');
    var inpId = document.getElementById(nameInpId);
    if (inp == null) { return false;}
    if (inpId == null) {
        a = document.createElement("INPUT");
        a.setAttribute("type", "hidden");
        a.setAttribute("name", nameInpId);
        a.setAttribute("id", nameInpId);
        mainHeader.parentNode.appendChild(a);			
    }
    var currentFocus;
    var a, b, i, val = inp.value;
    closeAllLists();
    if (!val) { return false;}
    currentFocus = -1;
    a = document.createElement("DIV");
    a.setAttribute("class", "autocomplete-items");
    a.setAttribute("style", "position: absolute; width: 80%; z-index:9;");
    mainHeader.parentNode.appendChild(a);
    if (val.length > 0) {
        //LLAMADA AL SERVICIO
        var url_ = "/api/" + resource + "?tag="+ tagName +"&name=" + val.toUpperCase();
        if (inpParent != null) {
            if (inpParent.value == "") {
                $("#alertModal").modal({ backdrop: 'static', keyboard: false }).on('hidden.bs.modal', function () {
                    inpParent.focus();
                  });
                document.getElementById("messageAlertModal").innerHTML = "Porfavor, completar la información del campo " +
                    "<b>" + mastersByTag[parentTagName] + "</b>";
                // inpParent.focus();
                inp.value = "";
            }
            url_ += "&parent=" + inpParent.value + "&parent_tag=" + parentTagName;
        }
        $.ajax({
            url: url_,
            context: document.body,
            statusCode: {
                404: function() { 
                    b = document.createElement("DIV");
                    b.innerHTML += '<p style="font-size: 12px;">Nuevo registro: <b>' + val.toUpperCase() + '</b></p>';
                    a.appendChild(b);
                }
            }
        }).done(function(response) {
            for (i = 0; i < response.length; i++) {
                b = document.createElement("DIV");
                b.setAttribute('class', 'form-control-autocomplete');
                if (resource === "clients") {
                    if (parseInt(response[i].type) === 2) {
                        b.innerHTML += response[i].rz_social + " (" + ((response[i].document_number) ? response[i].document_number : "SIN DOCUMENTO") + ")";
                    } else {
                        b.innerHTML += response[i].name + " (" + ((response[i].document_number) ? response[i].document_number : "SIN DOCUMENTO") + ")"
                    }
                } else {
                    b.innerHTML += response[i].name;
                }
                b.innerHTML += "<input type='hidden' value='" + JSON.stringify(response[i]) + "'>";
                b.addEventListener("click", function(e) {
                    // agregar value al input
                    var iterator = this.getElementsByTagName("input")[0].value;
                    iterator = JSON.parse(iterator);
                    if (resource === "clients") {
                        if (parseInt(iterator.type) === 2) {
                            inp.value = iterator.rz_social + " (" + ((iterator.document_number) ? iterator.document_number : "SIN DOCUMENTO") + ")";
                            inp.innerHTML = iterator.rz_social + " (" + ((iterator.document_number) ? iterator.document_number : "SIN DOCUMENTO") + ")";
                        } else {
                            inp.value = iterator.name + " (" + ((iterator.document_number) ? iterator.document_number : "SIN DOCUMENTO") + ")";
                            inp.innerHTML = iterator.name + " (" + ((iterator.document_number) ? iterator.document_number : "SIN DOCUMENTO") + ")";
                        }
                    } else {
                        inp.value = iterator.name;
                        inp.innerHTML = iterator.name;
                    }
                    // agregar value al input_id
                    if (inpId != null) {
                        inpId.value = iterator.id;
                    }
                    closeAllLists();
                });
                a.appendChild(b);
            }
        });
    }
    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    // keypress
    document.onkeypress = function (e) {
        e = e || window.event;
        if ((e.keyCode) == 13) {
            closeAllLists();
            return false;
        }
    };
}
function autocompleteAjaxForProduct(headerId, inputId, tagName, inputParent = null, parentTagName = null, resource = 'masters') {
    // mainheader
    var mainHeader = document.getElementById(headerId);
    if (mainHeader == null) { return false;}
    // parent
    var inpParent = null;
    if (inputParent != null) { inpParent = document.getElementById(inputParent);}
    // input & inputId
    var inp = document.getElementById(inputId);
    var nameInpId = inp.name.replace(tagName, tagName + '_id');
    var inpId = document.getElementById(nameInpId);
    if (inp == null) { return false;}
    if (inpId == null) {
        a = document.createElement("INPUT");
        a.setAttribute("type", "hidden");
        a.setAttribute("name", nameInpId);
        a.setAttribute("id", nameInpId);
        mainHeader.parentNode.appendChild(a);			
    }
    var currentFocus;
    var a, b, i, val = inp.value;
    closeAllLists();
    if (!val) { return false;}
    currentFocus = -1;
    a = document.createElement("DIV");
    a.setAttribute("class", "autocomplete-items");
    a.setAttribute("style", "position: absolute; width: 80%; z-index:9;");
    mainHeader.parentNode.appendChild(a);
    if (val.length > 0) {
        document.getElementById(inputId + "_id").value = "";
        document.getElementById(inputId + "_code").value = "";
        document.getElementById("item_unit_price").value = "";
        //LLAMADA AL SERVICIO
        var url_ = "/api/" + resource + "?tag="+ tagName +"&name=" + val.toUpperCase();
        if (inpParent != null) {
            if (inpParent.value == "") {
                $("#alertModal").modal({ backdrop: 'static', keyboard: false }).on('hidden.bs.modal', function () {
                    inpParent.focus();
                  });
                document.getElementById("messageAlertModal").innerHTML = "Porfavor, completar la información del campo " +
                    "<b>" + mastersByTag[parentTagName] + "</b>";
                // inpParent.focus();
                inp.value = "";
            }
            url_ += "&parent=" + inpParent.value + "&parent_tag=" + parentTagName;
        }
        $.ajax({
            url: url_,
            context: document.body,
            statusCode: {
                404: function() { 
                    b = document.createElement("DIV");
                    b.innerHTML += '<p style="font-size: 12px;">Nuevo registro: <b>' + val.toUpperCase() + '</b></p>';
                    a.appendChild(b);
                }
            }
        }).done(function(response) {
            for (i = 0; i < response.length; i++) {
                b = document.createElement("DIV");
                b.setAttribute('class', 'form-control-autocomplete');
                if (resource === "clients") {
                    console.log(response[i].type);
                    b.innerHTML += response[i].names + " (" + ((response[i].document_number) ? response[i].document_number : "SIN DOCUMENTO") + ")";
                } else {
                    b.innerHTML += response[i].name;
                }
                b.innerHTML += "<input type='hidden' value='" + JSON.stringify(response[i]) + "'>";
                b.addEventListener("click", function(e) {
                    // agregar value al input
                    var iterator = this.getElementsByTagName("input")[0].value;
                    iterator = JSON.parse(iterator);
                    inp.value = iterator.name;
                    inp.innerHTML = iterator.name;
                    document.getElementById(inputId + "_id").value = iterator.id;
                    document.getElementById(inputId + "_code").value = iterator.code;
                    document.getElementById("item_unit_price").value = iterator.price_sale;
                    // llenar datos en form cliente
                    // agregar value al input_id
                    if (inpId != null) {
                        inpId.value = iterator.id;
                    }
                    closeAllLists();
                });
                a.appendChild(b);
            }
        });
    }
    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    document.addEventListener("click", function (e) {closeAllLists(e.target);});
}
function autocompleteAjaxForClient(headerId, inputId, tagName, inputParent = null, parentTagName = null, resource = 'masters') {
    // mainheader
    var mainHeader = document.getElementById(headerId);
    if (mainHeader == null) { return false;}
    // parent
    var inpParent = null;
    if (inputParent != null) { inpParent = document.getElementById(inputParent);}
    // input & inputId
    var inp = document.getElementById(inputId);
    var nameInpId = inp.name.replace(tagName, tagName + '_id');
    var inpId = document.getElementById(nameInpId);
    if (inp == null) { return false;}
    if (inpId == null) {
        a = document.createElement("INPUT");
        a.setAttribute("type", "hidden");
        a.setAttribute("name", nameInpId);
        a.setAttribute("id", nameInpId);
        mainHeader.parentNode.appendChild(a);			
    }
    var currentFocus;
    var a, b, i, val = inp.value;
    closeAllLists();
    if (!val) { return false;}
    currentFocus = -1;
    a = document.createElement("DIV");
    a.setAttribute("class", "autocomplete-items");
    a.setAttribute("style", "position: absolute; width: 80%; z-index:9;");
    mainHeader.parentNode.appendChild(a);
    if (val.length > 0) {
        //LLAMADA AL SERVICIO
        var url_ = "/api/" + resource + "?tag="+ tagName +"&name=" + val.toUpperCase();
        if (inpParent != null) {
            if (inpParent.value == "") {
                $("#alertModal").modal({ backdrop: 'static', keyboard: false }).on('hidden.bs.modal', function () {
                    inpParent.focus();
                  });
                document.getElementById("messageAlertModal").innerHTML = "Porfavor, completar la información del campo " +
                    "<b>" + mastersByTag[parentTagName] + "</b>";
                // inpParent.focus();
                inp.value = "";
            }
            url_ += "&parent=" + inpParent.value + "&parent_tag=" + parentTagName;
        }
        $.ajax({
            url: url_,
            context: document.body,
            statusCode: {
                404: function() { 
                    b = document.createElement("DIV");
                    b.innerHTML += '<p style="font-size: 12px;">Nuevo registro: <b>' + val.toUpperCase() + '</b></p>';
                    a.appendChild(b);
                }
            }
        }).done(function(response) {
            for (i = 0; i < response.length; i++) {
                b = document.createElement("DIV");
                b.setAttribute('class', 'form-control-autocomplete');
                if (resource === "clients") {
                    b.innerHTML += response[i].name + " (" + ((response[i].document_number) ? response[i].document_number : "SIN DOCUMENTO") + ")";
                } else {
                    b.innerHTML += response[i].name;
                }
                b.innerHTML += "<input type='hidden' value='" + JSON.stringify(response[i]) + "'>";
                b.addEventListener("click", function(e) {
                    // agregar value al input
                    var iterator = this.getElementsByTagName("input")[0].value;
                    iterator = JSON.parse(iterator);  
                    inp.value = iterator.name;
                    inp.innerHTML = iterator.name;
                    document.getElementById(inputId + "_id").value = iterator.id;       
                    if (resource === "clients") {
                        var typeDocument_ = document.getElementById('input-client_type_document');
                        var documentNumber_ = document.getElementById('input-client_document_number');
                        var email_ = document.getElementById('input-client_email');
                        if (typeDocument_ && documentNumber_ && email_) {
                            typeDocument_.value = iterator.type_document;
                            documentNumber_.value = iterator.document_number;
                            email_.value = iterator.email;
                        }
                    }
                    // llenar datos en form cliente
                    // agregar value al input_id
                    if (inpId != null) {
                        inpId.value = iterator.id;
                    }
                    closeAllLists();
                });
                a.appendChild(b);
            }
        });
    }
    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    document.addEventListener("click", function (e) {closeAllLists(e.target);});
}
function cleanChilds(arrayIds = []) {
    arrayIds.forEach(element => {
        var e = document.getElementById(element);
        if (e != null) {
            e.value = "";
        }
    });
}
// UTILS
function submitForm(formId) {
    var inputNumber = document.getElementById('input-number');
    if (inputNumber != null) {
        if (!inputNumber.value.includes("-")) {
            alert("La placa debe contener un guión al medio.");
            return;
        }
    }
    var form = document.getElementById(formId);
    var actionButton = document.getElementById('updateActionButton');
    var spinnerButton = document.getElementById('updateSpinnerButton');
    var cancelButton = document.getElementById('updateCancelButton');
    if (actionButton != null) {
        actionButton.style.display = "none";
    }
    if (spinnerButton != null) {
        spinnerButton.style.display = "block";
    }
    if (cancelButton != null) {
        cancelButton.disabled = "true";
    }
    form.submit();
}
function deleteInputData(input) {
    var inputToClear = document.getElementById(input);
    if (inputToClear != null) {
        inputToClear.value = '';
    }
}
var mastersByTag = {
    "department" : "Departamento",
    "province" : "Provincia",
    "district" : "Distrito",
    "brand" : "Marca",
    "model" : "Modelo",
    "color" : "Color",
    "notary" : "Notaría",
    "holder" : "Titular",
    "owner" : "Dueño",
};
function changeDiv(condition = true, blockPerson = 'personDiv', blockCompany = 'companyDiv', inpId = 'input-type', selectId = 'input-type_document') {
    var selectValue = document.getElementById(inpId).value;
    if (parseInt(selectValue) === 1) {
        var personDiv = document.getElementById(blockPerson);
        if (personDiv != null) {
            personDiv.style.display = 'block';
            changeTypeDocumentValues(selectValue, selectId);
            var companyDiv = document.getElementById(blockCompany);
            if (companyDiv != null) {
                companyDiv.style.display = 'none';
                // borrar datos del form
                if (condition) {
                    deleteInputData('input-rz_social');
                    deleteInputData('input-commercial_name');
                    deleteInputData('input-rl_name');
                    deleteInputData('input-rl_document_number');                        
                }
            }
        }
    } else {
        var companyDiv = document.getElementById(blockCompany);
        if (companyDiv != null) {
            companyDiv.style.display = 'block';
            changeTypeDocumentValues(selectValue, selectId);
            var personDiv = document.getElementById(blockPerson);
            if (personDiv != null) {
                personDiv.style.display = 'none';
                // borrar datos del form
                if (condition) {    
                    deleteInputData('input-names');
                    deleteInputData('input-first_lastname');
                    deleteInputData('input-second_lastname');
                    deleteInputData('input-birthday');
                }
            }
        }
    }
}
function changeTypeDocumentValues(selectValue, selectId = 'input-type_document') {
    if (parseInt(selectValue) === 1) {            
        document.getElementById(selectId).innerHTML = "<option selected value='01'>DNI</option>" +
                "<option value='04'>CARNET DE EXTRANJERIA</option>" +
                "<option value='07'>PASAPORTE</option>";
    } else {
        document.getElementById(selectId).innerHTML = "<option selected value='06'>RUC</option>";
    }
}
function newExpenseElement() {
    var expensesJsonHtml = document.getElementById('expenses_json');
    if (expensesJsonHtml != null) {
        positionCount += 1;
        expensesJsonHtml.insertAdjacentHTML( 'beforeend',  '<div class="row" id="expense_element_' + positionCount + '">'+
                '<div class="col-md-2">'+
                    '<label>Nombre</label>' + 
                    '<input type="text" name="expenses_json[' + positionCount + '][name]" class="form-control" placeholder="Nombre del gasto" value="">'+
                '</div>'+
                '<div class="col-md-2">'+
                    '<label>Detalle</label>' + 
                    '<input type="text" name="expenses_json[' + positionCount + '][detail]" class="form-control" placeholder="Detalle" value="">'+
                '</div>'+
                '<div class="col-md-2">'+
                    '<label>Fecha</label>' + 
                    '<input type="text" name="expenses_json[' + positionCount + '][date]" class="form-control datepicker" placeholder="Fecha" value="">'+
                '</div>'+
                '<div class="col-md-2">'+
                    '<label>Moneda</label>' + 
                    '<select class="form-control" onChange="changeRate(' + positionCount + ', this);" name="expenses_json[' + positionCount + '][currency]">'+
                        '<option value="USD">USD</option>'+
                        '<option value="PEN">PEN</option>'+
                        '<option value="EUR">EUR</option>'+
                        '<option value="OTH">OTH</option>'+
                    '</select>'+
                '</div>'+
                '<div class="col-md-2">'+
                    '<label>Monto</label>' + 
                    '<input type="number" name="expenses_json[' + positionCount + '][value]" class="form-control" placeholder="Monto" value="">'+
                '</div>'+
                '<div class="col-md-2">'+
                    '<label>Tipo de cambio</label>' + 
                    '<div class="row">'+
                        '<div class="col-md-8">'+
                            '<input type="text" id="exchange_rate_' + positionCount + '" name="expenses_json[' + positionCount + '][exchange_rate]" class="form-control" placeholder="TC" value="1.00">'+
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<a href="javascript:void(0);" onclick="deleteExpenseElement(' + positionCount + ');">'+
                            '<i class="fas fa-trash" style="padding-top: 1rem;"></i>'+
                            '</a>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '</div><br id="br_expense_element_' + positionCount + '"/>');
        // datepicker
        $('.datepicker').datepicker({
            language: 'es',
            format: 'dd/mm/yyyy',
            autoclose: true,
            disableTouchKeyboard: true,
        });
    }
}
function newExpenseElementTd(carId = 0) {
    var expensesJsonHtml = document.getElementById('expenses_json');
    if (expensesJsonHtml != null) {
        positionCount += 1;
        expensesJsonHtml.insertAdjacentHTML( 'beforeend',  '<tr id="expense_element_' + positionCount + '">'+
                '<td>'+
                    '<div id="expenses_json_' + positionCount + '_name">' +
                        '<input type="text" id="' + positionCount + '" name="expenses_json[' + positionCount + '][name]" onkeyup="autocompleteElements(this, 1, ' + carId + ');" class="form-control form-control-sm" placeholder="Nombre del gasto" value="">'+
                    '</div>'+
                '</td>'+
                '<td>'+
                    '<div id="expenses_json_' + positionCount + '_detail">' +
                        '<input type="text" id="' + positionCount + '" name="expenses_json[' + positionCount + '][detail]" class="form-control form-control-sm" onkeyup="autocompleteElements(this, 2, ' + carId + ');" placeholder="Detalle" value="">'+
                    '</div>'+
                '</td>'+
                '<td>'+
                    '<input type="text" name="expenses_json[' + positionCount + '][date]" class="form-control form-control-sm datepicker" placeholder="Fecha" value="">'+
                '</td>'+
                '<td>'+
                    '<select class="form-control form-control-sm" onChange="changeRate(' + positionCount + ', this);" name="expenses_json[' + positionCount + '][currency]">'+
                        '<option value="USD">USD</option>'+
                        '<option selected value="PEN">PEN</option>'+
                        '<option value="EUR">EUR</option>'+
                        '<option value="OTH">OTH</option>'+
                    '</select>'+
                '</td>'+
                '<td>'+
                    '<input type="number" onkeyup="callNewRow(event);" name="expenses_json[' + positionCount + '][value]" class="form-control form-control-sm" placeholder="Monto" value="">'+
                '</td>'+
                '<td>'+
                    '<input type="text" id="exchange_rate_' + positionCount + '" onkeyup="callNewRow(event);" name="expenses_json[' + positionCount + '][exchange_rate]" class="form-control form-control-sm" placeholder="TC" value="'+ exchangeRate +'">'+
                '</td>'+
                '<td>'+
                    '<a href="javascript:void(0);" onclick="deleteExpenseElement(' + positionCount + ');">'+
                    '<i class="fas fa-trash" style="padding-top: 1rem;"></i>'+
                    '</a>'+
                    '<br id="br_expense_element_' + positionCount + '"/>' +
                '</td>');
        // datepicker
        $('.datepicker').datepicker({
            language: 'es',
            format: 'dd/mm/yyyy',
            autoclose: true,
            disableTouchKeyboard: true,
        });
        var inputName = document.getElementById(positionCount);
        inputName.focus();
    }
}
function validateExpenseName(baseElement) {
    for (let index = 0; index < (positionCount+1); index++) {
        if (index != positionCount) {
            var element = document.getElementsByName('expenses_json[' + index + '][name]');
            if (element != null && element[0] != undefined) {
                if (element[0].value != "") {
                    if (element[0].value.includes(baseElement.value)) {
                        baseElement.classList.add("btn-danger");
                        baseElement.classList.remove("btn-success");
                    } else {
                        baseElement.classList.remove("btn-danger");
                        baseElement.classList.add("btn-success");
                    }
                }
            }            
        }
    }
}
function autocompleteElements(element, condition = 1, carId = 0) {
    // mainheader
    if (condition == 1) {
        var mainHeader = document.getElementById("expenses_json_" + element.id + "_name");   
    } else {
        var mainHeader = document.getElementById("expenses_json_" + element.id + "_detail");
    }
    if (mainHeader == null) { return false;}
    // input & inputId
    var inp = element;
    if (inp == null) { return false;}

    var currentFocus;
    var a, b, i, val = inp.value;
    closeAllLists();
    if (!val) { return false;}
    currentFocus = -1;
    a = document.createElement("DIV");
    a.setAttribute("class", "autocomplete-items");
    a.setAttribute("style", "position: absolute; width: 20%; z-index:9;");
    mainHeader.parentNode.appendChild(a);
    if (val.length > 0) {
        //LLAMADA AL SERVICIO
        if (condition == 1) {
            var url_ = "/api/expenses?tag=name&value=" + val.toUpperCase() + "&cars_id=" + carId;
        } else {
            var url_ = "/api/expenses?tag=detail&value=" + val.toUpperCase() + "&cars_id=" + carId;
        }
        $.ajax({
            url: url_,
            context: document.body,
            statusCode: {
                404: function() { 
                    b = document.createElement("DIV");
                    b.innerHTML += '<p style="font-size: 12px;">Nuevo registro: <b>' + val.toUpperCase() + '</b></p>';
                    a.appendChild(b);
                }
            }
        }).done(function(response) {
            for (i = 0; i < response.length; i++) {
                b = document.createElement("DIV");
                b.setAttribute('class', 'form-control-autocomplete');
                b.innerHTML += response[i].name;
                b.innerHTML += "<input type='hidden' value='" + JSON.stringify(response[i]) + "'>";
                b.addEventListener("click", function(e) {
                    // agregar value al input
                    var iterator = this.getElementsByTagName("input")[0].value;
                    iterator = JSON.parse(iterator);
                    inp.value = iterator.name;
                    inp.innerHTML = iterator.name;
                    // agregar value al input_id
                    if (inpId != null) {
                        inpId.value = iterator.id;
                    }
                    closeAllLists();
                });
                a.appendChild(b);
            }
        });
    }
    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    document.addEventListener("click", function (e) {closeAllLists(e.target);});
}
function callNewRow(event) {
    if (event.which == 13) {
        newExpenseElementTd();
    }
}
function callThis(element) {
    console.log(element);
}
function changeRate(positionCount, element) {
    var changeRateElement = document.getElementById('exchange_rate_' + positionCount);
    if (changeRateElement != null) {
        switch (element.value) {
            case 'USD':
                changeRateElement.value = 1.00;
                break;
            case 'PEN':
                changeRateElement.value = exchangeRate;
                break;
            default:
                changeRateElement.value = 1.00;
                break;
        }
    }
}

function deleteExpenseElement(position) {
    var expenseElementHtml = document.getElementById('expense_element_' + position);
    if (expenseElementHtml != null) {
        expenseElementHtml.remove();	
    }
    var brExpenseElementHtml = document.getElementById('br_expense_element_' + position);
    if (brExpenseElementHtml != null) {
        brExpenseElementHtml.remove();	
    }
}
function deleteCarImage(inpId) {
    var inpImage = document.getElementById('image_' + inpId);
    if (inpImage != null) {
        inpImage.setAttribute('src', '/argon/img/not_found.png');
        var inpValue = document.getElementById(inpId);
        if (inpValue != null) {
            inpValue.setAttribute('value', null);
            inpValue.insertAdjacentHTML('beforeend', '<input type"hidden" name="hidden_' + inpId + '" value="">');
        }
    }
}
function calculateExpenses() {
    var totalExpenses = document.getElementById('total_expenses');
    if (totalExpenses != null) {
        // calcular gastos
        var expensesAmount = 0;
        for (let index = 0; index < (positionCount+1); index++) {
            var element = document.getElementsByName('expenses_json[' + index + '][value]');
            var elementER = document.getElementsByName('expenses_json[' + index + '][exchange_rate]');
            if (element != null && element[0] != undefined) {
                if (element[0].value != "") {
                    var exchange_rate = 1;
                    if (elementER != null && elementER[0] != undefined && elementER[0].value != "") {
                        exchange_rate = parseFloat(element[0].exchange_rate);
                    }
                    expensesAmount = expensesAmount + parseFloat(element[0].value/exchange_rate);	
                }
            }
        }
        // calcular gasto vehicular
        // if (total_expenses != null) {
        //     var dateDiff = document.getElementById('date_diff');
        //     var costPerDay = document.getElementById('input-cost_per_day');
        //     var totalExpensesAmount = parseFloat(costPerDay.value)*parseInt(dateDiff.value) 
        //         + expensesAmount;
        //     totalExpenses.innerHTML = totalExpensesAmount;
        // }
        document.getElementById('expenses_amount').innerHTML = expensesAmount.toFixed(2);
    } else {
        // calcular costo diario
        var expensesAmount = 0;
        for (let index = 0; index < (positionCount+1); index++) {
            var element = document.getElementsByName('expenses_json[' + index + '][value]');
            var elementER = document.getElementsByName('expenses_json[' + index + '][exchange_rate]');
            if (element != null && element[0] != undefined) {
                if (element[0].value != "") {
                    var exchange_rate = 1;
                    if (elementER != null && elementER[0] != undefined && elementER[0].value != "") {
                        exchange_rate = parseFloat(elementER[0].value);
                    }
                    expensesAmount = expensesAmount + parseFloat(element[0].value/exchange_rate);	
                }
            }
        }
        document.getElementById('expenses_amount').innerHTML = expensesAmount.toFixed(2);
    }
    $('#expensesModal').modal();
}
function newElement() {
    var expensesJsonHtml = document.getElementById('files_json');
    if (expensesJsonHtml != null) {
        positionCount += 1;
        expensesJsonHtml.insertAdjacentHTML( 'beforeend',  '<div class="row" id="element_' + positionCount + '">'+
                '<div class="col-md-5">'+
                    '<input type="text" id="aF_'+ positionCount +'" name="files_json[' + positionCount + '][name]" class="form-control" placeholder="Nombre del documento" value="">'+
                '</div>'+
                '<div class="col-md-5">'+
                    '<input type="file" name="files_json[' + positionCount + '][value]" class="form-control" placeholder="Seleccione un documento" value="">'+
                '</div>'+
                '<div class="col-md-2">'+
                    '<a href="javascript:void(0);" onclick="deleteElement(' + positionCount + ');">'+
                    '<i class="fas fa-trash" style="padding-top: 1rem;"></i>'+
                    '</a>'+
                '</div>'+
            '</div><br id="br_element_' + positionCount + '"/>');
        var inp = document.getElementById('aF_' + positionCount);
        if (inp != null) {
            inp.focus();
        }
    }
}
function deleteElement(position) {
    var elementHtml = document.getElementById('element_' + position);
    if (elementHtml != null) {
        elementHtml.remove();	
    }
    var brElementHtml = document.getElementById('br_element_' + position);
    if (brElementHtml != null) {
        brElementHtml.remove();	
    }
}
function isEmpty(val){
    return (val === undefined || val == null || val.length <= 0) ? true : false;
}