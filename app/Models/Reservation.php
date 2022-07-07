<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SaveToUpper;

class Reservation extends Model
{
    use SaveToUpper;
    
    protected $connection = 'mysql';
    const TABLE_NAME = 'reservations';
    const MODULE_NAME = 'reservations';
    const STATE_INACTIVE = 0;
    const DESTROY_ALL = 2;
    const STATE_ACTIVE = 1;
    const STATE_PAYED = 2;
    const STATE_DELETE = 0;
    const DEFAULT_PRICE_PR_HOUR = 100;
    const DEFAULT_PRICE_PR_HOUR_1 = 100;
    const DEFAULT_PRICE_PR_HOUR_2 = 85;
    const DEFAULT_TIME = 60;
    const DEFAULT_PAYMENT_ID = 999999;
    const ARRAY_ORDER = [
        '.id', '.cancha_id', '.reservation_date', '.reservation_hour',
        '.client_id', '.payment','.flag_active',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id', 'cancha_id', 'client_id',
        'reservation_date_start_iso',
        'reservation_date_end_iso',
        'reservation_date', 
        'reservation_hour',
        'reservation_date_end', 
        'reservation_hour_end',
        'reservation_hour_hh',
        'reservation_hour_mm',
        'reservation_hour_ampm',
        'reservation_time',
        'additional_time',
        'detail', 'payment',
        'reservations_id',
        //Audit 
        'created_by', 'updated_by', 'deleted_by',
        'flag_active', 'created_at', 'updated_at', 'deleted_at'
    ];
    /**
     * Casting of attributes
     *
     * @var array
     */
    protected $no_upper = ['tr_class_name'];
    protected $casts = [];

    public function getFillable() {
        # code...
        return $this->fillable;
    }

    public function details()
    {
        return $this->hasOne('App\Models\CarEntryDetail', 'cars_id')
            ->whereNull('deleted_at');
    }

    public function actualPurchase()
    {
        return $this->hasOne('App\Models\Purchase', 'cars_id')
            ->whereNull('deleted_at');
    }

    public function expenses()
    {
        return $this->hasOne('App\Models\CarEntryExpense', 'cars_id')
            ->whereNull('deleted_at');
    }

    public function sale()
    {
        return $this->hasOne('App\Models\Sale', 'cars_id', 'id')
            ->whereNull('deleted_at');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id', 'id')
            ->whereNull('deleted_at');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by')
            ->whereNull('deleted_at');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = self::TABLE_NAME;
}