<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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
        return view(Product::MODULE_NAME . '.index', compact('list', 'status'));
    }

    public function apiIndex(Request $request)
    {
        $params = $request->all();
        // car list
        $status = 200;
        $list = Product::whereNull(Product::TABLE_NAME . '.deleted_at');

        if (isset($params['name'])) {
            $params['search'] = [
                "value" => $params['name']
            ];
        }

        if (isset($params['search']) && isset($params['search']['value'])) {
            $key = $params['search']['value'];
            $list = $list->where(function($query) use ($key){
                $query->where(Product::TABLE_NAME . '.category', 'LIKE', '%' . $key . '%');
                $query->orWhere(Product::TABLE_NAME . '.brand', 'LIKE', '%' . $key . '%');
                $query->orWhere(Product::TABLE_NAME . '.name', 'LIKE', '%' . $key . '%');
                $query->orWhere(Product::TABLE_NAME . '.description', 'LIKE', '%' . $key . '%');
                $query->orWhere(Product::TABLE_NAME . '.type_product', 'LIKE', '%' . $key . '%');
                $query->orWhere(Product::TABLE_NAME . '.flag_active', 'LIKE', '%' . $key . '%');
            });
        }

        if (isset($params['order'])) {
            $array_order = Product::ARRAY_ORDER;
            $list = $list->orderBy(Product::TABLE_NAME . 
                $array_order[$params['order'][0]['column']], 
                $params['order'][0]['dir']);
        } else {
            $list = $list->orderBy(Product::TABLE_NAME . '.id', 'DESC');
        }

        if (isset($params['tag']) && $params['tag'] === 'autocomplete') {
            $list = $list->get();
            if (count($list) === 0) {
                $status = 404;
            }
        } else {
            $list = $list->paginate(env('ITEMS_PAGINATOR'));
        }
        
        return response($list, $status);
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

    public static function getTotalProducts($canchaId = null)
    {
        $products = Product::whereNull(Product::TABLE_NAME . '.deleted_at')
            ->where(Product::TABLE_NAME . '.flag_active', Product::STATE_ACTIVE);
        if (!is_null($canchaId)) {
            # buscar por cancha id
        }
        $products = $products->get();

        return count($products);
    }

    public static function findOrCreateProduct($params = [], $kardex = true, $sale = null)
    {
        $product = null;
        if (is_null($params['id'])) {
            $product = self::createProductStatic($params);
            if (!is_null($product) && $kardex) {
                # grabar entrada y salida de mercaderia
                MovementController::createMovement($params, $sale, 1, "INGRESO POR VENTA");
                MovementController::createMovement($params, $sale);
            }
        } else {
            $product = self::findProductById($params['id']);
            if (!is_null($product) && $kardex) {
                # grabar salida de mercaderia
                MovementController::createMovement($params, $sale);
            }
        }
    }

    public static function findProductById($productId = null)
    {
        $product = Product::whereNull(Product::TABLE_NAME . '.deleted_at')
            ->find($productId);        
        return $product;
    }

    public static function createProductStatic($params = [])
    {
        $product = null;
        if (isset($params['code'])) {
            $product = self::findProductByCode(strtoupper($params['code']));
            if (is_null($product)) {
                if (isset($params['price'])) {
                    $params['price_sale'] = $params['price'];
                }
                $product = Product::create($params);
            }
        }
        return $product;
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
            $message = "El producto se eliminó correctamente.";
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
        $product = Product::find($id);
        if (!is_null($product)) {
            $product->flag_active = Product::STATE_DELETE;
            $product->deleted_at = date("Y-m-d H:i:s");
            $product->save();
            $message = "El producto se eliminó correctamente.";
            $messageClass = "success";
            $httpStatus = 200;
        } else {
            $message = "El producto no fue encontrado.";
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

    private static function findProductByCode($code) {
        $product = Product::whereNull(Product::TABLE_NAME . '.deleted_at')
            ->where(Product::TABLE_NAME . '.flag_active', Product::STATE_ACTIVE)
            ->where(Product::TABLE_NAME . '.code', $code)
            ->first();
        return $product;
    }
}
