<?php

namespace Library\Validators;

use Library\CommandLineContext;

class CommandLineValidator
{
    public function hasHelpArgument(array $consoleLine): bool
    {
        $pattern = '/\w*[\s]?{help}/';
        preg_match($pattern, implode(' ', $consoleLine), $match);

        return count($match) > 0;
    }

    public function hasAddArgument(array $consoleLine): bool
    {
        $pattern = '/\w*[\s]?{add}/';
        preg_match($pattern, implode(' ', $consoleLine), $match);

        return count($match) > 0;
    }
}