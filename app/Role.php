<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    public $timestamps = true;
    protected $fillable = [
    'role_name',];

    public function employees(){
        return $this->hasMany('App\Employee','id_role');
    }
}
