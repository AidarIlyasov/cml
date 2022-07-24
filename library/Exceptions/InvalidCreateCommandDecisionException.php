<?php

namespace Library\Exceptions;

class InvalidCreateCommandDecisionException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('You have to press "y" or "n"', $code, $previous);
    }
}