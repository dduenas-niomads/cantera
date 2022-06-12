<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SaveToUpper;

class Purchase extends Model
{
    use SaveToUpper;

    protected $connection = 'mysql';
    const TABLE_NAME = 'purchases';
    const MODULE_NAME = 'purchases';
    const STATE_ACTIVE = true;
    const STATE_INACTIVE = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id','code',
        // foreigns_id
        'cars_id','taxations_id','clients_id',
        // business
        'type_entry','brand','model','number','color','fab_year',
        'model_year','currency','price_tasacion','price_sale',
        'price_compra','holder','owner','invoiced','n_tasacion',
        'ref_number','register_date','notary','n_kardex','n_title',
        'status','for_sale','details_total_expenses','details_price_acta',
        'details_sale_price','images_json','documents_json','closed','type_sign',
        // masters_id
        'brand_id','model_id','color_id','notary_id','holder_id','owner_id',
        //Audit 
        'created_by','updated_by','deleted_by','delete_commentary',
        'flag_active','created_at','updated_at','deleted_at',
    ];
    /**
     * Casting of attributes
     *
     * @var array
     */
    protected $no_upper = [];
    protected $casts = [
        'images_json' => 'array',
        'documents_json' => 'array'
    ];
    public function getFillable() {
        # code...
        return $this->fillable;
    }

    public function car()
    {
        return $this->hasOne('App\Models\Car', 'cars_id')
            ->whereNull('deleted_at');
    }

    public function client()
    {
        return $this->hasOne('App\Models\Client', 'clients_id')
            ->whereNull('deleted_at');
    }

    public function taxation()
    {
        return $this->hasOne('App\Models\Taxation', 'taxations_id')
            ->whereNull('deleted_at');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = self::TABLE_NAME;
}