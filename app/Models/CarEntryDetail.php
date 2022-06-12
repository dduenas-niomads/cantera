<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SaveToUpper;

class CarEntryDetail extends Model
{
    use SaveToUpper;
    
    protected $connection = 'mysql';
    const TABLE_NAME = 'car_entry_details';
    const STATE_ACTIVE = true;
    const STATE_INACTIVE = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id','cars_id','soat_code','soat_end_date','tech_review_end_date',
        'sat_taxes','motor_serie','cylinders','cc','hp','torque','transmition',
        'doors_number','circulation_end_date','next_service_date','traction',
        'work_hours','ticket_amount_sutran','ticket_amount_sat','options_json',
        'observations','kilometers','motor_number','description','fuel','next_service_km',
        'key_code',
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
        'options_json' => 'array'
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