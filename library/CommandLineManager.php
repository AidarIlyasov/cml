<?php

namespace Library;

use Library\Exceptions\InvalidCommandException;
use Library\Validators\CommandLineValidator;
use Library\CommandLineMather;
use Library\CommandLineContext;

class CommandLineManager
{
    private string $commandName;
    private array $commandList;
    private ICommandLineContext $context;

    public function __construct(ICommandLineContext $context)
    {
        try {
            $this->context = $context;
            $this->commandList = $context->getCommandList();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function run(array $consoleArguments)
    {
        $validator = new CommandLineValidator(); // should be DI
        $presenter = new CommandPresentation();
        $mather    = new CommandLineMather();
        $creator   = new CommandCreator($this->context);

        try {
            if ($result = $this->checkCommandLineHasSpecificCases($validator, $presenter, $consoleArguments)) {
                return $result;
            }

            $this->commandName = $consoleArguments[1];
            $mather->parseConsoleLineString($consoleArguments);

            return $this->match($mather, $presenter, $creator);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function match(
        CommandLineMather $mather,
        CommandPresentation $presenter,
        CommandCreator $creator
    ): string
    {
        $parameters = $mather->getParameters();
        $arguments  = $mather->getArguments();

        $updatedCommandList = $creator->collectCommandArgumentsAndParams($this->commandName, $arguments, $parameters);

        return $presenter->displayCommand($this->commandName, $updatedCommandList);
    }

    private function checkCommandLineHasSpecificCases(
        CommandLineValidator $validator,
        CommandPresentation $presenter,
        array $consoleArguments
    )
    {
        if (empty($consoleArguments[1])) {
            return $presenter->displayCommandList($this->commandList);
        }

        if (trim($consoleArguments[1]) == '{help}' || trim($consoleArguments[1]) == '{add}') {
            throw new InvalidCommandException();
        }

        if ($validator->hasAddArgument($consoleArguments)) {
            return $presenter->displayCommandAddLine($consoleArguments[1], $this->commandList);
        }

        if ($validator->hasHelpArgument($consoleArguments)) {
            return $presenter->displayCommandHelpDescription($consoleArguments[1], $this->commandList);
        }

        return false;
    }
}