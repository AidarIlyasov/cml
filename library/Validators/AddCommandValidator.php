<?php

namespace Library\Validators;

use Library\Exceptions\AlreadyExistsCommandException;
use Library\Exceptions\InvalidCommandException;
use Library\Exceptions\InvalidCreateCommandDecisionException;

class AddCommandValidator
{
    public function checkCommandName(string $line, string $name, array $commandList): bool
    {
        if ($line == 'n') return false;

        if (!($line == 'y' || $line == 'n')) {
            throw new InvalidCreateCommandDecisionException();
        }

        if (trim($name) == '{add}' || trim($name) == '{help}') {
            throw new InvalidCommandException();
        }

        if (array_key_exists(trim($name), $commandList)) {
            throw new AlreadyExistsCommandException($name);
        }

        return true;
    }
}