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
            'name' => optional($user->employees)->name,
            'role' => optional(optional($user->employees)->roles)->role_name
        ];
    }
}