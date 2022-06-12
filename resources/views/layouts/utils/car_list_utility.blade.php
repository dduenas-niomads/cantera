@php
    # cost per day
    $registerDate = DateTime::createFromFormat('d/m/Y', $value->register_date);
    if (!$registerDate) {
        $dateDiff = 0;
    } else {
        if (!is_null($value->sale) && !is_null($value->sale->sale_date)) {
            // dd($value->sale->sale_date);
            $todayDate = DateTime::createFromFormat('d/m/Y', $value->sale->sale_date);
            $interval = date_diff($registerDate, $todayDate);
            $dateDiff = $interval->format('%a');
        } else {
            $todayDate = date_create('now');
            $interval = date_diff($registerDate, $todayDate);
            $dateDiff = $interval->format('%a');
        }
    }
    # expenses
    $totalExpenses = 0;
    $totalIgv = 0;
    $totalRent = 0;
    if (isset($value->expenses->expenses_json)) {
        foreach ($value->expenses->expenses_json as $kv => $vv)
        {
            $exchange_rate = 1;
            if (isset($vv['exchange_rate']))
            {
                $exchange_rate = $vv['exchange_rate'];
            }
            try {
                $totalExpenses = $totalExpenses + ($vv['value']/$exchange_rate);
            } catch (\Throwable $th) {
                $floatVal = floatval($vv['value']);
                if (!is_numeric($exchange_rate)) {
                    $exchange_rate = 1;
                }
                $totalExpenses = $totalExpenses + ($floatVal/$exchange_rate);
            }
            // igv
            if ((isset($vv['tag']) && $vv['tag'] === "IGV") || $vv["name"] === "IGV") {
                $totalIgv = $vv['value'];
            }
            // rent
            if ((isset($vv['tag']) && $vv['tag'] === "RENT") || $vv["name"] === "RENTA 1.5%") {
                $totalRent = $vv['value'];
            }
        }
    }
    $value->totalUtility = 0;
    $value->commission = 0;
    $value->dateDiff = $dateDiff;
    $value->costPerDay = $costPerDay;
    $value->expensesAmount = $totalExpenses;
    $totalExpensesAmount = ($costPerDay*$dateDiff) + $totalExpenses;
    $value->totalExpensesAmount = round($totalExpensesAmount);
    $value->totalUtility = ($value->price_sale ? $value->price_sale : 0) - ($value->price_compra ? $value->price_compra : 0) - $value->totalExpensesAmount;
    // $value->commission = $value->totalUtility*0.1;
    // $value->totalUtility = $value->totalUtility*0.9;
    $value->totalIgv = $totalIgv;
    $value->totalRent = $totalRent;
    $value->type_sign_name = "Ley 30536";
    if (isset($value->type_sign)) {
        switch ((int)$value->type_sign) {
            case 1: 
                $value->type_sign_name = "Ley 30536";
            break;
            case 2: 
                $value->type_sign_name = "Empresa";
            break;
            case 3: 
                $value->type_sign_name = "Persona natural";
            break;
            default:
            break;
        }
    }
@endphp

@include('layouts.utils.car_status_utils')

@php
    $value->max_invoiced = 0;
    if (isset($value->invoiced)) {
        switch ($value->invoiced) {
            case ($value->invoiced <= 5000):
                $value->max_invoiced = $value->invoiced + 500;
            break;
            case ($value->invoiced > 5000 && $value->invoiced <= 25000):
                $value->max_invoiced = $value->invoiced + 1000;
            break;
            case ($value->invoiced > 25000):
                $value->max_invoiced = $value->invoiced + 2000;
            break;
            default:
            break;
        }
    }
@endphp