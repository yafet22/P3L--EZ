<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motorcycle_Brand extends Model
{
    protected $table = 'motorcycle_brands';
    protected $primaryKey = 'id_motorcycle_brand';
    public $timestamps = true;
    protected $fillable = [
    'motorcycle_brand_name',];

    public function motorcycle_types(){
        return $this->hasMany('App\Motorcycle_type','id_motorcycle_brand');
    }
}
