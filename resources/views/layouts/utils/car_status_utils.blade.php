@php
    $value->status_name = "COMPRADO";
    $value->tr_class_name = "table-warning";
    if (isset($value->car_flag_active)) {
        $value->flag_active = $value->car_flag_active;
    }
    switch ((int)$value->flag_active) {
        case 0: 
            $value->status_name = "INCOMPLETO";
            $value->tr_class_name = "table-warning";
            break;
        case 1: 
            $value->status_name = "COMPRADO";
            $value->tr_class_name = "table-light";
            break;
        case 2: 
            $value->status_name = "VENDIDO";
            $value->tr_class_name = "table-success";
            break;
        case 3: 
            $value->status_name = "ELIMINADO";
            $value->tr_class_name = "table-danger";
            break;
        default:
            break;
    }
@endphp