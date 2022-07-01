<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxController extends Controller
{
    /**
     * Display a listing of the cars
     *
     * @param  \App\Models\Car  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $list = [];
        $status = 1;
        return view(Tax::MODULE_NAME . '.index', compact('list', 'status'));
    }

    public function apiIndex(Request $request)
    {
        $params = $request->all();
        // car list
        $status = 1;
        $list = Tax::whereNull(Tax::TABLE_NAME . '.deleted_at');

        if (isset($params['search']) && isset($params['search']['value'])) {
            $key = $params['search']['value'];
            $list = $list->where(function($query) use ($key){
                $query->where(Tax::TABLE_NAME . '.category', 'LIKE', '%' . $key . '%');
                $query->orWhere(Tax::TABLE_NAME . '.brand', 'LIKE', '%' . $key . '%');
                $query->orWhere(Tax::TABLE_NAME . '.name', 'LIKE', '%' . $key . '%');
                $query->orWhere(Tax::TABLE_NAME . '.description', 'LIKE', '%' . $key . '%');
                $query->orWhere(Tax::TABLE_NAME . '.type_tax', 'LIKE', '%' . $key . '%');
                $query->orWhere(Tax::TABLE_NAME . '.flag_active', 'LIKE', '%' . $key . '%');
            });
        }

        if (isset($params['order'])) {
            $array_order = Tax::ARRAY_ORDER;
            $list = $list->orderBy(Tax::TABLE_NAME . 
                $array_order[$params['order'][0]['column']], 
                $params['order'][0]['dir']);
        } else {
            $list = $list->orderBy(Tax::TABLE_NAME . '.id', 'DESC');
        }
        
        $list = $list->paginate(env('ITEMS_PAGINATOR'));
        return response($list, 200);
    }

    public function create(Request $request)
    {
        $params = $request->all();
        $tax = null;
        $message = "Si desea, puede crear un RUC a partir de una tasación.";
        $messageClass = "default";
        // users
        $users = User::whereNull('deleted_at')->orderBy('name', 'ASC')->get();
        $userId = Auth::user()->id;
        return view(Tax::MODULE_NAME . '.create', compact('tax', 'message', 'messageClass', 'users', 'userId'));
    }

    public function edit($id)
    {
        $tax = Tax::find($id);
        if (!is_null($tax)) {
            return view(Tax::MODULE_NAME . '.edit', compact('tax'));
        } else {
            $message = "El RUC no fue encontrado.";
            $messageClass = "danger";
            return redirect()->route(Tax::MODULE_NAME . '.index')
                ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        }
    }

    public function store(Request $request)
    {
        $params = $request->all();
        # buscar RUC por código
        if (isset($params['document_number'])) {
            $taxByCode = self::findTaxByCode(strtoupper($params['document_number']));
            if (!is_null($taxByCode)) {
                $message = "El RUC no se pudo registar. El número de documento ya existe.";
                $messageClass = "danger";
                return redirect()->route(Tax::MODULE_NAME . '.index')
                    ->with( ['message' => $message, 'messageClass' => $messageClass ] );
            }
        }
        # crear RUC
        $tax = Tax::create($params);
        $message = "El RUC se creó correctamente.";
        $messageClass = "success";
        # validar creación
        if (is_null($tax)) {
            $message = "El RUC no se pudo crear.";
            $messageClass = "danger";
        }
        # respuesta
        return redirect()->route(Tax::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function update($id, Request $request)
    {
        $params = $request->all();
        $tax = Tax::find($id);
        if (!is_null($tax)) {
            // masters logic
            $tax->fill($params);
            $tax->save();
            $message = "El RUC se actualizó correctamente.";
            $messageClass = "success";
        } else {
            $message = "El RUC no fue encontrado.";
            $messageClass = "danger";
        }
        return redirect()->route(Tax::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function destroy($id, Request $request)
    {
        $tax = Tax::find($id);
        if (!is_null($tax)) {
            $tax->deleted_by = Auth::user()->id;
            $tax->flag_active = Tax::STATE_DELETE;
            $tax->deleted_at = date("Y-m-d H:i:s");
            $tax->save();
            $message = "El RUC se eliminó correctamente.";
            $messageClass = "success";
        } else {
            $message = "El RUC no fue encontrado.";
            $messageClass = "danger";
        }
        return redirect()->route(Tax::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public static function getAmount($period = null, $taxId = null, $serie = null)
    {
        # search on sales by period and serie
        return random_int(3200, 7800);
    }

    public static function validateTaxAmount($period = null, $taxId = null, $serie = null, $amount = 0)
    {
        $result = false;
        $tax = Tax::whereNull(Tax::TABLE_NAME . '.deleted_at')
            ->find($taxId);        
        if (!is_null($tax)) {
            $taxAmount = self::getAmount($period, $taxId, $serie);
            $newTaxAmount = $amount + $taxAmount;
            if ($serie === "03") {
                if ((float)$newTaxAmount <= (float)$tax->top) {
                    $result = true;
                }
            } else {
                $result = true;
            }
        }

        return $result;
    }

    public function apiDestroy($id, Request $request)
    {
        $tax = Tax::find($id);
        if (!is_null($tax)) {
            $tax->flag_active = Tax::STATE_DELETE;
            $tax->deleted_at = date("Y-m-d H:i:s");
            $tax->save();
            $message = "El RUC se eliminó correctamente.";
            $messageClass = "success";
            $httpStatus = 200;
        } else {
            $message = "El RUC no fue encontrado.";
            $messageClass = "danger";
            $httpStatus = 400;
        }
        return response( ['message' => $message, 'messageClass' => $messageClass ], $httpStatus );
    }

    public function show($id, Request $request)
    {
        return "show method";
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

    private static function findTaxByCode($code) {
        $tax = Tax::whereNull(Tax::TABLE_NAME . '.deleted_at')
            ->where(Tax::TABLE_NAME . '.flag_active', Tax::STATE_ACTIVE)
            ->where(Tax::TABLE_NAME . '.document_number', $code)
            ->first();
        return $tax;
    }
}
