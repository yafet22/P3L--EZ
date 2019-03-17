<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';
    protected $primaryKey = 'id_branch';
    public $timestamps = true;
    protected $fillable = [
    'branch_name',
    'branch_address',
    'branch_phone_number',];

    public function employees(){
        return $this->hasMany('App\Employee','id_branch');
    } 
}
