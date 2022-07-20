<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SaveToUpper;

class PosCompany extends Model
{
    use SaveToUpper;
    
    protected $connection = 'mysql';
    const TABLE_NAME = 'pos_companies';
    const MODULE_NAME = 'pos_companies';
    const STATE_INACTIVE = 0;
    const STATE_ACTIVE = 1;
    const STATE_DELETE = 2;
    const ARRAY_ORDER = [
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id', 'name', 'plans_id', 'avaiblable_tax_documents', 'url_image',
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