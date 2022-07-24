<?php
namespace App;

use Library\CommandLineManager;

class App
{
    private CommandLineManager $commandLineManager;

    public function __construct(array $consoleArguments = [])
    {
        echo (new CommandLineManager)->run($consoleArguments);
    }
}