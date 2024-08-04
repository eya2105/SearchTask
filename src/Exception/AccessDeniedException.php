<?php

namespace App\Exception;

use Exception;

class AccessDeniedException extends Exception
{
    public function __construct(string $message = "Access Denied", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
