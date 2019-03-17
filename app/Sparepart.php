<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    protected $table = 'spareparts';
    protected $primaryKey = 'id_sparepart';
    public $timestamps = true;
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

    public function sparepart_types(){
        return $this->belongsTo('App\Sparepart_type','id_sparepart_type');
    }
}
