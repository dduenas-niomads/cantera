<?php

namespace App\Http\Controllers;

use App\Models\MsCostPerDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MsCostPerDayController extends Controller
{
    /**
     * MsCostPerDay module
     *
     * @param  \App\Models\MsCostPerDay  $model
     * @return \Illuminate\View\View
     */
    public function editCostPerDay()
    {
        $costPerDay = MsCostPerDay::whereNull(MsCostPerDay::TABLE_NAME . '.deleted_at')->first();
        if (!is_null($costPerDay)) {
            return view('cost_per_day.edit', compact('costPerDay'));
        } else {
            return view('cost_per_day.create_new', compact('costPerDay'));
        }
    }
    public function storeCostPerDay(Request $request)
    {
        $params = $request->all();
        if (isset($params['expenses_json'])) {
            $params['total'] = 0;
            foreach ($params['expenses_json'] as $key => $value) {
                $params['total'] = $params['total'] + (float)$value['value'];
            }
            $costPerDay = MsCostPerDay::create($params);
            $message = "Costo diario vehicular registrado correctamente.";
            $messageClass = "success";
            return view('cost_per_day.edit', compact('costPerDay', 'message', 'messageClass'));
        } else {
            $message = "No se pudo registrar. Debe ingresar gastos.";
            $messageClass = "danger";
            return view('cost_per_day.create_new', compact('costPerDay', 'message', 'messageClass'));
        }
    }
    public function updateCostPerDay(Request $request)
    {
        $params = $request->all();
        $costPerDay = MsCostPerDay::whereNull(MsCostPerDay::TABLE_NAME . '.deleted_at')->first();
        if (!is_null($costPerDay)) {
            $params['total'] = 0;
            foreach ($params['expenses_json'] as $key => $value) {
                $params['total'] = $params['total'] + (float)$value['value'];
            }
            $costPerDay->fill($params);
            $costPerDay->save();
            $message = "Costo diario vehicular actualizado correctamente.";
            $messageClass = "success";
            return view('cost_per_day.edit', compact('costPerDay', 'message', 'messageClass'));
        } else {
            $message = "No se pudo registrar. Debe ingresar gastos.";
            $messageClass = "danger";
            return view('cost_per_day.create_new', compact('costPerDay', 'message', 'messageClass'));
        }
    }
}