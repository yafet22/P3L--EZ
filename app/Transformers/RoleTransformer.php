<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Role;

class RoleTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Role $role
     */
    public function transform(Role $role)
    {
        return [
            'id_role' => $role->id_role,
            'role_name' => $role->role_name,
        ];
    }
}