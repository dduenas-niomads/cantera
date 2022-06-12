<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generateConcatRow($arrayKeys, $name = "name")
    {
        $keysName = "";
        foreach ($arrayKeys as $key => $value) {
            $keysName .= $value . ",' ',"; 
        }
        return "CONCAT(" . substr_replace($keysName ,"", -1) . ") as " . $name;
    }

    public function createCarbonFromDate($params = [], $date = null)
    {
        if (!is_null($date)) {
            return Carbon::parse($date)->tz('America/Lima');
        } else {
            return Carbon::parse($params['reservation_date'] . ' ' . $params['reservation_hour_hh'] . ":" . $params['reservation_hour_mm'] . ":00 " . $params['reservation_hour_ampm'])->tz('America/Lima');
        }
    }
}
