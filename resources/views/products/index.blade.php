@extends('layouts.app', ['class' => 'bg-dark'])

@push('css')
    <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/myCss.css" rel="stylesheet">
    <style>
        @media screen {
            #printSection {
                display: none;
            }
        }

        @media print {
            body * {
                visibility:hidden;
            }
            #printSection, #printSection * {
                visibility:visible;
            }
            #printSection {
                position:absolute;
                left:0;
                top:0;
            }
        }
    </style>
@endpush

@section('view_title_name')
Módulo de productos
@endsection

@section('nav-products')
active
@endsection

@section('content')

@include('layouts.headers.empty')

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    @php 
                        $message = Session::get('message') ? Session::get('message') : null;
                        $messageClass = Session::get('messageClass')? Session::get('messageClass') : null;
                        $carSelected = Session::get('carSelected')? Session::get('carSelected') : 0;
                    @endphp
                    @if (isset($message) && isset($messageClass))
                        <div class="alert alert-{{ $messageClass }} alert-dismissible fade show" role="alert">
                            <strong>Notificación:</strong> {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0">Resumen de productos</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('products.create') }}" class="btn btn btn-default">Nuevo producto</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="myTable align-items-center table-bordered table-hover table-sm" id="carListDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="thTaxationLeft">Código</th>
                                    <th scope="col" class="thTaxationMiddle">Categoría</th>
                                    <th scope="col" class="thTaxationMiddle">Marca</th>
                                    <th scope="col" class="thTaxationMiddle">Nombre</th>
                                    <th scope="col" class="thTaxationMiddle">Descripción</th>
                                    <th scope="col" class="thTaxationMiddle">P.Costo</th>
                                    <th scope="col" class="thTaxationMiddle">P.Venta</th>
                                    <th scope="col" class="thTaxationMiddle">Estado</th>
                                    <th scope="col" class="thTaxationRight"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
            <br>
        </div>
    </div>
</div>

<!-- modals -->
@include('layouts.modals.default')

@endsection

@push('js')
<script src="{{ asset('argon') }}/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('argon') }}/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('argon') }}/js/bootstrap-datepicker.ES.js" charset="UTF-8"></script>
<script src="{{ asset('argon') }}/js/default.js"></script>
<script>
    var table = $('#carListDataTable').DataTable({
        "info": true,
        "scrollX": false,
        "ordering": true,
        "searching": true,
        "processing": true,
        "serverSide": true,
        "lengthChange": false,
        "bPaginate": true,
        "responsive": false,
        "language": {
            "url": "{{ asset('argon') }}/js/datatables.ES.json"
        },
        "order": [[ 0, "desc" ]],
        "ajax": function(data, callback, settings) {
            $.get('/api/products', {
                limit: data.length,
                offset: data.start,
                order: data.order,
                search: data.search
            }, function(res) {
                arrayProducts = [];
                res.data.forEach(element => {
                    arrayProducts[element.id] = element;
                });
                callback({
                    recordsTotal: res.total,
                    recordsFiltered: res.total,
                    data: res.data
                });
            });
        },
        "columns" : [
                {'data':   function (data) {
                    return data.code;
                }},
                {'data':   function (data) {
                    return data.category;
                }},
                {'data':   function (data) {
                    return data.brand;
                }},
                {'data':   function (data) {
                    return data.name;
                }},
                {'data':   function (data) {
                    return data.description;
                }},
                {'data':   function (data) {
                    return data.price_compra;
                }},
                {'data':   function (data) {
                    return data.price_sale;
                }},
                {'data':   function (data) {
                    var message = "ACTIVO";
                    if (data.flag_active != 1) {
                    message = "INACTIVO";
                    }
                    return message;
                }},
                {'data':   function (data) {
                    return '<div class="dropdown">' +
                            '<a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                '<i class="fas fa-ellipsis-v"></i>' +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">' +
                                '<a class="dropdown-item" href="/products/' + data.id + '/edit">Información general</a>' +
                                '<a class="dropdown-item" href="#">Ver movimientos</a>' +
                                '<a class="dropdown-item" href="#" onclick="deleteProduct(' + data.id + ');">Eliminar producto</a>' +
                            '</div>' +
                        '</div>';
                }, "orderable": false},
            ],
        });

    function deleteProduct(productId) {
        var confirm = false;
        var confirm = window.confirm("¿Está seguro de eliminar el producto?");
        if (confirm) {
            $.ajax('/api/products/destroy/' + productId, {
                type: 'DELETE',  // http method
                data: {},  // data to submit
                success: function (data, status, xhr) {
                    alert("Producto eliminado correctamente.");
                    table.ajax.reload();
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    alert("Hubo un error al eliminar el producto.");
                }
            });
        }
    }

    function showExpensesDetail(car) {
        var carExpensesAhref = document.getElementById("carExpensesAhref");
        if (carExpensesAhref != null) {
            carExpensesAhref.innerHTML = " Agregar gastos";
            carExpensesAhref.href = "/cars/" + car.id + "/edit-expenses";
        }
        var utilityAmount = 0;
        document.getElementById("em_carName").innerHTML = car.brand + ' ' + car.model + ' (' + car.number + ')';
        document.getElementById("em_carRegisterDate").innerHTML = car.register_date;
        if (car.sale != null) {
            document.getElementById("em_purchaseDate").innerHTML = car.sale.purchase_date;
            document.getElementById("em_saleDate").innerHTML = car.sale.sale_date;            
        }
        document.getElementById("expenses_pc").innerHTML = parseFloat(car.price_compra  + 0).toFixed(0);
        document.getElementById("expenses_pv").innerHTML = parseFloat(car.price_sale  + 0).toFixed(0);
        var totalCost = parseFloat(parseFloat(car.price_compra) + parseFloat(car.totalExpensesAmount)).toFixed(0);
        document.getElementById("expenses_pcost").innerHTML = totalCost;
        document.getElementById("expenses_gd").innerHTML = parseFloat(car.costPerDay).toFixed(0);
        document.getElementById("expenses_days").innerHTML = car.dateDiff + ' días';
        document.getElementById("expenses_days_x_gd").innerHTML = parseFloat(car.dateDiff*car.costPerDay).toFixed(0)
        document.getElementById("expenses_amount").innerHTML = parseFloat(car.expensesAmount).toFixed(0);
        utilityAmount = (car.price_sale - totalCost);
        document.getElementById("total_expenses").innerHTML = parseFloat(car.totalExpensesAmount).toFixed(0) + ' ' + car.currency;
        document.getElementById("total_utility").innerHTML = parseFloat(utilityAmount).toFixed(0) + ' ' + car.currency;
        
        var tbodyExpensesDetail = document.getElementById('tbodyExpensesDetail');
        if (tbodyExpensesDetail != null) {
            tbodyExpensesDetail.innerHTML = "";
            if (car.expenses != null) {
                var stringHtml = '';
                var obj = car.expenses.expenses_json;
                if (obj != null) {
                    Object.keys(obj).forEach(key => {
                        stringHtml += '<tr><td>'+ ((obj[key].name) ? obj[key].name : '--') +'</td>' +
                                    '<td>'+ ((obj[key].detail) ? obj[key].detail : '--') +'</td>' +
                                    '<td>'+ ((obj[key].date) ? obj[key].date : '--') +'</td>' +
                                    '<td>'+ ((obj[key].value) ? obj[key].value : '--') +' '+ obj[key].currency +'</td>' +
                                    '<td>'+ (parseFloat((obj[key].exchange_rate) ? obj[key].exchange_rate : 1)).toFixed(0) +'</td>' +
                                    '<td>'+ (parseFloat(obj[key].value)/parseFloat((obj[key].exchange_rate) ? obj[key].exchange_rate : 1)).toFixed(0) + ' USD</td></tr>';
                    });
                    tbodyExpensesDetail.insertAdjacentHTML('beforeend', stringHtml);   
                }
            }    
        }    
        $('#expensesModal').modal();
    }
    function openWebStatusModal(car) {
        if (parseInt(car.for_sale) === 0) {
            document.getElementById('idPublishCarModalB').innerHTML = car.brand + " " + car.model + " " + car.number;
            document.getElementById("publishCarModalForm").action = "/cars/" + car.id;
            $('#publishCarModal').modal();
        } else {
            document.getElementById('idUnpublishCarModalB').innerHTML = car.brand + " " + car.model + " " + car.number;
            document.getElementById("unpublishCarModalForm").action = "/cars/" + car.id;
            $('#unpublishCarModal').modal();
        }
    }
    function productStatus() {
        var status = document.getElementById('product_status');
        if (status != null) {
            window.location.replace('/products?status=' + status.value);
        }
    }

    document.getElementById("btnPrintModalExpenses").onclick = function () {
        printElement(document.getElementById("printThisExpenses"));
    }

    function printElement(elem) {
        var domClone = elem.cloneNode(true);
        
        var $printSection = document.getElementById("printSection");
        
        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }
        
        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        window.print();
    }

</script>
@endpush