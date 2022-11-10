<?php

namespace Libelulasoft\CommonRest\exceptions;

use Exception;

class InvalidClassException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 2003);
    }
}
