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
        $list = Movement::whereNull(Movement::TABLE_NAME . '.deleted_at');
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
            $movement->cancha_id = $user->cancha_id;
            $movement->type_movement = $params['info']['type_document'];
            $movement->type_movement_name = Movement::MOVEMENT_TYPE_01;
            if((int)$movement->type_movement === 2) {
                $movement->type_movement_name = Movement::MOVEMENT_TYPE_02;
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
        $movement = null;
        // movement
        $movement = new Movement();
        $movement->cancha_id = 1;
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
}
