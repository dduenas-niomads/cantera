<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SaveToUpper;
use App\Models\Car;

class MsMaster extends Model
{
    use SaveToUpper;
    
    protected $connection = 'mysql';
    const TABLE_NAME = 'ms_masters';
    const STATE_ACTIVE = true;
    const STATE_INACTIVE = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id','tag','name','ms_masters_id',
        //Audit 
        'created_by','updated_by','deleted_by',
        'flag_active','created_at','updated_at','deleted_at',
    ];
    /**
     * Casting of attributes
     *
     * @var array
     */

    protected $no_upper = [ 'tag' ];
    protected $casts = [
    ];
    public function getFillable() {
        # code...
        return $this->fillable;
    }
    public function carsCount()
    {
        return $this->hasMany('App\Models\Car', 'brand_id', 'id')
            ->select('id', 'brand_id', 'number', 'flag_active')
            ->whereNull('deleted_at')
            ->where('flag_active', [Car::STATE_ACTIVE])
            ->where('for_sale', Car::STATE_ACTIVE)
            ->where(function($query) {
                $expDate = Carbon::now()->subDays(Car::SOLD_DAYS);
                $query->whereNull('sold_at')
                        ->orWhereDate('sold_at', '>', $expDate);
            });
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = self::TABLE_NAME;
}