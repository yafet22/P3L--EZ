<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Branch;

class BranchTransformer extends TransformerAbstract
{
    /**
     * Transform Barang.
     *
     * @param Branch $branch
     */
    public function transform(Branch $branch)
    {
        return [
            'id_branch' => $branch->id_branch,
            'branch_name' => $branch->branch_name,
            'branch_address' => $branch->branch_address,
            'branch_phone_number' => $branch->branch_phone_number,
        ];
    }
}