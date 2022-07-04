<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Client;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the cars
     *
     * @param  \App\Models\Car  $model
     * @return \Illuminate\View\View
     */
    public function __construct() {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth()->user();
        if ($user->rols_id === 1) {
            $cancha = new \stdClass();
            $cancha->id = $user->cancha_id;
            $cancha->name = "Cancha " . $user->cancha_id;
            $user->cancha = $cancha;
            return view('reservations.index_salers', compact('user'));
        } else {
            $cancha = new \stdClass();
            $cancha->id = $user->cancha_id;
            $cancha->name = "Cancha " . $user->cancha_id;
            $user->cancha = $cancha;
            return view('reservations.index', compact('user'));
        }
    }

    public function index2(Request $request)
    {
        $user = Auth()->user();
        $cancha = new \stdClass();
        $cancha->id = 1;
        $cancha->name = "Cancha 1";
        $user->cancha = $cancha;
        return view('reservations.index', compact('user'));
    }

    public function apiIndex(Request $request, $pagination = true)
    {
        $params = $request->all();
        $user = Auth()->user();
        // car list
        $status = 1;
        $list = Reservation::select(Reservation::TABLE_NAME . '.*',
                Client::TABLE_NAME . '.names as client_name')
            ->join(Client::TABLE_NAME, Client::TABLE_NAME . '.id', '=', 
                Reservation::TABLE_NAME . '.client_id')
            ->whereNull(Reservation::TABLE_NAME . '.deleted_at');

        if ($user->rolls_id !== 1) {
            $list = $list->where(Reservation::TABLE_NAME . '.cancha_id', $user->cancha_id);
        }

        if (isset($params['search']) && isset($params['search']['value'])) {
            $key = $params['search']['value'];
            $list = $list->where(function($query) use ($key) {
                $query->where(Reservation::TABLE_NAME . '.reservation_date', 'LIKE', '%' . $key . '%');
                $query->orWhere(Reservation::TABLE_NAME . '.reservation_time', 'LIKE', '%' . $key . '%');
                $query->orWhere(Client::TABLE_NAME . '.names', 'LIKE', '%' . $key . '%');
            });
        }

        if (isset($params['start']) && isset($params['end'])) {
            $start = $this->createCarbonFromDate(null, $params['start']);
            $end = $this->createCarbonFromDate(null, $params['end']);
            $list = $list->whereBetween(Reservation::TABLE_NAME . '.reservation_date', [$start->toDateString(), $end->toDateString()]);
        }

        if (isset($params['order'])) {
            $array_order = Reservation::ARRAY_ORDER;
            $list = $list->orderBy(Reservation::TABLE_NAME . 
                $array_order[$params['order'][0]['column']], 
                $params['order'][0]['dir']);
        } else {
            $list = $list->orderBy(Reservation::TABLE_NAME . '.id', 'DESC');
        }
        
        if ($pagination) {
            $list = $list->paginate(env('ITEMS_PAGINATOR'));
            return response($list, 200);
        } else {
            $list = $list->get();
            return $list;
        }
    }

    public function apiIndexCount($startIso, $endIso, $canchaId = null, $clientId = null)
    {
        # code...
        $list = Reservation::whereNull(Reservation::TABLE_NAME . '.deleted_at')
            ->whereIn(Reservation::TABLE_NAME . '.flag_active', [Reservation::STATE_ACTIVE, Reservation::STATE_PAYED]);
        if (!is_null($canchaId)) {
            $list = $list->where(Reservation::TABLE_NAME . '.cancha_id', $canchaId);
        }
        if (!is_null($clientId)) {
            $list = $list->where(Reservation::TABLE_NAME . '.client_id', '!=', $clientId);
        }
        if (isset($startIso) && isset($endIso)) {
            $list = $list->where(function($query) use ($startIso, $endIso){
                $query->whereBetween(Reservation::TABLE_NAME . '.reservation_date_start_iso', [$startIso, $endIso])
                    ->orWhereBetween(Reservation::TABLE_NAME . '.reservation_date_end_iso', [$startIso, $endIso]);
            });
        }
        $list = $list->get();
        return $list;
    }

    public function apiIndexAsEvents(Request $request)
    {
        $list = $this->apiIndex($request, false);
        $list_ = [];

        foreach ($list as $key => $value) {
            $color = "red";
            $extraTitle = "";
            if ((float)$value->payment > 0) {
                # code...
                $color = "orange";
                $extraTitle = " ADELANTO: S/ " . $value->payment;
            }
            if ((int)$value->flag_active === 2) {
                # code...
                $color = "#2e9e6e";
                $extraTitle = " PAGADO";
            }
            array_push($list_, [
                "title" => $value->client_name . $extraTitle,
                "start" => $value->reservation_date_start_iso, // please specify dates in milliseconds, not seconds
                "end" => $value->reservation_date_end_iso,
                "color" => $color,   // a non-ajax option
                "textColor" => "white", // a non-ajax option,
                "description" => $extraTitle,
                "object" => $value,
                // "url" => "/sales/create?reservation_code=" . $value->id
            ]);
        }

        return response($list_, 200);
    }

    public static function validateReservationInfo($params = [])
    {
        $reservation = null;
        if (isset($params['reservation_id'])) {
            $reservation = Reservation::find((int)$params['reservation_id']);
            if (!is_null($reservation)) {
                if (isset($params['reservation_cost_pr_hour'])) {
                    $reservation->price_pr_hour = $params['reservation_cost_pr_hour'];
                }
                $reservation->save();
            }
        }
        return $reservation;
    }

    public static function addPaymentToReservation($reservation = null, $totalCost = 0, $paymentAmount = 0)
    {
        if (!is_null($reservation)) {
            $reservation->payment = $reservation->payment + $paymentAmount;
            $reservation->save();
            // total cost
            if ($totalCost <= $reservation->payment) {
                $reservation->flag_active = Reservation::STATE_PAYED;
                $reservation->save();
            }
        }

        return $reservation;
    }

    public function create(Request $request)
    {
        $params = $request->all();
        $product = null;
        $message = "Si desea, puede crear un producto a partir de una tasación.";
        $messageClass = "default";
        // users
        $users = User::whereNull('deleted_at')->orderBy('name', 'ASC')->get();
        $userId = Auth::user()->id;
        return view(Product::MODULE_NAME . '.create', compact('product', 'message', 'messageClass', 'users', 'userId'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if (!is_null($product)) {
            return view(Product::MODULE_NAME . '.edit', compact('product'));
        } else {
            $message = "El producto no fue encontrado.";
            $messageClass = "danger";
            return redirect()->route(Product::MODULE_NAME . '.index')
                ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        }
    }

    public function apiStore(Request $request)
    {
        $params = $request->all();
        $reservation = null;
        $httpStatus = 400;
        $httpMessage = "No se pudo crear la reserva. Los datos no son correctos.";
        // inicio
        if (!isset($params['reservation_client_id'])) {
            // crear cliente
            $client = new Client();
            $client->type = Client::DEFAULT_TYPE;
            $client->type_document = Client::DEFAULT_TYPE_DOCUMENT;
            $client->document_number = Client::DEFAULT_DOCUMENT_NUMBER;
            $client->names = $params['reservation_client'];
            $client->save();
            // set client id
            $params['reservation_client_id'] = $client->id;
        }
        // crear reserva
        if (!is_null($params['reservation_client_id'])) {
            $dateStart = $this->createCarbonFromDate($params);
            $dateEnd = $this->createCarbonFromDate($params);
            $dateEnd = $dateEnd->addMinutes(isset($params['reservation_time']) ? $params['reservation_time'] : Reservation::DEFAULT_TIME);
            $validation = $this->validateInSchedule($dateStart, $dateEnd, $params['reservation_time']);
            if ($validation[0]) {
                $reservation = $this->createReservation($params, $dateStart, $dateEnd);
                if (!is_null($reservation)) {
                    $httpStatus = 200;
                    $httpMessage = "La reserva se creó satisfactoriamente.";
                }
            } else {
                $httpStatus = 400;
                $httpMessage = isset($validation[1]) ? $validation[1] : "No se pudo crear la reserva. Inténtelo nuevamente.";
            }
        }
        // respuesta
        return response( [
            'message' => $httpMessage,
            'params' => $params,
            'object' => $reservation
        ], $httpStatus);
    }

    public function createReservation($params = [], $dateStart, $dateEnd)
    {
        $reservation = new Reservation();
        // business fields
        $reservation->cancha_id = $params['reservation_cancha_id'];
        $reservation->client_id = $params['reservation_client_id'];
        // date & time fields
        $reservation->reservation_date_start_iso = $dateStart->toIsoString();
        $reservation->reservation_date_end_iso = $dateEnd->toIsoString();
        $reservation->reservation_date = $dateStart->toDateString(); 
        $reservation->reservation_hour = $dateStart->toTimeString();
        $reservation->reservation_date_end = $dateEnd->toDateString(); 
        $reservation->reservation_hour_end = $dateEnd->toTimeString();
        $reservation->reservation_hour_hh = $params['reservation_hour_hh'];
        $reservation->reservation_hour_mm = $params['reservation_hour_mm'];
        $reservation->reservation_hour_ampm = $params['reservation_hour_ampm'];
        $reservation->reservation_time = isset($params['reservation_time']) ? $params['reservation_time'] : Reservation::DEFAULT_TIME;
        $reservation->reservations_id = isset($params['reservations_id']) ? $params['reservations_id'] : null;
        $reservation->price_pr_hour = isset($params['price_pr_hour']) ? $params['price_pr_hour'] : Reservation::DEFAULT_PRICE_PR_HOUR;
        // save
        $reservation->save();
        return $reservation;
    }

    public function apiUpdate(Request $request, $id)
    {
        # code...
        $params = $request->all();
        $reservation = null;
        $httpStatus = 400;
        $httpMessage = "No se pudo reprogramar la reserva. Los datos no son correctos.";
        $params = $request->all();
        $reservation = Reservation::WhereNull(Reservation::TABLE_NAME . '.deleted_at')->find($id);
        // crear reserva
        if (!is_null($reservation)) {
            $dateStart = $this->createCarbonFromDate($params);
            $dateEnd = $this->createCarbonFromDate($params);
            $dateEnd = $dateEnd->addMinutes(isset($params['reservation_time']) ? $params['reservation_time'] : Reservation::DEFAULT_TIME);
            $validation = $this->validateInSchedule($dateStart, $dateEnd, $params['reservation_time'], $reservation->cancha_id, $reservation->client_id);
            if ($validation[0]) {
                // date & time fields
                $reservation->reservation_date_start_iso = $dateStart->toIsoString();
                $reservation->reservation_date_end_iso = $dateEnd->toIsoString();
                $reservation->reservation_date = $dateStart->toDateString(); 
                $reservation->reservation_hour = $dateStart->toTimeString();
                $reservation->reservation_date_end = $dateEnd->toDateString(); 
                $reservation->reservation_hour_end = $dateEnd->toTimeString();
                $reservation->reservation_hour_hh = $params['reservation_hour_hh'];
                $reservation->reservation_hour_mm = $params['reservation_hour_mm'];
                $reservation->reservation_hour_ampm = $params['reservation_hour_ampm'];
                $reservation->reservation_time = isset($params['reservation_time']) ? $params['reservation_time'] : Reservation::DEFAULT_TIME;
                $reservation->additional_time = isset($params['additional_time']) ? $params['additional_time'] : 0;
                // save
                $reservation->save();
                if (!is_null($reservation)) {
                    $httpStatus = 200;
                    $httpMessage = "La reserva se reprogramó satisfactoriamente.";
                    if (isset($params['repeat']) && (int)$params['repeat'] > 0) {
                        # code...
                        $repeatResult = $this->repeatReservation($reservation, (int)$params['repeat']);
                        $httpMessage = "La reserva se reprogramó satisfactoriamente. Se repetirá " . $repeatResult . " veces más.";
                    }
                }
            } else {
                $httpStatus = 400;
                $httpMessage = isset($validation[1]) ? $validation[1] : "No se pudo reprogramar la reserva. Inténtelo nuevamente.";
            }
        }
        // respuesta
        return response( [
            'message' => $httpMessage,
            'params' => $params,
            'object' => $reservation
        ], $httpStatus);
    }

    public function repeatReservation($reservation = null, $repeat = 0)
    {
        if ($repeat > 0 && !is_null($reservation)) {
            $count = 0;
            $carbonStartDate = Carbon::parse($reservation->reservation_date_start_iso)->tz('America/Lima');
            $carbonEndDate = Carbon::parse($reservation->reservation_date_end_iso)->tz('America/Lima');
            $reservationArray = [
                "reservations_id" => $reservation->id,
                "reservation_cancha_id" => $reservation->cancha_id,
                "reservation_client_id" => $reservation->client_id,
                "reservation_hour_hh" => $reservation->reservation_hour_hh,
                "reservation_hour_mm" => $reservation->reservation_hour_mm,
                "reservation_hour_ampm" => $reservation->reservation_hour_ampm,
                "reservation_time" => $reservation->reservation_time,
            ];
            switch ($repeat) {
                case 1:
                    $carbonStartDate->addWeek();
                    $carbonEndDate->addWeek();
                    $validation = $this->validateInSchedule($carbonStartDate, $carbonEndDate, $reservation->reservation_time, $reservation->cancha_id);
                    if ($validation[0]) {
                        $reservation = $this->createReservation($reservationArray, $carbonStartDate, $carbonEndDate);
                        if (!is_null($reservation)) {
                            $count++;
                        }
                    }
                    break;
                case 2:
                    $month = $carbonStartDate->month;
                    while ($month === $carbonStartDate->month) {
                        $carbonStartDate->addWeek();
                        $carbonEndDate->addWeek();
                        if ($month === $carbonStartDate->month) {
                            $validation = $this->validateInSchedule($carbonStartDate, $carbonEndDate, $reservation->reservation_time, $reservation->cancha_id);
                            if ($validation[0]) {
                                $reservation = $this->createReservation($reservationArray, $carbonStartDate, $carbonEndDate);
                                if (!is_null($reservation)) {
                                    $count++;
                                }
                            }
                        }
                    }
                    break;
                case 3:
                    $year = $carbonStartDate->year;
                    while ($year === $carbonStartDate->year) {
                        $carbonStartDate->addWeek();
                        $carbonEndDate->addWeek();
                        if ($year === $carbonStartDate->year) {
                            $validation = $this->validateInSchedule($carbonStartDate, $carbonEndDate, $reservation->reservation_time, $reservation->cancha_id);
                            if ($validation[0]) {
                                $reservation = $this->createReservation($reservationArray, $carbonStartDate, $carbonEndDate);
                                if (!is_null($reservation)) {
                                    $count++;
                                }
                            }
                        }
                    }
                    break;
                
                default:
                    break;
            }
            return $count;
        }
    }

    public function apiValidateInSchedule($dateStartIsoString = null, $dateEndIsoString = null, $timing = 0)
    {
        $dateStart = Carbon::parse($dateStartIsoString)->tz('America/Lima');
        $dateEnd = Carbon::parse($dateEndIsoString)->tz('America/Lima');

        return $this->validateInSchedule($dateStart, $dateEnd, $timing);
    }

    public function validateInSchedule($dateStart = null, $dateEnd = null, $timing = 0, $canchaId = null, $clientId = null)
    {
        $dateNow = Carbon::now()->tz('America/Lima');
        $greatherThan = $dateStart->gt($dateNow);
        $user = Auth()->user();
        if (is_null($user)) {
            return [false, "Error en permisos de usuario."];
        }
        if ($greatherThan) {
            if (is_null($canchaId)) {
                $canchaId = $user->cancha_id;
            }
            $list = $this->apiIndexCount($dateStart->addMinute()->toIsoString(), $dateEnd->subMinute()->toIsoString(), $canchaId, $clientId);
            if (count($list) > 0) {
                $dateStart->subMinute();
                $dateEnd->addMinute();
                return [false, "Existen reservas en ese horario."];
            }
            $dateStart->subMinute();
            $dateEnd->addMinute();
            return [true];
        } else {
            return [false, "Fecha menor a este momento."];
        }
    }

    public function store(Request $request)
    {
        $params = $request->all();
        # buscar producto por código
        if (isset($params['code'])) {
            $productByCode = self::findProductByCode(strtoupper($params['code']));
            if (!is_null($productByCode)) {
                $message = "El producto no se pudo registar. El código ya existe.";
                $messageClass = "danger";
                return redirect()->route(Product::MODULE_NAME . '.index')
                    ->with( ['message' => $message, 'messageClass' => $messageClass ] );
            }
        }
        # crear producto
        $product = Product::create($params);
        $message = "El producto se creó correctamente.";
        $messageClass = "success";
        # validar creación
        if (is_null($product)) {
            $message = "El producto no se pudo crear.";
            $messageClass = "danger";
        } else {
            // masters logic
            if (!isset($params['code'])) {
                $product->code = $product->id;
                $product->save();
            }
        }
        # respuesta
        return redirect()->route(Product::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function update($id, Request $request)
    {
        $params = $request->all();
        $product = Product::find($id);
        if (!is_null($product)) {
            // masters logic
            $product->fill($params);
            $product->save();
            $message = "El producto se actualizó correctamente.";
            $messageClass = "success";
        } else {
            $message = "El producto no fue encontrado.";
            $messageClass = "danger";
        }
        return redirect()->route(Product::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function destroy($id, Request $request)
    {
        $product = Product::find($id);
        if (!is_null($product)) {
            $product->deleted_by = Auth::user()->id;
            $product->flag_active = Product::STATE_DELETE;
            $product->deleted_at = date("Y-m-d H:i:s");
            $product->save();
            $message = "La reserva se eliminó correctamente.";
            $messageClass = "success";
        } else {
            $message = "El producto no fue encontrado.";
            $messageClass = "danger";
        }
        return redirect()->route(Product::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function apiDestroy($id, Request $request)
    {
        $reservation = Reservation::find($id);
        if (!is_null($reservation)) {
            $reservation->deleted_by = Auth::user()->id;
            $reservation->flag_active = Reservation::STATE_DELETE;
            $reservation->deleted_at = date("Y-m-d H:i:s");
            $reservation->save();
            $count = 1;
            $params = $request->all();
            if (isset($params['reservation_option']) && 
                (int)$params['reservation_option'] === Reservation::DESTROY_ALL) {
                # code
                $reservationPatern = null;
                if (!is_null($reservation->reservations_id)) {
                    $reservationPatern = $reservation->reservations_id;
                } else {
                    $reservationPatern = $reservation->id;
                }
                if (!is_null($reservationPatern)) {
                    $queryUpdate = Reservation::whereNull(Reservation::TABLE_NAME . '.deleted_at')
                        ->where(Reservation::TABLE_NAME . '.reservations_id', $reservationPatern)
                        ->where(Reservation::TABLE_NAME . '.id', '>', $reservation->id);
                    $countQueryUpdate = $queryUpdate->count();
                    $queryUpdate->update([
                            'deleted_by' => Auth::user()->id,
                            'flag_active' => Reservation::STATE_DELETE,
                            'deleted_at' => date("Y-m-d H:i:s")
                        ]);
                    $count = $count + $countQueryUpdate;
                }
            }
            $message = "La reserva se eliminó correctamente. Fueron: " . $count . " eliminados.";
            $messageClass = "success";
            $httpStatus = 200;
        } else {
            $message = "La reserva no fue encontrada.";
            $messageClass = "danger";
            $httpStatus = 400;
        }
        return response( ['message' => $message, 'messageClass' => $messageClass ], $httpStatus );
    }

    public function show($id, Request $request)
    {
        return "show method";
    }

    public static function getTotalReservationsByPeriod($period, $canchaId = null)
    {
        $reservations = Reservation::whereNull(Reservation::TABLE_NAME . '.deleted_at')
            ->where(Reservation::TABLE_NAME . '.reservation_date', 'like' , '%' . $period . '%');
        if (!is_null($canchaId)) {
            # buscar por cancha id
        }
        $reservations = $reservations->get();

        return count($reservations);
    }

    private static function updateMasterInfo($car) : void
    {
        // MASTERS
        MsMasterController::findAndStore($car->brand, 'brand', null, null, $car, 'brand_id');
        MsMasterController::findAndStore($car->model, 'model', $car->brand, 'brand', $car, 'model_id');
        MsMasterController::findAndStore($car->color, 'color', null, null, $car, 'color_id');
        MsMasterController::findAndStore($car->notary, 'notary', null, null, $car, 'notary_id');
        MsMasterController::findAndStore($car->company_owner, 'company_owner', null, null, $car, null);
        // CLIENTS
        ClientController::findAndStore($car->holder, 'holder', $car, 'holder_id');
        ClientController::findAndStore($car->owner, 'owner', $car, 'owner_id');
    }

    public static function callUpdateMasterInfo($car) : void
    {
        self::updateMasterInfo($car);
    }

    private static function findProductByCode($code) {
        $product = Product::whereNull(Product::TABLE_NAME . '.deleted_at')
            ->where(Product::TABLE_NAME . '.flag_active', Product::STATE_ACTIVE)
            ->where(Product::TABLE_NAME . '.code', $code)
            ->first();
        return $product;
    }
}
