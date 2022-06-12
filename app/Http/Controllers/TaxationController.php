<?php

namespace App\Http\Controllers;

use App\Models\Taxation;
use App\Models\Car;
use App\Models\CarEntryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxationController extends Controller
{
    /**
     * Display a listing of the Taxations
     *
     * @param  \App\Models\Taxation  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $status = "0";
        $taxationList = Taxation::join(Car::TABLE_NAME, Car::TABLE_NAME . '.id', '=',
                Taxation::TABLE_NAME . '.cars_id')
            ->select(Taxation::TABLE_NAME . '.*', 
                Car::TABLE_NAME . '.brand as car_brand', 
                Car::TABLE_NAME . '.model as car_model', 
                Car::TABLE_NAME . '.owner as car_owner',  
                Car::TABLE_NAME . '.holder as car_holder', 
                Car::TABLE_NAME . '.number as car_number', 
                Car::TABLE_NAME . '.color as car_color')
            ->whereNull(Taxation::TABLE_NAME . '.deleted_at');
            if (isset($params['status'])) {
                $status = (int)$params['status'];
                $taxationList = $taxationList->where(Taxation::TABLE_NAME . '.status', $status);
            }
            $taxationList = $taxationList->get();
        return view(Taxation::MODULE_NAME . '.index', compact('taxationList', 'status'));
    }

    public function create(Request $request)
    {
        $params = $request->all();
        $car = null;
        $message = "Si desea, puede crear una tasación a partir del código de un vehículo.";
        $messageClass = "default";
        if (isset($params['car_code'])) {
            $carCode = $params['car_code'];
            $car = Car::leftJoin(CarEntryDetail::TABLE_NAME, CarEntryDetail::TABLE_NAME . '.cars_id', '=',
                    Car::TABLE_NAME . '.id')
                ->select(Car::TABLE_NAME . '.*', CarEntryDetail::TABLE_NAME . '.kilometers')
                ->whereNull(Car::TABLE_NAME . '.deleted_at')
                ->where(Car::TABLE_NAME . '.flag_active', Car::STATE_ACTIVE)
                ->where(function($query) use ($carCode){
                    $query->where(Car::TABLE_NAME . '.number', $carCode);
                    $query->orWhere(Car::TABLE_NAME . '.id', (int)$carCode);
                })->first();
            if (!is_null($car)) {
                $message = "El vehículo fue encontrado.";
                $messageClass = "success";
            } else {
                $message = "El vehículo no fue encontrado.";
                $messageClass = "danger";
            }
        }
        return view(Taxation::MODULE_NAME . '.create_new', compact('car', 'message', 'messageClass'));
    }

    public function edit($id)
    {
        $taxation = Taxation::with('car')->find($id);
        if (!is_null($taxation)) {
            return view(Taxation::MODULE_NAME . '.edit', compact('taxation'));
        } else {
            $message = "La tazación vehicular no fue encontrado.";
            $messageClass = "danger";
            return redirect()->route(Taxation::MODULE_NAME . '.index')
                ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        }
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $params['created_by'] = Auth::user()->id;
        if (isset($params['cars_id'])) {
            if (is_null($params['cars_id'])) {
                $message = "La tazación vehicular no se pudo registrar.";
                $messageClass = "danger";
            } else {
                $car = self::createCar($params['cars_id'], $params);
                if (!is_null($car)) {
                    $params['cars_id'] = $car->id;
                    $params['car_number'] = $car->number;
                    $params['currency'] = $car->currency;
                }
                $taxation = Taxation::create($params);
                // MASTER INFO
                self::updateMasterInfo($taxation);
                $message = "La tazación vehicular se registró correctamente.";
                $messageClass = "success";
            }
        } else {
            if (isset($params['car_json'])) {
                $params['car_json']['flag_active'] = Car::STATE_INACTIVE; 
                $car = self::createCar(0, $params);
                if (!is_null($car)) {
                    $params['cars_id'] = $car->id;
                    $params['car_number'] = $car->number;
                    $params['currency'] = $car->currency;
                    $taxation = Taxation::create($params);
                    if (!is_null($taxation) && !is_null($car)) {
                        $car->n_tasacion = str_pad($taxation->id, Taxation::STR_PAD_VALUE, '0', STR_PAD_LEFT);
                        $car->save();
                    }
                    // MASTER INFO
                    self::updateMasterInfo($taxation);
                    $message = "La tazación vehicular se registró correctamente.";
                    $messageClass = "success";
                } else {    
                    $message = "La tazación vehicular no se pudo registrar.";
                    $messageClass = "danger";
                }
            }
        }
        return redirect()->route(Taxation::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function update($id, Request $request)
    {
        $params = $request->all();
        $taxation = Taxation::find($id);
        if (!is_null($taxation)) {
            self::createCar($taxation->cars_id, $params);
            $params['updated_by'] = Auth::user()->id;
            $taxation->fill($params);
            $taxation->save();
            // MASTER INFO
            self::updateMasterInfo($taxation);
            $message = "La información se actualizó correctamente.";
            $messageClass = "success";
        } else {
            $message = "La tazación vehicular no fue encontrado.";
            $messageClass = "danger";
        }
        return redirect()->route(Taxation::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function destroy($id, Request $request)
    {
        $taxation = Taxation::find($id);
        if (!is_null($taxation)) {
            $taxation->deleted_by = Auth::user()->id;
            $taxation->flag_active = Taxation::STATE_INACTIVE;
            $taxation->deleted_at = date("Y-m-d H:i:s");
            $taxation->save();
            $message = "La tazación vehicular se eliminó correctamente.";
            $messageClass = "success";
        } else {
            $message = "La tazación vehicular no fue encontrado.";
            $messageClass = "danger";
        }
        return redirect()->route(Taxation::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function show($id, Request $request)
    {
        return "show method";
    }

    /**
     * Car module
     *
     * @param  \App\Models\car  $model
     * @return \Illuminate\View\View
     */
    public function editImages($taxationId)
    {
        $taxation = Taxation::find((int)$taxationId);
        if (!is_null($taxation)) {
            return view(Taxation::MODULE_NAME . '.edit_images', compact('taxation'));
        } else {
            $message = "El código de la tasación no fue encontrado.";
            $messageClass = "danger";
            return redirect()->route(Taxation::MODULE_NAME . '.index')
                ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        }
    }

    public function updateImages($id, Request $request)
    {
        $params = $request->all();
        $taxation = Taxation::find($id);
        if (!is_null($taxation)) {
            $params = $request->validate([
                'custom_image1' => 'image|mimes:jpeg,png,jpg,gif,svg',
                'custom_image2' => 'image|mimes:jpeg,png,jpg,gif,svg',
                'custom_image3' => 'image|mimes:jpeg,png,jpg,gif,svg',
                'custom_image4' => 'image|mimes:jpeg,png,jpg,gif,svg',
                'custom_image5' => 'image|mimes:jpeg,png,jpg,gif,svg',
                'custom_image6' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            $images = [];
            foreach ($params as $key => $value) {
                $imageName = time() . '_' . $key . '.'.$value->extension();
                $value->move(public_path('taxation_images/' . $taxation->id . '/'), $imageName);
                $images[$key] = 'taxation_images/' . $taxation->id . '/' . $imageName;
            }
            $params['updated_by'] = Auth::user()->id;
            $taxation->progress_image_json = $images;
            $taxation->save();
            $message = "Las imágenes de la tasación se actualizaron correctamente.";
            $messageClass = "success";
        } else {
            $message = "Las imágenes no fueron actualizados.";
            $messageClass = "danger";
        }
        return redirect()->route(Taxation::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    private static function updateMasterInfo($taxation) : void
    {
        // MASTERS
        MsMasterController::findAndStore($taxation->taxator, 'taxator', null, null, $taxation, 'taxator_id');
        MsMasterController::findAndStore($taxation->salesman, 'salesman', null, null, $taxation, 'salesman_id');
    }

    private static function createCar($carId, $params)
    {
        $car = Car::find((int)$carId);
        if (is_null($car)) {
            if (isset($params['car_json'])) {
                $params['car_json']['created_by'] = Auth::user()->id;
                $car = Car::create($params['car_json']);
            }
        } else {
            if (isset($params['car_json'])) {
                $params['car_json']['updated_by'] = Auth::user()->id;
                $car->fill($params['car_json']);
                $car->save();
            }
        }
        // auto creado o actualizado
        if (!is_null($car)) {
            // details
            $carEntryDetail = CarEntryDetail::whereNull(CarEntryDetail::TABLE_NAME . '.deleted_at')
                ->where(CarEntryDetail::TABLE_NAME . '.cars_id', $car->id)
                ->first();
            if (!is_null($carEntryDetail)) {
                $carEntryDetail->kilometers = $params['car_json']['kilometers']; 
                $carEntryDetail->save();
            } else {
                $carEntryDetail = CarEntryDetail::create(
                    [ 
                        "cars_id" => $car->id, 
                        "kilometers" => $params['car_json']['kilometers'] 
                    ]
                );
            }
            // MASTERS
            CarController::callUpdateMasterInfo($car);
        }
        return $car;
    }
}
