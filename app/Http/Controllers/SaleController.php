<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
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

class SaleController extends Controller
{
    /**
     * Display a listing of the sales
     *
     * @param  \App\Models\Sale  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $saleList = Sale::whereNull(Sale::TABLE_NAME . '.deleted_at')
            ->with('client')
            ->with('document')
            ->get();
            
        return view(Sale::MODULE_NAME . '.index', compact('saleList'));
    }

    public function showReport(Request $request)
    {
        $this->saleAdjust($request);
        $params = $request->all();
        $saleList = Sale::whereNull(Sale::TABLE_NAME . '.deleted_at')
            ->with('car');
        if (isset($params['period']) && $params['period'] !== '0') {
            $saleList = $saleList->where(Sale::TABLE_NAME . '.sale_date', 'LIKE', '%' . $params['period'] . '%');
        }
        $saleList = $saleList->get();
        return view(Sale::MODULE_NAME . '.report', compact('saleList'));
    }

    public function saleAdjust(Request $request)
    {
        $params = $request->all();
        $saleList = Sale::whereNull(Sale::TABLE_NAME . '.deleted_at')
            ->with('car');
        if (isset($params['period']) && $params['period'] !== '0') {
            $saleList = $saleList->where(Sale::TABLE_NAME . '.sale_date', 'LIKE', '%' . $params['period'] . '%');
        }
        $saleList = $saleList->get();
        $counter = 0;
        foreach ($saleList as $key => $value) {
            // adjust price cost
            $newExpensesValue = $this->getTotalExpensesAmount($value->cars_id);
            if ((float)$value->total_expenses !== (float)$newExpensesValue) {
                $counter++;
                Sale::find($value->id)
                    ->update([
                        'total_cost' => $value->price_compra + $newExpensesValue,
                        'total_expenses' => $newExpensesValue,
                    ]);
            }
        }
        if (isset($params['show_detail'])) {
            dd("Done. ", $counter);
        } else {
            return;
        }
    }

    public function create(Request $request)
    {
        $params = $request->all();
        $reservation = null;
        $car = null;
        $taxation = null;
        $holder = null;
        $owner = null;
        $noUser = new \stdClass();
        $noUser->id = null;
        $noUser->name = "SIN DATO";
        $noUser->lastname = "";
        $users = [$noUser];
        $message = "Ingrese código de reserva para empezar una venta.";
        $messageClass = "default";
        if (isset($params['reservation_code'])) {
            $reservation = Reservation::whereNull(Reservation::TABLE_NAME . '.deleted_at')
                ->where(Reservation::TABLE_NAME . '.id', (int)$params['reservation_code'])
                ->where(Reservation::TABLE_NAME . '.flag_active', '=', Reservation::STATE_ACTIVE)
                ->with('client')
                ->orderBy(Reservation::TABLE_NAME . '.id', 'DESC')
                ->first();
            if (!is_null($reservation)) {
                // users
                $unitTime = ($reservation->reservation_time + $reservation->additional_time)/Reservation::DEFAULT_TIME; 
                $unitCost = $unitTime*$reservation->price_pr_hour;
                $reservation->pending_cost = $unitCost - $reservation->payment;
                $reservation->unit_time = $unitTime;
                $message = "La reserva fue encontrada";
                $messageClass = "success";
            } else {
                $message = "La reserva no está disponible para venta.";
                $messageClass = "warning";
            }
        }
        $rucs = Tax::whereNull(Tax::TABLE_NAME . '.deleted_at');
        if (!is_null($reservation)) {
            $rucs = $rucs->where('type', 1);
        } else {
            $rucs = $rucs->where('type', 2);
        }
        $rucs = $rucs->get();
            // ->withCount('amountperiod')
        foreach ($rucs as $key => $value) {
            $value->amount_pr_period = TaxController::getAmount(date("Ym"), $value->id, TAX::DEFAULT_SERIE_03);
        }
        return view(Sale::MODULE_NAME . '.create',  compact('reservation', 'rucs', 'car', 'taxation', 'holder', 'owner', 'message', 'messageClass', 'users'));
    }

    public function edit($saleId, Request $request)
    {
        $sale = Sale::find($saleId);
        $car = Car::with('expenses')->find($sale->cars_id);
        if (!is_null($sale) && !is_null($car)) {
            $car->total_expenses = $this->getTotalExpensesAmount($car->id);
            $car->total_cost = $car->price_compra + $car->total_expenses;
            $car->price_compra = (float)$car->price_compra;
            $car->price_sale = (float)$car->price_sale;
            $car->igv_amount = 0;
            $car->rent_amount = 0;
            // users
            $users = User::whereNull('deleted_at')->orderBy('name', 'ASC')->get();
            $noUser = new \stdClass();
            $noUser->id = 0;
            $noUser->name = "SIN DATO";
            $noUser->lastname = "";
            $users->push($noUser);
            // users
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
            $car->cost_without_taxes = $car->total_expenses - $car->igv_amount - $car->rent_amount;
            return view(Sale::MODULE_NAME . '.edit',  compact('sale', 'car', 'users'));
        } else {
            $message = "No se puede editar la venta.";
            $messageClass = "danger";
            return redirect()->route(Sale::MODULE_NAME . '.index')
                ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        }
    }

    public function updateSoldAtDate()
    {
        $sales = Sale::whereNull(Sale::TABLE_NAME . '.deleted_at')
            ->whereNotNull(Sale::TABLE_NAME . '.sale_date')
            ->get();
        $count = 0;

        foreach ($sales as $key => $value) {
            $car = Car::whereNull(Car::TABLE_NAME . '.sold_at')
                ->find($value->cars_id);
            if (!is_null($car) && $car->flag_active = Car::STATE_SOLD) {
                // start sold at
                if (!is_null($value->sale_date)) {
                    $soldDateFormat_ = explode('/', $value->sale_date);
                    $day = null;
                    $month = null;
                    $year = null;
                    if (isset($soldDateFormat_[0])) {
                        $day = $soldDateFormat_[0];
                    }
                    if (isset($soldDateFormat_[1])) {
                        $month = $soldDateFormat_[1];
                    }
                    if (isset($soldDateFormat_[2])) {
                        $year = $soldDateFormat_[2];
                    }
                    $soldDateFormat = null;
                    if (!is_null($day) && !is_null($month) && !is_null($year)) {
                        $soldDateFormat = Carbon::parse($year . "-" . $month . "-" . $day)->format('Y-m-d H:i:s');
                        if (!is_null($soldDateFormat)) {
                            $car->sold_at = $soldDateFormat;
                            $car->save();
                            $count++;
                        }
                    }
                }
                // end sold at
            }
        }

        return $count;
    }

    public function update($saleId, Request $request)
    {
        $params = $request->all();
        $sale = Sale::find($saleId);
        if (!is_null($sale)) {
            $clientParams = isset($params['clients']) ? $params['clients']['owner-from_id'] : null;
            if ($clientParams) {
                $params['sale']['clients_id'] = $clientParams;
            }
            $sale->fill($params['sale']);
            $sale->save();
            // cars
            $car = Car::find($sale->cars_id);
            if (!is_null($car)) {
                $car->company_owner = $params['company_owner'];
                // start sold at
                if (!is_null($sale->sale_date)) {
                    $soldDateFormat_ = explode('/', $sale->sale_date);
                    $day = null;
                    $month = null;
                    $year = null;
                    if (isset($soldDateFormat_[0])) {
                        $day = $soldDateFormat_[0];
                    }
                    if (isset($soldDateFormat_[1])) {
                        $month = $soldDateFormat_[1];
                    }
                    if (isset($soldDateFormat_[2])) {
                        $year = $soldDateFormat_[2];
                    }
                    $soldDateFormat = null;
                    if (!is_null($day) && !is_null($month) && !is_null($year)) {
                        $soldDateFormat = Carbon::parse($year . "-" . $month . "-" . $day)->format('Y-m-d H:i:s');
                        if (!is_null($soldDateFormat)) {
                            $car->sold_at = $soldDateFormat;
                        } else {
                            $car->sold_at = date('Y-m-d H:i:s');
                        }
                    }
                }
                // end sold at
                $car->save();
                // masters info
                $this->updateMasterInfo($car, $sale);
                // expenses
                $this->updateExpenses($car, $sale, $params);
                $message = "La venta se editó correctamente.";
                $messageClass = "success";
            } else {
                $message = "No se puede editar la venta.";
                $messageClass = "danger";
            }
        } else {
            $message = "No se puede editar la venta.";
            $messageClass = "danger";
        }
        return redirect()->route(Sale::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    private function getTotalExpensesAmount($carId)
    {
        // GASTOS
        $expenses = CarEntryExpense::select('expenses_json')
            ->whereNull(CarEntryExpense::TABLE_NAME . '.deleted_at')
            ->where(CarEntryExpense::TABLE_NAME . '.flag_active', CarEntryExpense::STATE_ACTIVE)
            ->where(CarEntryExpense::TABLE_NAME . '.cars_id', $carId)
            ->first();
        $totalExpenses = 0;
        if (!is_null($expenses) && !is_null($expenses->expenses_json)) {    
            foreach ($expenses->expenses_json as $key => $value) {
                if (!isset($value['exchange_rate'])) {
                    $value['exchange_rate'] = 1;
                }
                $totalExpenses = $totalExpenses + ((float)$value['value']/(float)$value['exchange_rate']);
            }
        }
        // FECHA DE INGRESO
        $car = Car::with('sale:id,sale_date,purchase_date,cars_id')->find($carId);
        $dateDiff = 0;
        if (!is_null($car)) {
            $registerDate = DateTime::createFromFormat('d/m/Y', $car->register_date);
            if ($registerDate) {
                if (!is_null($car->sale) && !is_null($car->sale->sale_date)) {
                    $todayDate = DateTime::createFromFormat('d/m/Y', $car->sale->sale_date);
                    $interval = date_diff($registerDate, $todayDate);
                    $dateDiff = $interval->format('%a');
                } else {
                    $todayDate = date_create('now');
                    $interval = date_diff($registerDate, $todayDate);
                    $dateDiff = $interval->format('%a');
                }
            }
        }
        // COSTO DIARIO
        $costPerDay = MsCostPerDay::whereNull(MsCostPerDay::TABLE_NAME . '.deleted_at')
            ->select(MsCostPerDay::TABLE_NAME . '.total')
            ->first();
        if (is_null($costPerDay)) {
            $costPerDay = 0;
        } else {
            $costPerDay = $costPerDay->total;
        }
        return round($costPerDay*$dateDiff + $totalExpenses);
    }

    public function apiStore(Request $request)
    {
        $params = $request->all();
        $client = ClientController::validateClientInfo($params['info']);
        $status = 400;
        $message = "No se puede proceder con la venta. Datos del cliente no son válidos.";
        if (!is_null($client)) {
            // total sale cost
            $totalSaleCost = 0;
            foreach ($params['items'] as $key => $value) {
                $totalSaleCost = $totalSaleCost + ((float)$value['quantity']*(float)$value['price']);
            }
            // validate document
            $taxValidation = TaxController::validateTaxAmount(date("Ym"), $params['info']['document_id'], $params['info']['type_document'], $totalSaleCost);
            if ($taxValidation) {
                // get reservation and update price per hour
                $reservation = null;
                if (isset($params['info']['reservation_id'])) {
                    $reservation = ReservationController::validateReservationInfo($params['info']);
                }
                // create sale
                $sale = new Sale();
                $sale->reservation_id = !is_null($reservation) ? $reservation->id : null;
                $sale->client_id = $client->id;
                $sale->document_id = $params['info']['document_id'];
                $sale->items = $params['items'];
                $sale->type_document = $params['info']['type_document'];
                $sale->serie = self::findSerie($params['info']['type_document']);
                $sale->correlative = self::findNextCorrelative($sale->document_id, $sale->serie);
                $sale->total_amount = $totalSaleCost;
                $sale->period = date("Ym");
                $sale->save();

                if (!is_null($reservation)) {
                    $unitTime = ($reservation->reservation_time + $reservation->additional_time)/Reservation::DEFAULT_TIME; 
                    $totalReservationCost = $unitTime*$reservation->price_pr_hour;
                    foreach ($params['items'] as $key => $value) {
                        if ((int)$value['id'] === Reservation::DEFAULT_PAYMENT_ID) {
                            // add payment to reservation
                            ReservationController::addPaymentToReservation($reservation, $totalReservationCost, $value['price']);
                        } else {
                            ProductController::findOrCreateProduct($value, true, $sale);
                        }
                    }
                } else {
                    foreach ($params['items'] as $key => $value) {
                        ProductController::findOrCreateProduct($value, true, $sale);
                    }
                }

                if (!is_null($sale)) {
                    $message = "La venta se creó correctamente. Pero no se creó el documento de facturación.";
                    $status = 200;
                    $responses_ = self::createFeDocument($sale->type_document, $sale);
                    if (!is_null($responses_)) {
                        $message = $responses_[0];
                        $status = $responses_[1];
                    }
                }
            } else {
                $message = "No se puede proceder con la venta. El monto excede el límite establecido del RUC por periodo.";
            }
        }

        return response([
            "message" => $message
        ], $status);
    }

    public function apiSalesByReservationId($reservationId = null)
    {
        $message = "No se pudo cargar la información de ventas. Inténtelo nuevamente.";
        $status = 400;
        $result = null;

        $list = Sale::whereNull(Sale::TABLE_NAME . '.deleted_at')
            ->where(Sale::TABLE_NAME . '.reservation_id', $reservationId)
            ->with('document')
            ->get();

        if (count($list) > 0) {
            $result = $list;
            $status = 200;
            $message = "Ventas cargadas correctamente.";
        } else {
            $status = 404;
            $message = "Esta reserva no cuenta con ventas.";
        }

        return response([
            "message" => $message,
            "result" => $result
        ], $status);
    }

    public static function getTotalSalesByPeriod($period, $canchaId = null)
    {
        $sales = Sale::whereNull(Sale::TABLE_NAME . '.deleted_at')
            ->where(Sale::TABLE_NAME . '.period', $period);
        if (!is_null($canchaId)) {
            # buscar por cancha id
        }
        $sales = $sales->get();

        return count($sales);
    }

    public static function createFeDocument($typeDocument = null, $sale = null)
    {
        $responses_ = null;
        switch ($typeDocument) {
            case Sale::SALE_TYPE_INVOICE_B:
                $requestParams = self::getBodyComprobanteBoleta($sale, "Boleta electrónica");
                if (!is_null($requestParams)) {
                    $request = HttpClient::withHeaders([
                        'Authorization' => 'Bearer ' . Auth::user()->access_token
                    ])->post(env('SUNAT_FE_API_URL') . 'boleta.php', $requestParams);
                    $responses_ = self::saveInfoRequest($sale, $request);
                }
                break;
            case Sale::SALE_TYPE_INVOICE_0:
                $requestParams = self::getBodyComprobanteBoleta($sale, "Ticket interno");
                if (!is_null($requestParams)) {
                    $request = HttpClient::withHeaders([
                        'Authorization' => 'Bearer ' . Auth::user()->access_token
                    ])->post(env('SUNAT_FE_API_URL') . 'boleta.php', $requestParams);
                    $responses_ = self::saveInfoRequest($sale, $request);
                }
                break;
            default:
                $requestParams = null;
                break;
        }

        return $responses_;
    }

    private static function getBodyComprobanteBoleta($sale, $printTitle = "Ticket interno")
    {
        $bodyComprobante = null;
        $taxInfo = $sale->document;
        if (!is_null($taxInfo)) {
            $total = (float)$sale->total_amount;
            $clientInfo = [
                "cliente_numerodocumento" => "88888888",
                "cliente_nombre" => "CLIENTE GENERICO",
                "cliente_tipodocumento" => "01",
                "cliente_direccion" => "--",
                "cliente_pais" => "PE",
                "cliente_ciudad" => "LIMA",
                "cliente_codigoubigeo" => "150101",
                "cliente_departamento" => "Lima",
                "cliente_provincia" => "Lima",
                "cliente_distrito" => "Lima",
            ];
            $client = $sale->client;
            if (!is_null($client)) {
                $clientInfo = [
                    "cliente_numerodocumento" => $client->document_number,
                    "cliente_nombre" => $client->name,
                    "cliente_tipodocumento" => $client->type_document,
                    "cliente_direccion" => "--",
                    "cliente_pais" => "PE",
                    "cliente_ciudad" => "LIMA",
                    "cliente_codigoubigeo" => "150101",
                    "cliente_departamento" => "Lima",
                    "cliente_provincia" => "Lima",
                    "cliente_distrito" => "Lima",
                ];
            }
            $bodyComprobante = [
                "pdf" => env("SUNAT_FE_CREAR_PDF"),
                "print_size" => env("SUNAT_FE_PRINT_SIZE"),
                "print_title" => $printTitle,
                "print_phone" => env("SUNAT_FE_PHONE"),
                "print_email" => env("SUNAT_FE_EMAIL"),
                "print_image" => env("SUNAT_FE_IMAGE"),
                "tipo_proceso" => env("SUNAT_FE_TIPO_PROCESO"),
                "tipo_operacion" => "0101",
                "total_gravadas" => round($total/1.18, 2),
                "total_inafecta" => "0",
                "total_exoneradas" => "0",
                "total_gratuitas" => "0",
                "total_exportacion" => "0",
                "total_descuento" => "0",
                "sub_total" => (round($total/1.18, 2)),
                "porcentaje_igv" => "18.00",
                "total_igv" => (round($total - $total/1.18, 2)),
                "total_isc" => "0",
                "total_otr_imp" => "0",
                "total" => $total,
                "total_letras" => "SON -- Y --/100 SOLES",
                "nro_guia_remision" => "--",
                "serie_comprobante" => $sale->serie,
                "numero_comprobante" => $sale->correlative,
                "fecha_comprobante" => date("Y-m-d"),
                "fecha_vto_comprobante" => date("Y-m-d"),
                "cod_tipo_documento" => $sale->type_document,
                "cod_moneda" => "PEN",
                "cliente_numerodocumento" => $clientInfo['cliente_numerodocumento'],
                "cliente_nombre" => $clientInfo['cliente_nombre'],
                "cliente_tipodocumento" => $clientInfo['cliente_tipodocumento'],
                "cliente_direccion" => $clientInfo['cliente_direccion'],
                "cliente_pais" => $clientInfo['cliente_pais'],
                "cliente_ciudad" => $clientInfo['cliente_ciudad'],
                "cliente_codigoubigeo" => $clientInfo['cliente_codigoubigeo'],
                "cliente_departamento" => $clientInfo['cliente_departamento'],
                "cliente_provincia" => $clientInfo['cliente_provincia'],
                "cliente_distrito" => $clientInfo['cliente_distrito'],
                "emisor" => $taxInfo->emisor_json,
                "detalle" => []
            ];
            $itemsCount = 1; 
            foreach ($sale->items as $key => $value) {
                $price = (float)($value['price']);
                $subtotal = ((float)($value['price']) / 1.18);
                $taxes = $price - $subtotal;
                $detail = [
                    "txtITEM" => $itemsCount++,
                    "txtUNIDAD_MEDIDA_DET"      => "NIU",
                    "txtCANTIDAD_DET"           => (string)((int)$value['quantity']),
                    "txtPRECIO_DET"             => round($price, 2),
                    "txtSUB_TOTAL_DET"          => round($subtotal, 2),
                    "txtPRECIO_TIPO_CODIGO"     => "01",
                    "txtIGV"                 	=> round($taxes*(int)$value['quantity'], 2),
                    "txtISC"                  	=> "0",
                    "txtIMPORTE_DET"            => round($subtotal*(int)$value['quantity'], 2),
                    "txtCOD_TIPO_OPERACION"     => "10",
                    "txtCODIGO_DET"             => "531015",
                    "txtDESCRIPCION_DET"        => $value['name'],
                    "txtPRECIO_SIN_IGV_DET"     => round($subtotal*(int)$value['quantity'], 2)
                ];
                array_push($bodyComprobante['detalle'], $detail);
            }
        }
        $sale->fe_request = $bodyComprobante;
        $sale->save();
        return $bodyComprobante;
    }

    private static function saveInfoRequest($sale, $request)
    {
        if (!is_null($request) && $request->successful()) {
            $message = "Comprobante emitido correctamente. Hubo respuesta directa";
            $httpCode = 200;
            $result = $request->json();
            $sale->fe_response = $result;
            $sale->fe_status_code = 1;
            $sale->fe_url_pdf = str_replace('..', env('SUNAT_FE_WEB_URL'), $result['ruta_pdf']);
            $sale->save();
        } else {
            $message = "Comprobante emitido correctamente. No hubo respuesta directa.";
            $httpCode = 200;
            $sale->fe_response = null;
            $sale->fe_status_code = 0;
            $sale->save();
        }

        return [$message, $httpCode];
    }

    public static function findSerie($typeDocument = null)
    {
        $serie = null;
        switch ($typeDocument) {
            case '00':
                $serie = Tax::DEFAULT_SERIE_00;
                break;
            case '03':
                $serie = Tax::DEFAULT_SERIE_03;
                break;
            
            default:
                # code...
                break;
        }
        
        return $serie;
    }

    public static function findNextCorrelative($documentId = null, $serie = null)
    {
        # code...
        $correlative = 1;
        $lastSale = Sale::select(Sale::TABLE_NAME . '.correlative')
            ->whereNull(Sale::TABLE_NAME . '.deleted_at')
            ->where(Sale::TABLE_NAME . '.document_id', $documentId)
            ->where(Sale::TABLE_NAME . '.serie', $serie)
            ->orderBy(Sale::TABLE_NAME . '.correlative', 'desc')
            ->first();        
        if (!is_null($lastSale)) {
            $correlative = $lastSale->correlative + 1;
        }
        return $correlative;
    }
    
    public function store(Request $request)
    {
        $params = $request->all();
        // ARCHIVOS DE VENTA
        $message = "La venta se creó correctamente.";
        $messageClass = "success";
        // CLIENTE
        $client = null;
        $clientParams = isset($params['clients']['owner-from_id']) ? $params['clients']['owner-from_id'] : null;
        if ($clientParams) {
            $client = Client::find($clientParams);
        }
        if (is_null($client)) {
            $clientParams = isset($params['clients']) ? $params['clients']['owner'] : null;
            if ($clientParams) {
                $client = Client::whereNull(Client::TABLE_NAME . '.deleted_at')
                    ->where(Client::TABLE_NAME . '.document_number', $clientParams['document_number'])
                    ->first();
                if (is_null($client)) {
                    unset($clientParams['id']);
                    $clientParams['created_by'] = Auth::user()->id;
                    $clientParams['name'] = self::generateNameValue($clientParams);
                    $client = Client::create($clientParams);
                }
            }
        }
        // venta
        $saleParams = isset($params['sale']) ? $params['sale'] : null;
        if ($saleParams) {
            $saleParams['created_by'] = Auth::user()->id;
            $saleParams['taxations_id'] = 0;
            $saleParams['clients_id'] = $client->id;
            if (is_null($saleParams['document_number'])) {
                $saleParams['document_number'] = 0;
            }
            $sale = Sale::create($saleParams);
            if (!is_null($sale)) {
                // ESTADO DEL VEHICULO
                $car = Car::find($sale->cars_id);
                if (!is_null($car)) {
                    $car->updated_by = Auth::user()->id;
                    $car->flag_active = Car::STATE_SOLD;
                    // start sold at
                    if (isset($sale->sale_date)) {
                        $soldDateFormat_ = explode('/', $sale->sale_date);
                        $day = null;
                        $month = null;
                        $year = null;
                        if (isset($soldDateFormat_[0])) {
                            $day = $soldDateFormat_[0];
                        }
                        if (isset($soldDateFormat_[1])) {
                            $month = $soldDateFormat_[1];
                        }
                        if (isset($soldDateFormat_[2])) {
                            $year = $soldDateFormat_[2];
                        }
                        if (!is_null($day) && !is_null($month) && !is_null($year)) {
                            $soldDateFormat = Carbon::parse($year . "-" . $month . "-" . $day)->format('Y-m-d H:i:s');
                            if (!is_null($soldDateFormat)) {
                                $car->sold_at = $soldDateFormat;
                            } else {
                                $car->sold_at = date('Y-m-d H:i:s');
                            }
                        }
                    }
                    // end sold at
                    $car->save();
                    // ACTUALIZAR GASTOS
                    $this->updateExpenses($car, $sale, $params);
                } else {
                    $sale->deleted_at = now("Y-m-d H:i:s");
                    $sale->save();
                    $message = "No se pudo crear la venta por que el vehículo no tiene el proceso de creación adecuado.";
                    $messageClass = "danger";
                }
                // ARCHIVOS DE VENTA
                $fileParams = isset($params['files_json']) ? $params['files_json'] : null;
                if ($fileParams) {
                    $documents = [];
                    foreach ($fileParams as $key => $value) {
                        if (isset($value['value'])) {
                            $fileName = time() . '.' . $value['value']->extension();
                            $value['value']->move(public_path('sale_documents/' . $sale->id . '/'), $fileName);
                            $documents['name'] = $value['name'];
                            $documents['value'] = 'sale_documents/' . $sale->id . '/' . $fileName;
                        }
                    }
                    $sale->files_json = $documents;
                    $sale->save();
                }
                // response
                $message = "La venta se creó correctamente.";
                $messageClass = "success";
            } else {
                $message = "No se pudo crear la venta.";
                $messageClass = "danger";
            }
        } else {
            $message = "No se pudo crear la venta.";
            $messageClass = "danger";
        }
        return redirect()->route(Sale::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    private function updateExpenses($car, $sale, $params)
    {
        // ACTUALIZAR GASTOS
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
                        $valueEJ['detail'] = "IGV SOBRE: " . $params['expenses']['igv_detail'];
                    }
                    if ($valueEJ['tag'] === "RENT") {
                        $valueEJ['value'] = (float)$params['expenses']['rent'];
                        $valueEJ['detail'] = "RENTA SOBRE: " . $sale->total_invoiced;
                    }
                } elseif (isset($valueEJ['name'])) {
                    if ($valueEJ['name'] === "IGV") {
                        $valueEJ['value'] = (float)$params['expenses']['igv'];
                        $valueEJ['detail'] = "IGV SOBRE: " . $params['expenses']['igv_detail'];
                    }
                    if ($valueEJ['name'] === "RENTA") {
                        $valueEJ['value'] = (float)$params['expenses']['rent'];
                        $valueEJ['detail'] = "RENTA SOBRE: " . $sale->total_invoiced;
                    }
                }
                array_push($newExpenses, $valueEJ);
            }
            $expenses->expenses_json = $newExpenses;
            $expenses->save();
        }
    }

    private static function updateMasterInfo($car, $sale) : void
    {
        // CLIENTS
        ClientController::findAndStore($car->owner, 'owner', $car, 'owner_id');
        MsMasterController::findAndStore($car->company_owner, 'company_owner', null, null, $car, null);
        // MsMasterController::findAndStore($sale->notary, 'notary', null, null, $sale, 'notary_id');
    }

    private static function generateNameValue($params = [])
    {
        $stringName = null;
        if (isset($params['type'])) {
            switch ((int)$params['type']) {
                case 1:
                    # PERSONA NATURAL
                    $stringName = $params['names'] . " " . $params['first_lastname'] . " " . $params['second_lastname'];
                    break;
                case 2:
                    # EMPRESA
                    $stringName = $params['rz_social'] . " " . $params['commercial_name'];
                    break;
                
                default:
                    # code...
                    break;
            }
        }

        return $stringName;
    }
}
