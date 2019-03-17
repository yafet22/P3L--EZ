<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sparepart_type extends Model
{
    protected $table = 'sparepart_types';
    protected $primaryKey = 'id_sparepart_type';
    public $timestamps = true;
    protected $fillable = [
    'sparepart_type_name',];

    public function spareparts()
    {
        return $this->hasMany('App\Sparepart','id_sparepart_type');
    }
}
