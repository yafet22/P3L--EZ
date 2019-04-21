<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_sparepart extends Model
{
    protected $table = 'detail_spareparts';
    protected $primaryKey = 'id_detail_sparepart';
    public $timestamps = true;
    protected $fillable = [
    'detail_sparepart_amount',
    'detail_sparepart_price',
    'detail_sparepart_subtotal',
    'id_transaction',
    'id_sparepart',
    'id_mechanic_onduty'];

    protected $casts = [
        'detail_sparepart_amount' => 'integer',
        'detail_sparepart_price' => 'double',
        'detail_sparepart_subtotal' => 'double',
        'id_mechanic_onduty' => 'integer'
    ];

    public function transactions(){
        return $this->belongsTo('App\Transaction','id_transaction');
    }

    public function spareparts(){
        return $this->belongsTo('App\Sparepart','id_sparepart');
    }

    public function mechanic_onduties(){
        return $this->belongsTo('App\Mechanic_onduty','id_mechanic_onduty');
    }
}
