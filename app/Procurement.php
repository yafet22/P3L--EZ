<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procurement extends Model
{
    protected $table = 'procurements';
    protected $primaryKey = 'id_procurement';
    public $timestamps = true;
    protected $fillable = [
    'date',
    'id_sales',
    'procurement_status',];

    protected $casts = [
        'id_sales' => 'integer'
    ];

    public function sales(){
        return $this->belongsTo('App\Sales','id_sales');
    }

    public function procurementdetails(){
        return $this->hasMany('App\Procurement_detail','id_procurement');
    }
}
