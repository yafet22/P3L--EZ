<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'tokens';
    protected $primaryKey = 'id_token';
    public $timestamps = true;
    protected $fillable = [
        'id_user',
        'token_username',
        'token_password',
    ];
    

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Attributes that are hidden.
     */
    protected $hidden = [
        'id_user'
    ];

    /**
     * Define relation between token and user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\User','id_user');
    }
}
