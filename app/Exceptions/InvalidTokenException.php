<?php

namespace App\Exceptions;

class InvalidTokenException extends \Exception
{
    protected $message = 'invalid_token';
}
