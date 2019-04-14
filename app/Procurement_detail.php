<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procurement_detail extends Model
{
    protected $table = 'procurement_details';
    protected $primaryKey = 'id_procurement_detail';
    public $timestamps = true;
    protected $fillable = [
    'price',
    'id_procurement',
    'id_sparepart',
    'subtotal',
    'amount'];

    protected $casts = [
        'price' => 'double',
        'subtotal' => 'double',
        'amount' => 'integer',
        'id_procurement' => 'integer',
        'id_sparepart' => 'integer',
    ];

    public function procurements(){
        return $this->belongsTo('App\Procurement','id_procurement');
    }

    public function spareparts(){
        return $this->belongsTo('App\Sparepart','id_sparepart');
    }
}
