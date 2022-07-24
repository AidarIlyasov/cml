<?php

namespace Library\Exceptions;

class NotExistsCommandException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Command not found', $code, $previous);
    }
}