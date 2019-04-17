<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id_transaction';
    public $timestamps = true;
    public $incrementing = false;
    protected $fillable = [
    'transaction_status',
    'transaction_date',
    'transaction_paid',
    'transaction_type',
    'transaction_discount',
    'transaction_total',
    'id_customer'];

    protected $casts = [
        'transaction_paid' => 'double',
        'transaction_discount' => 'double',
        'transaction_total' => 'double',
        'id_customer' => 'integer'
    ];

    public function employees(){
        return $this->belongsToMany('App\Employee','employee_onduties','id_transaction','id_employee');
    }

    public function detail_spareparts(){
        return $this->hasMany('App\Detail_sparepart','id_transaction');
    }

    public function detail_services(){
        return $this->hasMany('App\Detail_service','id_transaction');
    }

    public function customers(){
        return $this->belongsTo('App\Customer','id_customer');
    }
}
