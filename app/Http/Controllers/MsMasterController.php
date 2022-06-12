<?php

namespace App\Http\Controllers;

use App\Models\MsMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MsMasterController extends Controller
{
    /**
     * Display a listing of the MsMasters
     *
     * @param  \App\Models\MsMaster  $model
     * @return \Illuminate\View\View
     */
    public function indexApi(Request $request)
    {
        $responseStatus = 200;
        $requestedName = $request->query('name', '');
        $requestedTag = $request->query('tag', '');
        $requestedMsMastersId = $request->query('ms_masters_id', 0);
        $requestedParent = $request->query('parent', null);
        $requestedParentTag = $request->query('parent_tag', null);
        if (!is_null($requestedParent) && !is_null($requestedParentTag)) {
            $msParent = MsMaster::whereNull(MsMaster::TABLE_NAME . '.deleted_at')
                ->where(MsMaster::TABLE_NAME . '.name', $requestedParent)
                ->where(MsMaster::TABLE_NAME . '.tag', $requestedParentTag)
                ->first();
            if (!is_null($msParent)) {
                $requestedMsMastersId = $msParent->id;
            }
        }
        $list = MsMaster::whereNull(MsMaster::TABLE_NAME . '.deleted_at')
            ->where(MsMaster::TABLE_NAME . '.ms_masters_id', $requestedMsMastersId)
            ->where(MsMaster::TABLE_NAME . '.name', 'LIKE', '%' . $requestedName . '%')
            ->where(MsMaster::TABLE_NAME . '.tag', 'LIKE', '%' . $requestedTag . '%')
            ->get();

        if ($list->count() === 0) {
            $responseStatus = 404;
        }
        return response($list, $responseStatus);
    }

    public function create(Request $request)
    {
        return response([]);
    }

    public static function findAndStore($name, $tag, $parent = null, $tagParent = null, $foreignObject = null, $foreignKey = null)
    {
        $msMaster = null;
        $msParent = null;
        if (!is_null($name)) {
            if (!is_null($parent) && !is_null($tagParent)) {
                $msParent = self::searchLogic($parent, $tagParent);
                if (!is_null($msParent)) {
                    $msMaster = self::searchLogic($name, $tag, $msParent->id);
                    if (is_null($msMaster)) {
                        $msMaster = self::createLogic($name, $tag, $msParent->id);
                    }
                }
            } else {
                $msMaster = self::searchLogic($name, $tag);
                if (is_null($msMaster)) {
                    $msMaster = self::createLogic($name, $tag);
                }
            }
            self::saveOnForeignObject($msMaster, $foreignObject, $foreignKey);
        }
        return $msMaster;
    }

    private static function createLogic($name, $tag, $tagParent = 0)
    {
        $msMaster = new MsMaster();
        $msMaster->created_by = Auth::user()->id;
        $msMaster->tag = $tag;
        $msMaster->name = $name;
        $msMaster->ms_masters_id = $tagParent;
        $msMaster->save();
        return $msMaster;
    }

    private static function searchLogic($name, $tag, $tagParent = null)
    {
        $msMaster = MsMaster::whereNull(MsMaster::TABLE_NAME . '.deleted_at')
            ->where(MsMaster::TABLE_NAME . '.tag', $tag)
            ->where(MsMaster::TABLE_NAME . '.name', $name);
            if (!is_null($tagParent)) {
                $msMaster = $msMaster->where(MsMaster::TABLE_NAME . '.ms_masters_id', $tagParent);
            }
        return $msMaster->first();
    }

    private static function saveOnForeignObject($msMaster, $foreignObject = null, $foreignKey = null) : void
    {
        if (!is_null($foreignObject) && !is_null($foreignKey)) {
            if (!is_null($msMaster) && is_null($foreignObject->$foreignKey)) {
                $foreignObject->$foreignKey = $msMaster->id;
                $foreignObject->save();
            }
        }
    }

    public function edit($id)
    {
        return response([]);
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $object = MsMaster::create($params);
        return response($object);
    }

    public function update($id, Request $request)
    {
        $params = $request->all();
        $object = MsMaster::find($id);
        if (!is_null($object)) {
            $params['updated_by'] = Auth::user()->id;
            $object->fill($params);
            $object->save();
            return response($object);
        } else {
            return response($object, 400);
        }
    }

    public function destroy($id, Request $request)
    {
        $object = MsMaster::find($id);
        if (!is_null($object)) {
            $object->deleted_by = Auth::user()->id;
            $object->flag_active = MsMaster::STATE_INACTIVE;
            $object->deleted_at = date("Y-m-d H:i:s");
            $object->save();
            return response($object);
        } else {
            return response($object, 400);
        }
    }

    public function show($id, Request $request)
    {
        $object = MsMaster::find($id);
        if (!is_null($object)) {
            return response($object);
        } else {
            return response($object, 404);
        }
    }
}
