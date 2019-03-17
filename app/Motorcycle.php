<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motorcycle extends Model
{
    protected $table = 'motorcycles';
    protected $primaryKey = 'id_motorcycle';
    public $timestamps = true;
    protected $fillable = [
    'license_number',
    'id_motorcycle_type',
    'id_customer'];

    public function customers(){
        return $this->belongsTo('App\Customer','id_customer');
    }

    public function motorcycle_types(){
        return $this->belongsTo('App\Motorcycle_Type','id_motorcycle_type');
    }
}
