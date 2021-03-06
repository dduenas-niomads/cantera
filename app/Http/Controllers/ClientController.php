<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the clients
     *
     * @param  \App\Models\Client  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth()->user();
        $clientList = Client::whereNull(Client::TABLE_NAME . '.deleted_at')
            ->where(Client::TABLE_NAME . '.pos_companies_id', $user->pos_companies_id);
        // if ($user->rolls_id !== 1) {
        //     $clientList = $clientList->where(Client::TABLE_NAME . '.cancha_id', $user->cancha_id);
        // }
        $clientList = $clientList->get();
        $typeDocumentNames = Client::TYPE_DOCUMENT_NAMES;
        return view(Client::MODULE_NAME . '.index', compact('clientList', 'typeDocumentNames'));
    }
    
    public function indexApi(Request $request)
    {
        $responseStatus = 200;
        $user = Auth()->user();
        $params = $request->all();
        $requestedName = $request->query('name', '');
        $list = Client::whereNull(Client::TABLE_NAME . '.deleted_at')
            ->where(Client::TABLE_NAME . '.pos_companies_id', $user->pos_companies_id);
        if (isset($params['type_document'])) {
            $list = $list->where(Client::TABLE_NAME . '.type_document', $params['type_document']);
        }
        if (isset($params['document_number'])) {
            $list = $list->where(Client::TABLE_NAME . '.document_number', $params['document_number']);
        }
        $list = $list->where(function($query) use ($requestedName){
            $query->where(Client::TABLE_NAME . '.names', 'LIKE', '%' . $requestedName . '%');
            $query->orWhere(Client::TABLE_NAME . '.first_lastname', 'LIKE', '%' . $requestedName . '%');
            $query->orWhere(Client::TABLE_NAME . '.second_lastname', 'LIKE', '%' . $requestedName . '%');
            $query->orWhere(Client::TABLE_NAME . '.rz_social', 'LIKE', '%' . $requestedName . '%');
            $query->orWhere(Client::TABLE_NAME . '.commercial_name', 'LIKE', '%' . $requestedName . '%');
            $query->orWhere(Client::TABLE_NAME . '.document_number', 'LIKE', '%' . $requestedName . '%');
        });
        $list = $list->get();

        if ($list->count() === 0) {
            $responseStatus = 404;
        }
        return response($list, $responseStatus);
    }

    public function create()
    {
        return view(Client::MODULE_NAME . '.create_new');
    }

    public function edit($id)
    {
        $client = Client::find($id);
        if (!is_null($client)) {
            return view(Client::MODULE_NAME . '.edit', compact('client'));
        } else {
            $message = "El cliente no fue encontrado.";
            $messageClass = "danger";
            return redirect()->route(Client::MODULE_NAME . '.index')
                ->with( ['message' => $message, 'messageClass' => $messageClass ] );
        }
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $user = Auth::user();
        $params['created_by'] = $user->id;
        $params['name'] = self::generateNameValue($params);
        $params['pos_companies_id'] = $user->pos_companies_id;
        $client = Client::create($params);
        $message = "El cliente se registr?? correctamente.";
        $messageClass = "success";
        if (!is_null($client)) {
            // MASTER INFO
            self::updateMasterInfo($client);
        } else {
            $message = "El cliente no se pudo registar.";
            $messageClass = "danger";
        }
        return redirect()->route(Client::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function update($id, Request $request)
    {
        $params = $request->all();
        $client = Client::find($id);
        if (!is_null($client)) {
            $params['updated_by'] = Auth::user()->id;
            $params['name'] = self::generateNameValue($params);
            $client->fill($params);
            $client->save();
            // MASTER INFO
            self::updateMasterInfo($client);
            $message = "La informaci??n se actualiz?? correctamente.";
            $messageClass = "success";
        } else {
            $message = "El cliente no fue encontrado.";
            $messageClass = "danger";
        }
        return redirect()->route(Client::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function destroy($id, Request $request)
    {
        $client = Client::find($id);
        if (!is_null($client)) {
            $client->deleted_by = Auth::user()->id;
            $client->flag_active = Client::STATE_INACTIVE;
            $client->deleted_at = date("Y-m-d H:i:s");
            $client->save();
            $message = "El cliente se elimin?? correctamente.";
            $messageClass = "success";
        } else {
            $message = "El cliente no fue encontrado.";
            $messageClass = "danger";
        }
        return redirect()->route(Client::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    public function show($id, Request $request)
    {
        return "show method";
    }

    public function showReport(Request $request)
    {
        $clientList = Client::whereNull(Client::TABLE_NAME . '.deleted_at')
            ->with('purchases')
            ->get();
        $typeDocumentNames = Client::TYPE_DOCUMENT_NAMES;
        return view(Client::MODULE_NAME . '.report', compact('clientList', 'typeDocumentNames'));
    }

    public static function findAndStore($name, $tag, $foreignObject = null, $foreignKey = null)
    {
        $client = null;
        if (!is_null($name)) {
            $client = self::searchLogic($name, $tag, $foreignObject, $foreignKey);
            if (is_null($client)) {
                $client = self::createLogic($name, $tag, $foreignObject, $foreignKey);
            }
            self::saveOnForeignObject($client, $foreignObject, $foreignKey);
        }
        return $client;
    }

    public static function getTotalClients($canchaId = null)
    {
        $clients = Client::whereNull(Client::TABLE_NAME . '.deleted_at')
            ->where(Client::TABLE_NAME . '.pos_companies_id', Auth()->user()->pos_companies_id)
            ->where(Client::TABLE_NAME . '.flag_active', Client::STATE_ACTIVE);
        if (!is_null($canchaId)) {
            # buscar por cancha id
        }
        $clients = $clients->get();

        return count($clients);
    }

    public static function validateClientInfo($params = [])
    {
        $client = null;

        if (isset($params['client_id'])) {
            $client = Client::find((int)$params['client_id']);
            if (!is_null($client)) {
                $client->type_document = $params['client_type_document'];
                $client->document_number = $params['client_document_number'];
                $client->name = $params['client_name'];
                $client->email = $params['client_email'];
                $client->save();
            }
        }
        if (is_null($client)) {
            $client = new Client();
            $client->type_document = $params['client_type_document'];
            $client->document_number = $params['client_document_number'];
            $client->name = $params['client_name'];
            $client->email = $params['client_email'];
            $client->pos_companies_id = Auth()->user()->pos_companies_id;
            $client->save();
        }
        
        return $client;
    }

    private static function createLogic($name, $tag, $foreignObject = null, $foreignKey = null)
    {
        $client = new Client();
        $client->created_by = Auth::user()->id;
        $client->tag = $tag;
        $client->name = $name;
        $client->names = $name;
        $client->save();
        return $client;
    }

    private static function searchLogic($name, $tag, $foreignObject = null, $foreignKey = null)
    {
        $client = null;
        // caso 1: foreign_id != null
        if (!is_null($foreignObject) && !is_null($foreignKey)) {
            if (!is_null($foreignObject->$foreignKey)) {
                $client = Client::whereNull(Client::TABLE_NAME . '.deleted_at')
                    ->find((int)$foreignObject->$foreignKey);
            }
        }
        // caso 2: ms no asociado (foreign_id null)
        if(is_null($client)) {
            $client = Client::whereNull(Client::TABLE_NAME . '.deleted_at')
                ->where(Client::TABLE_NAME . '.tag', $tag)
                ->where(Client::TABLE_NAME . '.name', 'LIKE', '%' . $name . '%')
                ->first();
        }
        return $client;
    }

    private static function saveOnForeignObject($client, $foreignObject = null, $foreignKey = null) : void
    {
        if (!is_null($foreignObject) && !is_null($foreignKey)) {
            if (!is_null($client) && is_null($foreignObject->$foreignKey)) {
                $foreignObject->$foreignKey = $client->id;
                $foreignObject->save();
            }
        }
    }

    private static function updateMasterInfo($client) : void
    {
        // MASTERS
        MsMasterController::findAndStore($client->department, 'department', null, null, $client, 'department_id');
        MsMasterController::findAndStore($client->province, 'province', $client->department, 'department', $client, 'province_id');
        MsMasterController::findAndStore($client->district, 'district', $client->province, 'province', $client, 'district_id');
    }

    public static function callPrivateFunction($functionName, $params = [])
    {
        return self::$functionName($params);
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
