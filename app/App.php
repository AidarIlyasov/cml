<?php
namespace App;

use Library\CommandLineManager;
use Library\CommandLineContext;

class App
{
    public function __construct(array $consoleArguments = [])
    {
        echo (new CommandLineManager(new CommandLineContext()))->run($consoleArguments);
    }
}