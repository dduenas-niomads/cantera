<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SaveToUpper;

class Movement extends Model
{
    use SaveToUpper;

    protected $connection = 'mysql';
    const TABLE_NAME = 'movements';
    const MODULE_NAME = 'movements';
    const STATE_ACTIVE = true;
    const STATE_INACTIVE = false;

    const MOVEMENT_TYPE_01 = 'INGRESO MANUAL';
    const MOVEMENT_TYPE_02 = 'SALIDA MANUAL';
    const MOVEMENT_TYPE_02_SALE = 'SALIDA POR VENTA';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id',
        
        'cancha_id',
        'ref_document_id',
        'type_movement',
        'type_movement_name',
        'date_start',

        'items',
        'total_amount',
        'ref_document',
        // Auditory
        'created_by','updated_by','deleted_by',
        'flag_active','created_at','updated_at','deleted_at',
    ];
    /**
     * Casting of attributes
     *
     * @var array
     */
    protected $no_upper = [
        'fe_url_pdf'
    ];
    protected $casts = [
        "items" => "array",
        "created_at" => "datetime:d/m/Y h:m:s",
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