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

    public function motorcyle_types(){
        return $this->belongsTo('App\Motorcyle_type','id_motorcyle_type');
    }
}
