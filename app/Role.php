<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Constant variable for admin.
     */
    const ADMIN = 1;

    /**
     * Constant variable for costumer service.
     */
    const CUSTOMER_SERVICE = 2;

    /**
     * Constant variable for cashier.
     */
    const CASHIER = 3;

    /**
     * Constant variable for mechanic.
     */
    const MECHANIC = 4;

    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    public $timestamps = true;
    protected $fillable = [
    'role_name',];

    public function employees(){
        return $this->hasMany('App\Employee','id_role');
    }
}
