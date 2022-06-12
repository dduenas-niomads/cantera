<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\SaveToUpper;

class Client extends Model
{
    use SaveToUpper;

    protected $connection = 'mysql';
    const TABLE_NAME = 'clients';
    const MODULE_NAME = 'clients';
    const STATE_ACTIVE = true;
    const STATE_INACTIVE = false;
    const DEFAULT_TYPE = 1;
    const DEFAULT_TYPE_DOCUMENT = "01";
    const DEFAULT_DOCUMENT_NUMBER = "88888888";
    const TYPE_DOCUMENT_NAMES = [
        "01" => "DNI",
        "04" => "CEX",
        "06" => "RUC",
        "07" => "PAS"
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Table Rows
        'id','tag','name','type','type_document','document_number',
        'address','department','province','district',
        'phone','phone_2','email','comentary',
        // masters_id
        'department_id','province_id','district_id',
        // person
        'names','first_lastname','second_lastname','birthday',
        // company
        'rz_social','commercial_name','type_company',
        'estado_contribuyente','condicion_contribuyente',
        'rl_name','rl_type_document','rl_document_number',
        'rl_position',
        //Audit 
        'created_by','updated_by','deleted_by',
        'flag_active','created_at','updated_at','deleted_at',
    ];
    /**
     * Casting of attributes
     *
     * @var array
     */
    protected $no_upper = ['tag'];
    protected $casts = [
        'modules' => 'array'
    ];
    public function getFillable() {
        # code...
        return $this->fillable;
    }

    public function purchases()
    {
        return $this->hasMany('App\Models\Purchase', 'owner_id')
            ->whereNull('deleted_at');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = self::TABLE_NAME;
}