<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProductController;

class HomeController extends Controller
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
    public function index(Request $request)
    {
        $info = [
            'filter_date' => "Periodo " . date("M") . " del " .  date("Y"),
            'sales' => SaleController::getTotalSalesByPeriod(date("Ym")),
            'reservations' => ReservationController::getTotalReservationsByPeriod(date("Y-m")),
            'products' => ProductController::getTotalProducts()
        ];
        if (Auth()->user()->rols_id === 1) {
            return view('dashboard', compact('info'));
        } else {
            return view('dashboard_2', compact('info'));
        }
    }
}
