<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param User $user
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id_user,
            'username' => $user->username,
            'name' => $user->employees->name,
            'role' => $user->employees->roles->role_name
        ];
    }
}