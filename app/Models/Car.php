<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SaveToUpper;

class Car extends Model
{
    use SaveToUpper;
    
    protected $connection = 'mysql';
    const TABLE_NAME = 'cars';
    const MODULE_NAME = 'cars';
    const STATE_INACTIVE = 0;
    const STATE_ACTIVE = 1;
    const STATE_SOLD = 2;
    const STATE_DELETED = 3;
    const COST_PER_DAY = 11;
    const SOLD_DAYS = 3;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id','code','type_entry','brand','model','number','color','fab_year',
        'model_year','currency','price_tasacion','price_sale','price_promotion',
        'price_compra','holder','owner','invoiced','n_tasacion','company_owner',
        'ref_number','register_date','notary','n_kardex','n_title',
        'status','for_sale','details_total_expenses','details_price_acta',
        'details_sale_price','images_json','type_sign','type_entry_detail',
        'sold_at',
        // new fields
        'publish_at','fake_images',
        // masters_id
        'brand_id','model_id','color_id','notary_id','holder_id','owner_id',
        //Audit 
        'created_by','updated_by','deleted_by',
        'flag_active','created_at','updated_at','deleted_at',
    ];
    /**
     * Casting of attributes
     *
     * @var array
     */
    protected $no_upper = ['tr_class_name'];
    protected $casts = [
        'modules' => 'array',
        'images_json' => 'array'
    ];
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