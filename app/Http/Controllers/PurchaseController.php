<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarEntryDetail;
use App\Models\CarEntryExpense;
use App\Models\Client;
use App\Models\Purchase;
use App\Models\Taxation;
use App\Models\MsCostPerDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the purchases
     *
     * @param  \App\Models\Purchase  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $purchaseList = Purchase::join(Car::TABLE_NAME, Car::TABLE_NAME . '.id', '=', 
                Purchase::TABLE_NAME . '.cars_id')
            ->select(Purchase::TABLE_NAME . '.*', Car::TABLE_NAME . '.flag_active as car_flag_active')
            ->whereNull(Purchase::TABLE_NAME . '.deleted_at')
            ->where(Purchase::TABLE_NAME . '.flag_active', Purchase::STATE_ACTIVE)
            ->where(Car::TABLE_NAME . '.flag_active', '!=', Car::STATE_DELETED)
            ->get();
        $costPerDay = 0;
        return view(Purchase::MODULE_NAME . '.index', compact('purchaseList'));
    }

    public function create(Request $request)
    {
        $params = $request->all();
        $car = null;
        $taxation = null;
        $holder = null;
        $owner = null;
        $message = "Si desea, puede crear una compra a partir de una tasación.";
        $messageClass = "default";
        $validation = 0;
        if (isset($params['taxation_code'])) {
            $taxationCode = $params['taxation_code'];
            $taxation = Taxation::whereNull(Taxation::TABLE_NAME . '.deleted_at')
                ->where(Taxation::TABLE_NAME . '.status', Taxation::STATE_PENDING)
                ->where(function($query) use ($taxationCode){
                    $query->where(Taxation::TABLE_NAME . '.car_number', $taxationCode);
                    $query->orWhere(Taxation::TABLE_NAME . '.id', (int)$taxationCode);
                })->first();
            if (!is_null($taxation)) {
                $car = Car::with('details:id,cars_id,kilometers')
                    ->find($taxation->cars_id);
                if (!is_null($car)) {
                    if (is_null($car->n_tasacion)) {
                        $car->n_tasacion = str_pad($taxation->id, 6, '0', STR_PAD_LEFT);
                        $car->save();
                    }
                    // holder & owner
                    $holder = Client::find($car->holder_id);
                    $owner = Client::find($car->owner_id);
                }
                $message = "La tasación fue encontrada.";
                $messageClass = "success";
            } else {
                $message = "No se encontró la tasación.";
                $messageClass = "danger";
            }
        }
        if (isset($params['car_code'])) {
            $carCode = $params['car_code'];
            $car = Car::whereNull(Car::TABLE_NAME . '.deleted_at')
                ->where(function($query) use ($carCode){
                    $query->where(Car::TABLE_NAME . '.number', $carCode);;
                })->orderBy(Car::TABLE_NAME . '.id', 'DESC')->first();
            if (!is_null($car)) {
                switch ((int)$car->flag_active) {
                    case 1:
                        $car = null;
                        $message = "El vehículo está disponible en el sistema. Para hacer una nueva compra primero debe venderlo o darle de baja.";
                        $messageClass = "warning";
                        break;
                    case 2:
                        if (is_null($car->n_tasacion)) {
                            $car->n_tasacion = str_pad(0, 6, '0', STR_PAD_LEFT);
                            $car->save();
                        }
                        // holder & owner
                        $holder = Client::find($car->holder_id);
                        $owner = Client::find($car->owner_id);
                        $message = "El vehículo fue encontrado como vendido. Al hacer una compra creará un nuevo registro del vehículo.";
                        $messageClass = "success";
                        $validation = 1;
                        break;
                    case 3:
                        if (is_null($car->n_tasacion)) {
                            $car->n_tasacion = str_pad(0, 6, '0', STR_PAD_LEFT);
                            $car->save();
                        }
                        // holder & owner
                        $holder = Client::find($car->holder_id);
                        $owner = Client::find($car->owner_id);
                        $message = "El vehículo se encuentra eliminado. Con esta compra creará un vehículo nuevo con la misma información.";
                        $messageClass = "success";
                        $validation = 1;
                        break;
                    default:
                        $car = null;
                        $message = "No se encontró el vehículo en los registros. Con esta compra creará el vehículo por primera vez.";
                        $messageClass = "success";
                        $validation = 1;
                        break;
                }
            } else {
                $message = "No se encontró el vehículo en los registros. Con esta compra creará el vehículo por primera vez.";
                $messageClass = "success";
                $validation = 1;
            }
        }
        $view = Purchase::MODULE_NAME . '.create';
        if (isset($params['view'])) {
            $view = $params['view'];
        }
        return view($view, compact('car', 'taxation', 'holder', 'owner', 'message', 'messageClass', 'validation'));
    }

    public function edit($id)
    {
        $purchase = Purchase::find($id);
        if (!is_null($purchase)) {
            $car = Car::with('expenses')->find($purchase->cars_id);
            if (!is_null($car)) {
                $car->igv_amount = 0;
                $car->rent_amount = 0;
                if (!is_null($car->expenses)) {
                    if (!is_null($car->expenses->expenses_json)) {
                        foreach ($car->expenses->expenses_json as $keyEJ => $valueEJ) {
                            if (isset($valueEJ['tag'])) {
                                if ($valueEJ['tag'] === "IGV") {
                                    $car->igv_amount = (float)$valueEJ['value'];
                                }
                                if ($valueEJ['tag'] === "RENT") {
                                    $car->rent_amount = (float)$valueEJ['value'];
                                }
                            } elseif (isset($valueEJ['name'])) {
                                if ($valueEJ['name'] === "IGV") {
                                    $car->igv_amount = (float)$valueEJ['value'];
                                }
                                if ($valueEJ['name'] === "RENTA") {
                                    $car->rent_amount = (float)$valueEJ['value'];
                                }
                            }
                        }
                    }
                }
                $car->igv_base = round($car->igv_amount + ($car->igv_amount/0.18));
                $car->rent_base = round(($car->rent_amount/0.015));
                return view(Purchase::MODULE_NAME . '.edit', compact('purchase', 'car'));
            } else {
                $message = "La compra no fue encontrado.";
                $messageClass = "danger";
                return redirect()->route(Purchase::MODULE_NAME . '.index')
                    ->with( ['message' => $message, 'messageClass' => $messageClass ] );
            }
        } else {
            $message = "La compra no fue encontrado.";
            $messageClass = "danger";
            return redirect()->route(Purchase::MODULE_NAME . '.index')
                ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        }
    }

    public function purchaseAdjust(Request $request)
    {
        // query
        $cars = Car::whereNull(Car::TABLE_NAME . '.deleted_at')
            ->with('actualPurchase')
            ->get();
        // selected cars without purchases
        $carsWithoutPurchase = [];
        foreach ($cars as $key => $value) {
            if (is_null($value->actualPurchase)) {
                array_push($carsWithoutPurchase, $value);
            }
        }
        // create purchases
        $counter = 0;
        $counterFailed = 0;
        foreach ($carsWithoutPurchase as $key => $value) {
            $value->cars_id = $value->id;
            unset($value->id);
            unset($value->created_at);
            unset($value->updated_at);
            if (Purchase::create($value->toArray())) {
                $counter++;
            } else {
                $counterFailed++;
            }
        }
        return [$counterFailed, $counter];
    }

    public function store(Request $request)
    {
        $params = $request->all();
        // compra
        if (isset($params['purchase'])) {
            $purchaseParams = $params['purchase'];
            // crear vehiculo
            $car = Car::create($purchaseParams);
            if (!is_null($car)) {
                $purchaseParams['cars_id'] = $car->id;
                // actualizar tasación
                if (isset($purchaseParams['n_tasacion']) && !is_null($purchaseParams['n_tasacion'])) {
                    $taxation = Taxation::find((int)$purchaseParams['n_tasacion']);
                    if (!is_null($taxation) && (int)$taxation->status === Taxation::STATE_PENDING) {
                        $taxation->status = Taxation::STATE_PURCHASED;
                        $taxation->save();
                        $purchaseParams['taxations_id'] = $taxation->id;
                    }
                }
                // crear compra
                $purchaseParams['created_by'] = Auth::user()->id;
                $purchase = Purchase::create($purchaseParams);
            }
        }
        if (!is_null($purchase)) {
            // clients
            $holder = null;
            $owner = null;
            if (isset($params['clients'])) {
                if (isset($params['clients']['holder'])) {
                    $holderParams = $params['clients']['holder'];
                    if (isset($holderParams['id']) && (int)$holderParams['id'] !== 0) {
                        $holder = Client::find($holderParams['id']);
                        if (!is_null($holder)) {
                            unset($holderParams['id']);
                            $holderParams['name'] = ClientController::callPrivateFunction("generateNameValue", $holderParams);
                            $holderParams['tag'] = 'holder';
                            $holder->fill($holderParams);
                            $holder->save();
                        }
                    } else {
                        if (!is_null($holderParams['document_number'])) {
                            unset($holderParams['id']);
                            $holderParams['name'] = ClientController::callPrivateFunction("generateNameValue", $holderParams);
                            $holder = Client::create($holderParams);
                        }
                    }
                    if (!is_null($holder)) {
                        $purchase->holder_id = $holder->id;
                        $purchase->save();
                    }
                }

                if (!isset($params['clients']['owner'])) {
                    $params['clients']['owner'] = $params['clients']['holder'];
                } elseif ((int)$params['clients']['owner']['id'] === 0 &&
                    is_null($params['clients']['owner']['document_number'])) {
                    $params['clients']['owner'] = $params['clients']['holder'];
                    if (!is_null($car) && !is_null($purchase)) {
                        // car
                        $car->owner = $params['purchase']['holder'];
                        $car->owner_id = $params['clients']['holder']['id'];
                        $car->save();
                        // purchase
                        $purchase->owner = $params['purchase']['holder'];
                        $purchase->owner_id = $params['clients']['holder']['id'];
                        $purchase->save();
                    }
                }

                if (isset($params['clients']['owner'])) {
                    $ownerParams = $params['clients']['owner'];
                    if (isset($ownerParams['id']) && (int)$ownerParams['id'] !== 0) {
                        $owner = Client::find($ownerParams['id']);
                        if (!is_null($owner)) {
                            unset($ownerParams['id']);
                            $ownerParams['name'] = ClientController::callPrivateFunction("generateNameValue", $ownerParams);
                            $owner->fill($ownerParams);
                            $owner->save();
                        }
                    } else {
                        if (!is_null($ownerParams['document_number'])) {
                            unset($ownerParams['id']);
                            $ownerParams['name'] = ClientController::callPrivateFunction("generateNameValue", $ownerParams);
                            $owner = Client::create($ownerParams);
                        }
                    }
                    if (!is_null($owner)) {
                        $purchase->owner_id = $owner->id;
                        $purchase->save();
                    }
                }
            }
            // detalles
            if (isset($params['details'])) {
                $carEntryDetail = CarEntryDetail::whereNull(CarEntryDetail::TABLE_NAME . '.deleted_at')
                    ->where(CarEntryDetail::TABLE_NAME . '.cars_id', $purchase->cars_id)
                    ->first();
                if (!is_null($carEntryDetail)) {
                    $detailsParams = $params['details'];
                    $detailsParams['cars_id'] = $purchase->cars_id;
                    $detailsParams['updated_by'] = Auth::user()->id;
                    $carEntryDetail->fill($detailsParams);
                    $carEntryDetail->save();
                } else {
                    $detailsParams = $params['details'];
                    $detailsParams['cars_id'] = $purchase->cars_id;
                    $detailsParams['created_by'] = Auth::user()->id;
                    CarEntryDetail::create($detailsParams);
                }
            }
            // sustento
            if (isset($params['files_json'])) {
                $filesParams = $params['files_json'];
                $documents = [];
                foreach ($filesParams as $key => $value) {
                    if (isset($value['value'])) {
                        $fileName = time() . '.' . $value['value']->extension();
                        $value['value']->move(public_path('purchase_documents/' . $purchase->id . '/'), $fileName);
                        $documents['name'] = $value['name'];
                        $documents['value'] = 'purchase_documents/' . $purchase->id . '/' . $fileName;
                    }
                }
                $purchase->documents_json = $documents;
                $purchase->save();
            }
            // expenses
            if (isset($params['expenses'])) {
                $carEntryExpense = new CarEntryExpense();
                $carEntryExpense->cars_id = $purchase->cars_id;
                $carEntryExpense->expenses_json = [
                    [
                        "name" => "IGV",
                        "detail" => null,
                        "date" => date("d/m/Y"),
                        "currency" => "USD",
                        "value" => ($params['expenses']['igv']) ? $params['expenses']['igv'] : 0,
                        "exchange_rate" => 1,
                        "tag" => "IGV"
                    ],
                    [
                        "name" => "RENTA 1.5%",
                        "detail" => null,
                        "date" => date("d/m/Y"),
                        "currency" => "USD",
                        "value" => ($params['expenses']['rent']) ? $params['expenses']['rent'] : 0,
                        "exchange_rate" => 1,
                        "tag" => "RENT"
                    ],
                    [
                        "name" => "COMISIÓN PERSONAL DE LIMPIEZA",
                        "detail" => null,
                        "date" => date("d/m/Y"),
                        "currency" => "USD",
                        "value" => 20,
                        "exchange_rate" => 1,
                        "tag" => "CLEANING_STAFF"
                    ]
                ];
                $carEntryExpense->save();
            }
            // MASTER INFO
            // self::updateMasterInfo($purchase);
            // otros maestros
            if (!is_null($purchase->notary_id)) {
                $car->notary_id = $purchase->notary_id;
                $car->save();
            }
        } else {
            $message = "La compra no se pudo registar.";
            $messageClass = "danger";
        }
        $message = "La compra se registró correctamente.";
        $messageClass = "success";
        return redirect()->route(Purchase::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function update($id, Request $request)
    {
        $params = $request->all();
        $purchase = Purchase::find($id);
        if (!is_null($purchase)) {
            $params['updated_by'] = Auth::user()->id;
            $purchase->fill($params['purchase']);
            $purchase->save();
            // MASTER INFO
            self::updateMasterInfo($purchase);
            // cars
            $car = Car::find($purchase->cars_id);
            if (!is_null($car)) {
                // expenses
                $this->updateExpenses($car, $purchase, $params);
                $message = "La compra se actualizó correctamente.";
                $messageClass = "success";
            } else {
                $message = "No se puede editar la compra. Error al vincular el vehículo.";
                $messageClass = "danger";
            }
        } else {
            $message = "El vehículo no fue encontrado.";
            $messageClass = "danger";
        }
        return redirect()->route(Purchase::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function destroy($id, Request $request)
    {
        $purchase = Purchase::find($id);
        if (!is_null($purchase)) {
            $commentary = $request->input('commentary');
            $purchase->delete_commentary = $commentary; 
            $purchase->deleted_by = Auth::user()->id;
            $purchase->flag_active = Purchase::STATE_INACTIVE;
            $purchase->deleted_at = date("Y-m-d H:i:s");
            $purchase->save();
            $message = "El vehículo se eliminó correctamente.";
            $messageClass = "success";
        } else {
            $message = "El vehículo no fue encontrado.";
            $messageClass = "danger";
        }
        return redirect()->route(Purchase::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function show($id, Request $request)
    {
        return "show method";
    }

    private static function updateMasterInfo($purchase) : void
    {
        // MASTERS
        MsMasterController::findAndStore($purchase->brand, 'brand', null, null, $purchase, 'brand_id');
        MsMasterController::findAndStore($purchase->model, 'model', $purchase->brand, 'brand', $purchase, 'model_id');
        MsMasterController::findAndStore($purchase->color, 'color', null, null, $purchase, 'color_id');
        MsMasterController::findAndStore($purchase->notary, 'notary', null, null, $purchase, 'notary_id');
        // CLIENTS
        // ClientController::findAndStore($purchase->holder, 'holder', $purchase, 'holder_id');
        // ClientController::findAndStore($purchase->owner, 'owner', $purchase, 'owner_id');
    }

    private function updateExpenses($car, $purchase, $params)
    {
        // ACTUALIZAR GASTOS
        $car->fill($params['purchase']);
        $car->save();
        $expenses = CarEntryExpense::whereNull(CarEntryExpense::TABLE_NAME . '.deleted_at')
            ->where(CarEntryExpense::TABLE_NAME . '.flag_active', CarEntryExpense::STATE_ACTIVE)
            ->where(CarEntryExpense::TABLE_NAME . '.cars_id', $car->id)
            ->first();
        if (!is_null($expenses) && !is_null($expenses->expenses_json)) {
            $newExpenses = [];
            foreach ($expenses->expenses_json as $keyEJ => $valueEJ) {
                if (isset($valueEJ['tag'])) {
                    if ($valueEJ['tag'] === "IGV") {
                        $valueEJ['value'] = (float)$params['expenses']['igv'];
                        $valueEJ['detail'] = "IGV (editado en compra) SOBRE: " . ($params['expenses']['igv_detail']) ? $params['expenses']['igv_detail'] : "SIN DATO";
                    }
                    if ($valueEJ['tag'] === "RENT") {
                        $valueEJ['value'] = (float)$params['expenses']['rent'];
                        $valueEJ['detail'] = "RENTA (editado en compra) SOBRE: " . ($params['expenses']['rent_detail']) ? $params['expenses']['rent_detail'] : "SIN DATO";
                    }
                } elseif (isset($valueEJ['name'])) {
                    if ($valueEJ['name'] === "IGV") {
                        $valueEJ['value'] = (float)$params['expenses']['igv'];
                        $valueEJ['detail'] = "IGV (editado en compra) SOBRE: " . ($params['expenses']['igv_detail']) ? $params['expenses']['igv_detail'] : "SIN DATO";
                    }
                    if ($valueEJ['name'] === "RENTA 1.5%") {
                        $valueEJ['value'] = (float)$params['expenses']['rent'];
                        $valueEJ['detail'] = "RENTA (editado en compra) SOBRE: " . ($params['expenses']['rent_detail']) ? $params['expenses']['rent_detail'] : "SIN DATO";
                    }
                }
                array_push($newExpenses, $valueEJ);
                $expenses->expenses_json = $newExpenses;
                $expenses->save();
            } 
        } else {
            if (isset($params['expenses'])) {
                $carEntryExpense = new CarEntryExpense();
                $carEntryExpense->cars_id = $purchase->cars_id;
                $carEntryExpense->expenses_json = [
                    [
                        "name" => "IGV",
                        "detail" => "SOBRE " . ($params['expenses']['igv_detail']) ? $params['expenses']['igv_detail'] : "SIN DATO",
                        "date" => date("d/m/Y"),
                        "currency" => "USD",
                        "value" => ($params['expenses']['igv']) ? $params['expenses']['igv'] : 0,
                        "exchange_rate" => 1,
                        "tag" => "IGV"
                    ],
                    [
                        "name" => "RENTA 1.5%",
                        "detail" => "SOBRE " . ($params['expenses']['rent_detail']) ? $params['expenses']['rent_detail'] : "SIN DATO",
                        "date" => date("d/m/Y"),
                        "currency" => "USD",
                        "value" => ($params['expenses']['rent']) ? $params['expenses']['rent'] : 0,
                        "exchange_rate" => 1,
                        "tag" => "RENT"
                    ],
                    [
                        "name" => "COMISIÓN PERSONAL DE LIMPIEZA",
                        "detail" => null,
                        "date" => date("d/m/Y"),
                        "currency" => "USD",
                        "value" => 20,
                        "exchange_rate" => 1,
                        "tag" => "CLEANING_STAFF"
                    ]
                ];
                $carEntryExpense->save();
            }   
        }
    }
}
