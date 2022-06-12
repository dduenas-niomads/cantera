<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SaveToUpper;

class Product extends Model
{
    use SaveToUpper;
    
    protected $connection = 'mysql';
    const TABLE_NAME = 'products';
    const MODULE_NAME = 'products';
    const STATE_INACTIVE = 0;
    const STATE_ACTIVE = 1;
    const STATE_DELETE = 2;
    const TYPE_PRODUCT = 1;
    const TYPE_SERVICE = 1;
    const ARRAY_ORDER = [
        '.code', '.category', '.brand', '.name', '.description',
        '.price_compra', '.price_sale', '.stock', '.type_product',
        '.flag_active',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id', 'code', 'brand', 'brand_id', 'category', 'category_id',
        'name', 'description', 'price_compra', 'price_sale', 'type_product',
        'stock', 'minimun_stock',
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