<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SaveToUpper;

class ExchangeRate extends Model
{
    use SaveToUpper;
    
    protected $connection = 'mysql';
    const TABLE_NAME = 'exchange_rate';
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
        'id','compra','venta','origen','moneda','fecha',
        //Audit 
        'created_by','updated_by','deleted_by',
        'flag_active','created_at','updated_at','deleted_at',
    ];
    /**
     * Casting of attributes
     *
     * @var array
     */

    protected $no_upper = [ ];
    protected $casts = [
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