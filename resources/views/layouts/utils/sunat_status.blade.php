@php
    $sunatStatus = "SIN EMITIR";
    if (is_null($sale->fe_request_nulled)) {
        if (!is_null($sale->fe_response)) {
            if ($sale->type_document === "03") {
                $sunatStatus = $sale->fe_response['respuesta'];
            } else {
                $sunatStatus = "ok";
            }
        }
    } else {
        $sunatStatus = "Anulado";
    }
    $sale->sunatStatus = $sunatStatus;
@endphp