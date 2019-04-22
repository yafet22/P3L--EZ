<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motorcycle extends Model
{
    protected $table = 'motorcycles';
    protected $primaryKey = 'id_motorcycle';
    public $timestamps = true;
    protected $fillable = [
    'license_number',
    'id_motorcycle_type',
    'id_customer'];

    protected $casts = [
        'id_motorcycle_type' => 'integer',
        'id_customer' => 'integer'
    ];

    public function customers(){
        return $this->belongsTo('App\Customer','id_customer');
    }

    public function motorcycle_types(){
        return $this->belongsTo('App\Motorcycle_Type','id_motorcycle_type');
    }

    public function detailServices(){
        return $this->hasMany('App\Detail_service','id_motorcycle');
    }

    public function detailSpareparts(){
        return $this->hasMany('App\Detail_sparepart','id_motorcycle');
    }
}
