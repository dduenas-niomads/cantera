<?php

namespace App\Http\Controllers;

use App\Models\MsDocument;
use App\Models\Car;
use App\Models\CarEntryExpense;
use Illuminate\Http\Request;
use Excel;

class DocumentController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $document = Excel::toArray(null, public_path('documents/stock.xlsx'));
        $valueName = [];
        $list = [];
        foreach ($document[0] as $key => $value) {
            if ($key === 0) {
                $valueName = $value;
            } else {
                $actualValue = [];
                foreach ($value as $kv => $vv) {
                    if (!is_null($valueName[$kv]) && !is_null($vv)) {
                        $actualValue["moneda"] = MsDocument::DEFAULT_CURRENCY;
                        if ($valueName[$kv] !== "N°") {
                            $actualValue[$valueName[$kv]] = $vv;
                        }
                    }
                }
                if (count($actualValue)) {
                    MsDocument::create([
                        "access_json" => $actualValue,
                        "car_number" => isset($actualValue['PLACA']) ? $actualValue['PLACA'] : null
                    ]);
                }
            }
        }
        dd(json_encode($list));
    }

    public function storeExpenses(Request $request)
    {
        $documents = MsDocument::whereNull(MsDocument::TABLE_NAME . '.deleted_at')
            // ->where(MsDocument::TABLE_NAME . '.flag_active', MsDocument::STATE_ACTIVE)
            ->get();

        $carExpenses = [];

        foreach ($documents as $key => $value) {
            $car = Car::whereNull(Car::TABLE_NAME . '.deleted_at')
                ->where(Car::TABLE_NAME . '.number', $value->car_number)
                ->first();
            if (!is_null($car)) {
                $costo = isset($value->access_json["COSTO"]) ? $value->access_json["COSTO"] : 0;
                $compra = isset($value->access_json["COMPRA"]) ? $value->access_json["COMPRA"] : 0;
                $igv = isset($value->access_json["IGV"]) ? $value->access_json["IGV"] : 0;
                $igv_valor = isset($value->access_json["IGV_VALOR"]) ? $value->access_json["IGV_VALOR"] : 0;
                $renta = isset($value->access_json["RENTA"]) ? $value->access_json["RENTA"] : 0;
                $renta_valor = isset($value->access_json["RENTA_VALOR"]) ? $value->access_json["RENTA_VALOR"] : 0;
                $carExpenses = [
                    "cars_id" => $car->id,
                    "expenses_json" => [
                        "1" => [
                            "name" => "GASTO PROMEDIO",
                            "detail" => "COSTO: " . (string)$costo . " - COMPRA: " . (string)$compra,
                            "date" => date("d/m/Y"),
                            "value" => (float)$costo - (float)$compra,
                            "currency" => $value->access_json["moneda"]
                        ],
                        "2" => [
                            "name" => "IGV",
                            "detail" => "IGV SOBRE: " . (string)$igv,
                            "date" => date("d/m/Y"),
                            "value" => (float)$igv_valor,
                            "currency" => $value->access_json["moneda"]
                        ],
                        "3" => [
                            "name" => "RENTA",
                            "detail" => "RENTA SOBRE: " . (string)$renta,
                            "date" => date("d/m/Y"),
                            "value" => (float)$renta_valor,
                            "currency" => $value->access_json["moneda"]
                        ],
                    ],
                    "currency" => MsDocument::DEFAULT_CURRENCY,
                ];
                // grabar gastos
                $carEntryExpense = CarEntryExpense::create($carExpenses);
                if (!is_null($carEntryExpense)) {
                    $value->flag_active = MsDocument::STATE_INACTIVE;
                    $value->save();
                }
            }
        }
    }
}
