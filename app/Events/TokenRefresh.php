<?php

namespace App\Events;

use App\Token;

class TokenRefresh
{
    /**
     * Token attributes.
     *
     * @var string
     */
    public $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }
}
