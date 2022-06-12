<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\CarEntryDetail;
use App\Models\MsMaster;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cars = [];
        $brands = self::getBrandsWithCarsCount();
        $models = self::getMsMaster('model');

        return view('store.index', compact('cars', 'brands', 'models'));
    }
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function cars(Request $request, $page = 1)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $params = $request->all();
        $carsData = self::getCarList( true, $params, ($page -1)*9, 9);
        $cars = $carsData[0];
        // dd(json_encode($cars));
        $totalCount = $carsData[1];
        $actualCount = $carsData[2];
        $brands = self::getMsMaster();
        $models = self::getMsMaster('model');
        $transmitions = [
            (object)[ "id" => "ALL", "name" => "TODAS" ],
            (object)[ "id" => "AT", "name" => "AUTOMÁTICO" ],
            (object)[ "id" => "MT", "name" => "MANUAL" ],
            (object)[ "id" => "SE", "name" => "SECUENCIAL" ],
            (object)[ "id" => "A&S", "name" => "AT & SEC" ],
        ];
        $traxions = [
            (object)[ "id" => "ALL", "name" => "TODAS" ],
            (object)[ "id" => "4X2", "name" => "4X2" ],
            (object)[ "id" => "4X4", "name" => "4X4" ],
            (object)[ "id" => "AWD", "name" => "AWD" ],
        ];
        $ordersBy = [
            (object)[ "id" => "0", "name" => "Destacados" ],
            (object)[ "id" => "2", "name" => "Menor precio" ],
            (object)[ "id" => "3", "name" => "Mayor precio" ],
        ];

        return view('store.cars_list', compact('cars', 'brands', 'models', 'page',
            'totalCount', 'params', 'transmitions', 'traxions', 'ordersBy'));
    }
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('store.about');
    }
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('store.contact');
    }
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function detail($carId)
    {
        $car = Car::whereNull(Car::TABLE_NAME . '.deleted_at')
            ->where(Car::TABLE_NAME . '.for_sale', Car::STATE_ACTIVE)
            ->with('createdBy')
            ->find($carId);
        if (!is_null($car)) {
            return view('store.car_detail', compact('car'));
        } else {
            return view('store.error_404');
        }
    }

    private static function getBrandsWithCarsCount() {
        $brands = MsMaster::whereNull(MsMaster::TABLE_NAME . '.deleted_at')
            ->where(MsMaster::TABLE_NAME . '.flag_active', MsMaster::STATE_ACTIVE)
            ->where(MsMaster::TABLE_NAME . '.tag', 'brand')
            // ->where(MsMaster::TABLE_NAME . '.name', 'TOYOTA')
            ->with('carsCount')
            ->orderBy(MsMaster::TABLE_NAME . '.name', 'ASC')
            ->get();
        $brands_ = [];
        foreach ($brands as $key => $value) {
            if (count($value->carsCount) > 0) {
                array_push($brands_, $value);
            }
        }
        return $brands_;
    }

    private static function getMsMaster($tag = "brand")
    {
        return MsMaster::whereNull(MsMaster::TABLE_NAME . '.deleted_at')
            ->where(MsMaster::TABLE_NAME . '.flag_active', MsMaster::STATE_ACTIVE)
            ->where(MsMaster::TABLE_NAME . '.tag', $tag)
            ->orderBy(MsMaster::TABLE_NAME . '.name', 'ASC')
            ->get();
    }

    private static function getCarList($pagination = false, $params = [], $offsetValue = 0, $limitValue = 5)
    {
        // ACTIVES -> COMPRADOS
        $carList = Car::whereNull(Car::TABLE_NAME . '.deleted_at')
            ->where(Car::TABLE_NAME . '.flag_active', Car::STATE_ACTIVE)
            ->where(Car::TABLE_NAME . '.for_sale', Car::STATE_ACTIVE);        
        if (isset($params['filter_brand']) && (int)$params['filter_brand'] !== 0) {
            # brand...
            $carList = $carList->where(Car::TABLE_NAME . '.brand_id', (int)$params['filter_brand']);
        }
        if (isset($params['filter_model']) && (int)$params['filter_model'] !== 0) {
            # model...
            $carList = $carList->where(Car::TABLE_NAME . '.model_id', (int)$params['filter_model']);
        }
        if (isset($params['filter_year_since']) && (int)$params['filter_year_since'] !== 0) {
            # year since...
            $carList = $carList->where(Car::TABLE_NAME . '.model_year', ">=" ,(int)$params['filter_year_since']);
        }
        if (isset($params['filter_year_to']) && (int)$params['filter_year_to'] !== 0) {
            # year to...
            $carList = $carList->where(Car::TABLE_NAME . '.model_year', "<=" , (int)$params['filter_year_to']);
        }
        $filterByAll = false;
        // filtro detalles
        $carList = $carList->with(['details' => function ($query) use ($params, $filterByAll){
            # transmision...
            if (isset($params['filter_transmition']) && $params['filter_transmition'] !== "ALL") {
                $query->where('transmition', $params['filter_transmition']);
            }
            # trax...
            if (isset($params['filter_trax']) && $params['filter_trax'] !== "ALL") {
                $query->where('traction', $params['filter_trax']);
            }
        }]);
        // totalCount
        $carList_ = [];
        foreach ($carList->get() as $key => $value) {
            if (!is_null($value->details)) {
                if ((int)$value->flag_active === Car::STATE_ACTIVE) {
                    array_push($carList_, $value);
                } else {
                    if (!is_null($value->sale)) {
                        array_push($carList_, $value);
                    } elseif ((int)$value->flag_active === Car::STATE_SOLD) {
                        $value->sale = [];
                        array_push($carList_, $value);
                    }
                }
            }
        }

        // SOLDS -> VENDIDOS
        $carListSold = Car::whereNull(Car::TABLE_NAME . '.deleted_at')
            ->where(Car::TABLE_NAME . '.flag_active', Car::STATE_SOLD)
            ->where(Car::TABLE_NAME . '.for_sale', Car::STATE_ACTIVE)
            ->whereNotNull(Car::TABLE_NAME . '.sold_at');        
        if (isset($params['filter_brand']) && (int)$params['filter_brand'] !== 0) {
            # brand...
            $carListSold = $carListSold->where(Car::TABLE_NAME . '.brand_id', (int)$params['filter_brand']);
        }
        if (isset($params['filter_model']) && (int)$params['filter_model'] !== 0) {
            # model...
            $carListSold = $carListSold->where(Car::TABLE_NAME . '.model_id', (int)$params['filter_model']);
        }
        if (isset($params['filter_year_since']) && (int)$params['filter_year_since'] !== 0) {
            # year since...
            $carListSold = $carListSold->where(Car::TABLE_NAME . '.model_year', ">=" ,(int)$params['filter_year_since']);
        }
        if (isset($params['filter_year_to']) && (int)$params['filter_year_to'] !== 0) {
            # year to...
            $carListSold = $carListSold->where(Car::TABLE_NAME . '.model_year', "<=" , (int)$params['filter_year_to']);
        }
        $filterByAll = false;
        // filtro detalles
        $carListSold = $carListSold->with(['details' => function ($query) use ($params, $filterByAll){
            # transmision...
            if (isset($params['filter_transmition']) && $params['filter_transmition'] !== "ALL") {
                $query->where('transmition', $params['filter_transmition']);
            }
            # trax...
            if (isset($params['filter_trax']) && $params['filter_trax'] !== "ALL") {
                $query->where('traction', $params['filter_trax']);
            }
        }]);
        // filtro fecha de venta
        $expDate = Carbon::now()->subDays(Car::SOLD_DAYS);
        $carListSold->whereDate(Car::TABLE_NAME . '.sold_at', '>', $expDate);
        
        // totalCount
        $carListSold_ = [];
        foreach ($carListSold->get() as $key => $value) {
            if (!is_null($value->details)) {
                if ((int)$value->flag_active === Car::STATE_ACTIVE) {
                    array_push($carListSold_, $value);
                } else {
                    if (!is_null($value->sale)) {
                        array_push($carListSold_, $value);
                    } elseif ((int)$value->flag_active === Car::STATE_SOLD) {
                        $value->sale = [];
                        array_push($carListSold_, $value);
                    }
                }
            }
        }
        // array_merge
        $carList_ = array_merge($carList_, $carListSold_);
        // order by
        if (isset($params['filter_order_by']) && (int)$params['filter_order_by'] !== 0) {
            switch ((int)$params['filter_order_by']) {
                case 2:
                    $carList_ = self::array_sort($carList_, 'price_sale', SORT_ASC);
                    break;
                case 3:
                    $carList_ = self::array_sort($carList_, 'price_sale', SORT_DESC);
                    break;
                default:
                    $carList_ = self::array_sort($carList_, 'publish_at', SORT_DESC);
                    break;
            }
        } else {
            $carList_ = self::array_sort($carList_, 'publish_at', SORT_DESC);
        }
        // pagination
        $totalCount = count($carList_);
        if ($pagination) {
            $carList__ = [];
            for ($i=$offsetValue; $i < ($offsetValue+$limitValue); $i++) {
                if (isset($carList_[$i])) {
                    array_push($carList__, $carList_[$i]);
                }
            }
            $carList_ = $carList__;
            $actualCount = count($carList_);
        }
        // DD
        if (isset($params['showDd'])) {
            dd($carList_, $totalCount, $actualCount);
        }
        return [$carList_, $totalCount, $actualCount];
    }

    private static function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    if (isset($v->$on)) {
                        $sortable_array[$k] = $v->$on;
                    }
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }

            foreach ($sortable_array as $k => $v) {
                array_push($new_array, $array[$k]);
            }
        }

        return $new_array;
    }
}
