<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SaveToUpper;

class Sale extends Model
{
    use SaveToUpper;

    protected $connection = 'mysql';
    const TABLE_NAME = 'sales_cantera';
    const MODULE_NAME = 'sales';
    const STATE_ACTIVE = true;
    const STATE_INACTIVE = false;

    const SALE_TYPE_INVOICE_0 = '00';
    const SALE_TYPE_INVOICE_B = '03';
    const SALE_TYPE_INVOICE_F = '01';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id',
        
        'cancha_id',
        'reservation_id',
        'client_id',
        'document_id',

        'period',
        'items',
        'type_document',
        'serie',
        'correlative',
        'total_amount',
        'taxes',
        // fe
        'fe_request','fe_response','fe_status_code','fe_url_pdf',
        'fe_request_nulled','fe_response_nulled','fe_status_code_nulled',
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
        "fe_request" => "array",
        "fe_response" => "array",
        "fe_request_nulled" => "array",
        "fe_response_nulled" => "array",

    'created_at' => 'datetime:d/m/Y h:m:s',
    ];
    public function getFillable() {
        # code...
        return $this->fillable;
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function document()
    {
        return $this->belongsTo('App\Models\Tax', 'document_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = self::TABLE_NAME;
}