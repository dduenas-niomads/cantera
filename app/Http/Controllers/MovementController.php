<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use App\Models\Movement;
use App\Models\Client;
use App\Models\Sale;
use App\Models\Reservation;
use App\Models\Purchase;
use App\Models\Tax;
use App\Models\MsCostPerDay;
use App\Models\CarEntryExpense;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Http as HttpClient;
use Excel;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\ReservationController;

class MovementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth()->user();
        $list = Movement::select(Movement::TABLE_NAME . '.*', 
                \DB::raw("JSON_LENGTH(items) as total_products"))
            ->whereNull(Movement::TABLE_NAME . '.deleted_at')
            ->where(Movement::TABLE_NAME . '.pos_companies_id', $user->pos_companies_id);
        if ($user->rolls_id !== 1) {
            $list = $list->where(Movement::TABLE_NAME . '.cancha_id', $user->cancha_id);
        }
        $list = $list->get();
        return view('movements.index', compact('list'));
    }

    public function create()
    {
        $user = Auth()->user();
        $reservation = null;
        $rucs = [];
        return view('movements.create', compact('user', 'reservation', 'rucs'));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        dd($params);
    }

    public function apiStore(Request $request)
    {
        $params = $request->all();
        $user = Auth()->user();
        $status = 400;
        $message = "No se puede proceder con la creación del movimiento. Los datos no son válidos.";
        
        if (!is_null($user)) {
            // total sale cost
            $totalSaleCost = 0;
            foreach ($params['items'] as $key => $value) {
                $totalSaleCost = $totalSaleCost + ((float)$value['quantity']*(float)$value['price']);
            }
            // products
            foreach ($params['items'] as $key => $value) {
                ProductController::findOrCreateProduct($value, false);
            }
            // movement
            $movement = new Movement();
            $movement->pos_companies_id = $user->pos_companies_id;
            $movement->description = $params['info']['description'];
            $movement->cancha_id = $user->cancha_id;
            $movement->type_movement = $params['info']['type_document'];
            switch ((int)$movement->type_movement) {
                case 1:
                    $movement->type_movement_name = Movement::MOVEMENT_TYPE_01;
                    break;
                case 2:
                    $movement->type_movement_name = Movement::MOVEMENT_TYPE_02;
                    break;
                case 3:
                    $movement->type_movement_name = Movement::MOVEMENT_TYPE_03;
                    break;                
                default:
                    $movement->type_movement_name = Movement::MOVEMENT_TYPE_01;
                    break;
            }
            $movement->date_start = $params['info']['date_start'];
            $movement->items = $params['items'];
            $movement->total_amount = $totalSaleCost;
            $movement->save();
            $status = 200;
            $message = "Movimiento creado correctamente";

            return response([
                "message" => $message
            ], $status);
        }
    }

    public static function createMovement($params = [], $document = null, $type_movement = 2, $type_movement_name = Movement::MOVEMENT_TYPE_02_SALE)
    {
        # for sale purpose
        $user = Auth()->user();
        $movement = null;
        // movement
        $movement = new Movement();
        $movement->pos_companies_id = $user->pos_companies_id;
        $movement->cancha_id = $user->cancha_id;
        $movement->type_movement = $type_movement;
        $movement->type_movement_name = $type_movement_name;
        $movement->date_start = date("Y-m-d");
        $movement->items = [$params];
        $totalSaleCost = 0;
        if (isset($params['quantity']) && isset($params['price'])) {
            $totalSaleCost = $params['quantity']*$params['price'];
        }
        $movement->total_amount = $totalSaleCost;
        $movement->ref_document_id = $document->id;
        $movement->ref_document = $document->serie . "-" . str_pad($document->correlative, 6, "0", STR_PAD_LEFT);
        $movement->save();
        
        return $movement;
    }

    public function createExcelUpload()
    {
        $user = Auth()->user();
        $reservation = null;
        $rucs = [];
        return view('movements.create-excel-upload', compact('user', 'reservation', 'rucs'));
    }

    public function postCreateExcelUpload(Request $request)
    {
        $message = "No se puede proceder con la creación del movimiento. Los datos no son válidos.";
        $messageClass = "danger";
        
        $params = $request->all();
        $items = [];
        if (isset($params['file'])) {
            $document = Excel::toArray(null, $params['file']);
            if (isset($document[0])) {
                $time = time();
                $codeItem = 1;
                foreach ($document[0] as $key => $value) {
                    # code...
                    if ($key !== 0) {
                        array_push($items, [
                            "id" => null,
                            "code" => !is_null($value[0]) ? $value[0] : ($time . "-" . $codeItem),
                            "family" => $value[1],
                            "subfamily" => $value[2],
                            "name" => $value[3],
                            "generic" => $value[4],
                            "lab" => $value[5],
                            "quantity" => (float)$value[6],
                            "price" => (float)$value[7],
                            "trCode" => $time,
                        ]);
                    }
                    $codeItem++;
                }
            }
        }// total sale cost
        $totalSaleCost = 0;
        foreach ($items as $key => $value) {
            $totalSaleCost = $totalSaleCost + ((float)$value['quantity']*(float)$value['price']);
        }
        // products
        foreach ($items as $key => $value) {
            ProductController::findOrCreateProduct($value, false);
        }
        // movement
        $user = Auth()->user();
        $movement = new Movement();
        $movement->pos_companies_id = $user->pos_companies_id;
        $movement->description = $params['description'];
        $movement->cancha_id = $user->cancha_id;
        $movement->type_movement = $params['type_movement'];
        switch ((int)$movement->type_movement) {
            case 1:
                $movement->type_movement_name = Movement::MOVEMENT_TYPE_01;
                break;
            case 2:
                $movement->type_movement_name = Movement::MOVEMENT_TYPE_02;
                break;
            case 3:
                $movement->type_movement_name = Movement::MOVEMENT_TYPE_03;
                break;                
            default:
                $movement->type_movement_name = Movement::MOVEMENT_TYPE_01;
                break;
        }
        $movement->date_start = $params['date_start'];
        $movement->items = $items;
        $movement->total_amount = $totalSaleCost;
        $movement->save();
        $message = "Movimiento creado correctamente - Son " . count($items) . " items cargados.";
        $messageClass = "success";

        return redirect()->route(Movement::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }
}
