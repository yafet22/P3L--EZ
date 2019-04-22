<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id_employee';
    public $timestamps = true;
    protected $fillable = [
    'name',
    'salary',
    'phone_number',
    'address',
    'id_branch',
    'id_role',
    'id_user',
    ];

    protected $casts = [
        'salary' => 'double',
        'id_branch' => 'integer',
        'id_role' => 'integer',
        'id_user' => 'integer'
    ];

    public function branchs(){
        return $this->belongsTo('App\Branch','id_branch');
    }
    
    public function roles(){
        return $this->belongsTo('App\Role','id_role');
    }
    
    public function users(){
        return $this->belongsTo('App\User','id_user ');
    } 

    public function transactions(){
        return $this->belongsToMany('App\Transaction','employee_onduties','id_employee','id_transaction');
    }

    public function detailServices(){
        return $this->hasMany('App\Detail_service','id_employee');
    }

    public function detailSpareparts(){
        return $this->hasMany('App\Detail_sparepart','id_employee');
    }
}
