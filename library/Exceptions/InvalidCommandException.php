<?php

namespace Library\Exceptions;

use Throwable;

class InvalidCommandException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('you should set command name before using {add} or {help}', $code, $previous);
    }
}