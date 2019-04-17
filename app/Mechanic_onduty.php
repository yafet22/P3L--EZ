<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mechanic_onduty extends Model
{
    protected $table = 'mechanic_onduties';
    protected $primaryKey = 'id_mechanic_onduty';
    public $timestamps = true;
    protected $fillable = [
    'id_employee',
    'id_motorcycle'];

    protected $casts = [
        'id_employee' => 'integer',
        'id_motorcycle' => 'integer'
    ];

    public function detail_spareparts(){
        return $this->hasMany('App\Detail_sparepart','id_mechanic_onduty');
    }

    public function detail_services(){
        return $this->hasMany('App\Detail_service','id_mechanic_onduty');
    }

    public function employees(){
        return $this->belongsTo('App\Employee','id_employee');
    }

    public function motorcycles(){
        return $this->belongsTo('App\Motorcycle','id_motorcycle');
    }

}
