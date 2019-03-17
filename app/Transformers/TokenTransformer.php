<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Token;

class TokenTransformer extends TransformerAbstract
{
    /**
     * Transform Token.
     *
     * @param Token $token
     */
    public function transform(Token $token)
    {
        return [
            'token_username' => $token->token_username,
            'token_password' => $token->token_password,
            'generated_at' => $token->created_at->toDateTimeString(),
            'lastused_at' => $token->updated_at->toDateTimeString(),
        ];
    }
}