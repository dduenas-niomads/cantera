<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarEntryExpense extends Model
{
    protected $connection = 'mysql';
    const TABLE_NAME = 'car_entry_expenses';
    const STATE_ACTIVE = true;
    const STATE_INACTIVE = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id','cars_id','admission_date','cost_per_day',
        'currency','price_sale','price_buy','expenses_json',
        //Audit 
        'created_by','updated_by','deleted_by',
        'flag_active','created_at','updated_at','deleted_at',
    ];
    /**
     * Casting of attributes
     *
     * @var array
     */
    protected $casts = [
        'expenses_json' => 'array'
    ];
    public function getFillable() {
        # code...
        return $this->fillable;
    }

    public function car()
    {
        return $this->belongsTo('App\Models\Car', 'cars_id');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = self::TABLE_NAME;
}