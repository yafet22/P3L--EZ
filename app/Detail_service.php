<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_service extends Model
{
    protected $table = 'detail_services';
    protected $primaryKey = 'id_detail_service';
    public $timestamps = true;
    protected $fillable = [
    'detail_service_amount',
    'detail_service_price',
    'detail_service_subtotal',
    'id_transaction',
    'id_service',
    'id_employee',
    'id_motorcycle'];

    protected $casts = [
        'detail_service_amount' => 'integer',
        'detail_service_price' => 'double',
        'detail_service_subtotal' => 'double',
        'id_service' => 'integer',
        'id_mechanic_onduty' => 'integer',
        'id_employee' => 'integer',
        'id_motorcycle' => 'integer',
    ];

    public function transactions(){
        return $this->belongsTo('App\Transaction','id_transaction');
    }

    public function services(){
        return $this->belongsTo('App\Service','id_service');
    }

    public function mechanics(){
        return $this->belongsTo('App\Employee','id_employee');
    }

    public function motorcycles(){
        return $this->belongsTo('App\Motorcycle','id_motorcycle');
    }
}
