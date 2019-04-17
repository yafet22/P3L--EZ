<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    protected $table = 'spareparts';
    protected $primaryKey = 'id_sparepart';
    public $timestamps = true;
    public $incrementing = false;
    protected $fillable = [
    'sparepart_name',
    'merk',
    'stock',
    'min_stock',
    'purchase_price',
    'sell_price',
    'placement',
    'image',
    'id_sparepart_type'];

    protected $casts = [
        'stock' => 'integer',
        'min_stock' => 'integer',
        'purchase_price' => 'double',
        'sell_price' => 'double',
        'id_sparepart_type' => 'integer'
    ];


    public function sparepart_types(){
        return $this->belongsTo('App\Sparepart_type','id_sparepart_type');
    }

    public function motorcycleTypes(){
        return $this->belongsToMany('App\Motorcycle_Type','compatibilities','id_sparepart','id_motorcycle_type');
    }

    public function procurementdetails(){
        return $this->hasMany('App\Procurement_detail','id_sparepart');
    }

    public function detail_spareparts(){
        return $this->hasMany('App\Detail_sparepart','id_sparepart');
    }
}
