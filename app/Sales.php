<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'id_sales';
    public $timestamps = true;
    protected $fillable = [
    'sales_name',
    'id_supplier',
    'sales_phone_number',];

    protected $casts = [
        'id_supplier' => 'integer',
    ];

    public function suppliers(){
        return $this->belongsTo('App\Supplier','id_supplier');
    }

    public function procurements(){
        return $this->hasMany('App\Procurement','id_sales');
    }
}
