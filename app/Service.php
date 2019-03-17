<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id_service';
    public $timestamps = true;
    protected $fillable = [
    'service_name',
    'price'];

}
