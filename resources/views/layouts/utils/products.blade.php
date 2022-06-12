@php
    # estado del producto
    $value->status_name = "ACTIVO";
    $value->tr_class_name = "table-secondary";
    switch ((int)$value->flag_active) {
        case 0: 
            $value->status_name = "INACTIVO";
            $value->tr_class_name = "table-warning";
            break;
        case 1: 
            $value->status_name = "ACTIVO";
            $value->tr_class_name = "table-secondary";
            break;
        case 2: 
            $value->status_name = "ELIMINADO";
            $value->tr_class_name = "table-danger";
            break;
        default:
            $value->status_name = "OTRO";
            $value->tr_class_name = "table-primary";
            break;
    }
    # tipo de producto
    $value->type_product_name = "PRODUCTO";
    switch ((int)$value->type_product) {
        case 1: 
            $value->type_product_name = "PRODUCTO";
            break;
        case 2: 
            $value->type_product_name = "SERVICIO";
            break;
        default:
            $value->type_product_name = "OTRO";
            break;
    }
@endphp