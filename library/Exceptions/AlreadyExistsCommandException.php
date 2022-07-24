<?php

namespace Library\Exceptions;

class AlreadyExistsCommandException extends \Exception
{
    public function __construct($commandName = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("Command [$commandName] already exists", $code, $previous);
    }
}