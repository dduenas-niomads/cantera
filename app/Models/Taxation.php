<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SaveToUpper;

class Taxation extends Model
{
    use SaveToUpper;

    protected $connection = 'mysql';
    const TABLE_NAME = 'taxations';
    const MODULE_NAME = 'taxations';
    const STATE_ACTIVE = true;
    const STATE_INACTIVE = false;
    const STATE_PENDING = 1;
    const STATE_PURCHASED = 2;
    const STATE_FINISHED = 3;
    const STR_PAD_VALUE = 6;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id','cars_id','taxator','taxator_id',
        'salesman','salesman_id',
        'client_amount','offered_amount','phone',
        'tires','paint','maintenance','owners',
        'comentary','progress_image_json',
        'taxation_date','status','car_number',
        'currency',
        //Audit 
        'created_by','updated_by','deleted_by',
        'flag_active','created_at','updated_at','deleted_at',
    ];
    /**
     * Casting of attributes
     *
     * @var array
     */
    protected $no_upper = [];
    protected $casts = [
        'progress_image_json' => 'array'
    ];
    public function getFillable() {
        # code...
        return $this->fillable;
    }

    public function car()
    {
        return $this->belongsTo('App\Models\Car', 'cars_id')
            ->with('details:id,cars_id,kilometers');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = self::TABLE_NAME;
}