<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\ExchangeRate;
use App\Models\CarEntryDetail;
use App\Models\CarEntryExpense;
use App\Models\MsCostPerDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class CarEntryController extends Controller
{
    /**
     * Details module
     *
     * @param  \App\Models\CarEntryDetail  $model
     * @return \Illuminate\View\View
     */
    public function editDetails($carId)
    {
        $carEntryDetail = CarEntryDetail::with('car')
            ->whereNull(CarEntryDetail::TABLE_NAME . '.deleted_at')
            ->where(CarEntryDetail::TABLE_NAME . '.cars_id', (int)$carId)
            ->first();
        if (!is_null($carEntryDetail)) {
            return view(Car::MODULE_NAME . '.edit_details', compact('carEntryDetail'));
        } else {
            $car = Car::find((int)$carId);
            if (!is_null($car)) {
                return view(Car::MODULE_NAME . '.create_details', compact('car'));
            } else {
                $message = "El código del vehículo no fue encontrado.";
                $messageClass = "danger";
                if ((int)Auth::user()->rols_id === 1) {
                    return redirect()->route(Car::MODULE_NAME . '.index')
                    ->with( ['message' => $message, 'messageClass' => $messageClass ] );
                } else {
                    return redirect()->route(Car::MODULE_NAME . '.index-salers')
                    ->with( ['message' => $message, 'messageClass' => $messageClass ] );
                }
            }
        }
    }

    public function storeDetails(Request $request)
    {
        $params = $request->all();
        $params['created_by'] = Auth::user()->id;
        if (isset($params['description'])) {
            $params['description'] = html_entity_decode($params['description']);
        }
        $carEntryDetail = CarEntryDetail::create($params);
        $message = "Las características del vehículo se agregaron correctamente.";
        $messageClass = "success";
        if ((int)Auth::user()->rols_id === 1) {
            return redirect()->route(Car::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        } else {
            return redirect()->route(Car::MODULE_NAME . '.index-salers')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        }
    }

    public function updateDetails($id, Request $request)
    {
        $params = $request->all();
        $carEntryDetail = CarEntryDetail::find($id);
        if (!is_null($carEntryDetail)) {
            $user = Auth::user(); 
            if ($user->rols_id !== 1)  {
                $params['created_by'] = $user->id;
                $car = Car::find($carEntryDetail->cars_id);
                if (!is_null($car)) {
                    $car->created_by = $user->id;
                    $car->save();
                }
            }
            $params['updated_by'] = $user->id;
            if (!isset($params['options_json'])) {
                $params['options_json'] = [];
            }
            if (isset($params['description'])) {
                // var_dump(1, $params['description']);
                // exit();
                $params['description'] = html_entity_decode($params['description']);
                // var_dump(2, $params['description']);
                // exit();
            }
            $carEntryDetail->fill($params);
            $carEntryDetail->save();
            $message = "Las características del vehículo se actualizaron correctamente.";
            $messageClass = "success";
        } else {
            $message = "El características no fueron actualizadas.";
            $messageClass = "danger";
        }
        if ((int)$user->rols_id === 1) {
            return redirect()->route(Car::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        } else {
            return redirect()->route(Car::MODULE_NAME . '.index-salers')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        }
    }

    /**
     * Expenses module
     *
     * @param  \App\Models\CarEntryExpense  $model
     * @return \Illuminate\View\View
     */
    public function editExpenses($carId)
    {
        $carEntryExpense = CarEntryExpense::with('car')
            ->whereNull(CarEntryExpense::TABLE_NAME . '.deleted_at')
            ->where(CarEntryExpense::TABLE_NAME . '.cars_id', (int)$carId)
            ->first();
        $costPerDay = MsCostPerDay::whereNull(MsCostPerDay::TABLE_NAME . '.deleted_at')->first();
        if (is_null($costPerDay)) {
            $message = "No existe información sobre los gastos diarios. Porfavor, ingrese gastos diarios.";
            $messageClass = "danger";
            return redirect()->route(Car::MODULE_NAME . '.index')
                ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        }
        // exchange rate
        $exchangeRateValue = 4.10;
        $exchangeRate = ExchangeRate::whereNull(ExchangeRate::TABLE_NAME . '.deleted_at')
            ->where(ExchangeRate::TABLE_NAME . '.fecha', date("Y-m-d"))
            ->where(ExchangeRate::TABLE_NAME . '.moneda', ExchangeRate::DEFAULT_CURRENCY)
            ->first();
        if (is_null($exchangeRate)) {
            try {
                $exchangeRateClient = Http::get(env('URL_API_TC'));
                if ($exchangeRateClient->ok()) {
                    $exchangeRate = ExchangeRate::create($exchangeRateClient->json());
                    if ($exchangeRate) {
                        $exchangeRateValue = (float)$exchangeRate->venta;
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        } else {
            $exchangeRateValue = (float)$exchangeRate->venta;
        }

        if (!is_null($carEntryExpense)) {
            $carEntryExpense->car->cost_per_day = $costPerDay->total;
            $car = $carEntryExpense->car;
            return view(Car::MODULE_NAME . '.edit_expenses', compact('carEntryExpense', 'exchangeRateValue', 'car'));
        } else {
            $car = Car::find((int)$carId);
            if (!is_null($car)) {
                $car->cost_per_day = $costPerDay->total;
                return view(Car::MODULE_NAME . '.create_expenses', compact('car', 'exchangeRateValue'));
            } else {
                $message = "El código del vehículo no fue encontrado.";
                $messageClass = "danger";
                return redirect()->route(Car::MODULE_NAME . '.index')
                    ->with( ['message' => $message, 'messageClass' => $messageClass ] );
            }
        }
    }

    public function storeExpenses(Request $request)
    {
        $params = $request->all();
        $params['created_by'] = Auth::user()->id;
        if (isset($params['expenses_json'])) {
            $expensesJson = [];
            foreach ($params['expenses_json'] as $key => $value) {
                if ($value['value']) {
                    array_push($expensesJson, $value);
                }
            }
            $params['expenses_json'] = $expensesJson;
        }
        $carEntryExpense = CarEntryExpense::create($params);
        $carSelected = $carEntryExpense->cars_id;
        $message = "Los gastos del vehículo se agregaron correctamente.";
        $messageClass = "success";
        return redirect()->route(Car::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass, 'carSelected' => $carSelected ] );
    }

    public function updateExpenses($id, Request $request)
    {
        $params = $request->all();
        $carEntryExpense = CarEntryExpense::find($id);
        $carSelected = 0;
        if (!is_null($carEntryExpense)) {
            $params['updated_by'] = Auth::user()->id;
            if (isset($params['expenses_json'])) {
                $expensesJson = [];
                foreach ($params['expenses_json'] as $key => $value) {
                    if ($value['value']) {
                        array_push($expensesJson, $value);
                    }
                }
                $params['expenses_json'] = $expensesJson;
            }
            $carEntryExpense->fill($params);
            $carEntryExpense->save();
            $message = "Los gastos del vehículo se actualizaron correctamente.";
            $messageClass = "success";
            $carSelected = $carEntryExpense->cars_id;
        } else {
            $message = "Los gastos no fueron actualizados.";
            $messageClass = "danger";
        }
        return redirect()->route(Car::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass, 'carSelected' => $carSelected ] );
    }

    /**
     * Car module
     *
     * @param  \App\Models\car  $model
     * @return \Illuminate\View\View
     */
    public function editImages($carId)
    {
        $car = Car::find((int)$carId);
        if (!is_null($car)) {
            return view(Car::MODULE_NAME . '.edit_images', compact('car'));
        } else {
            $message = "El código del vehículo no fue encontrado.";
            $messageClass = "danger";
            if ((int)Auth::user()->rols_id === 1) {
                return redirect()->route(Car::MODULE_NAME . '.index')
                ->with( ['message' => $message, 'messageClass' => $messageClass ] );
            } else {
                return redirect()->route(Car::MODULE_NAME . '.index-salers')
                ->with( ['message' => $message, 'messageClass' => $messageClass ] );
            }
        }
    }

    public function updateImages($id, Request $request)
    {
        $params = $request->all();
        $car = Car::find($id);
        if (!is_null($car)) {
            try {
                $paramsAll = $request->all();
                $params = $request->validate([
                    'custom_image1' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image2' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image3' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image4' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image5' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image6' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image7' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image8' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image9' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image10' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image11' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image12' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image13' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image14' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image15' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image16' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image17' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image18' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image19' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                    'custom_image20' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
                ]);
            } catch (\Throwable $th) {
                dd($th);
            }
            $images = [];
            foreach ($params as $key => $value) {
                $imageName = time() . '_' . $key . '.'.$value->extension();
                $value->move(public_path('car_images/' . $car->id . '/'), $imageName);
                $images[$key] = 'car_images/' . $car->id . '/' . $imageName;
            }
            $params['updated_by'] = Auth::user()->id;
            $actualImages = $car->images_json;
            if (!is_null($actualImages) && count($actualImages) > 0) {
                foreach ($paramsAll as $key => $value) {
                    if (is_null($paramsAll[$key])) {
                        unset($actualImages[str_replace('hidden_', '', $key)]);
                    }
                }
                foreach ($images as $key => $value) {
                    $actualImages[$key] = $value;
                }
            } else {
                $actualImages = $images;
            }
            $car->images_json = $actualImages;
            $car->save();
            $message = "Las imágenes del vehículo se actualizaron correctamente.";
            $messageClass = "success";
        } else {
            $message = "Las imágenes no fueron actualizados.";
            $messageClass = "danger";
        }
        if ((int)Auth::user()->rols_id === 1) {
            return redirect()->route(Car::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        } else {
            return redirect()->route(Car::MODULE_NAME . '.index-salers')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        }
    }
}