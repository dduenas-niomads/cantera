<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsDocument extends Model
{
    protected $connection = 'mysql';
    const TABLE_NAME = 'ms_json_import';
    const STATE_ACTIVE = true;
    const STATE_INACTIVE = false;
    const DEFAULT_CURRENCY = 'USD';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id','access_json','car_number',
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
        'access_json' => 'array'
    ];
    public function getFillable() {
        # code...
        return $this->fillable;
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = self::TABLE_NAME;
}