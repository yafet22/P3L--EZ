<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id_customer';
    public $timestamps = true;
    protected $fillable = [
    'customer_name',
    'customer_phone_number',
    'customer_address',
    ];

    public function motorcycles(){
        return $this->hasMany('App\Motorcycle','id_customer');
    }

    public function transactions(){
        return $this->hasMany('App\Transaction','id_customer');
    }
}
