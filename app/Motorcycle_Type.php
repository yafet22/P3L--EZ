<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motorcycle_Type extends Model
{
    protected $table = 'motorcycle_types';
    protected $primaryKey = 'id_motorcycle_type';
    public $timestamps = true;
    protected $fillable = [
    'motorcycle_type_name',
    'id_motorcycle_brand'];

    public function motorcycles(){
        return $this->hasMany('App\Motorcycle','id_motorcycle_type');
    }
}
