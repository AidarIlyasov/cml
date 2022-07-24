<?php

namespace Library;

use Library\CommandCreator;
use Library\Validators\AddCommandValidator;
use Library\Exceptions\NotExistsCommandException;

class CommandPresentation
{
    public function displayCommandList(array $commandList): string
    {
        $commands = [];
        foreach ($commandList as $command => $value)
        {
            $description = array_key_exists('description', $value) ? $value['description'] : '-';
            $commands[] = "\t - $command | " . $description . PHP_EOL;
        }

        return count($commandList) > 0
            ? 'Available commands:' . PHP_EOL . implode($commands)
            : 'List of command is empty. You can add your command: command_name {add}';
    }

    public function displayCommand(string $name, array $commandList): string
    {
        $result = PHP_EOL. 'Called command: ' . $name . PHP_EOL . PHP_EOL;

        $result .= 'Arguments:' .  PHP_EOL;
        $result .= array_key_exists('arguments', $commandList[$name])
            ? $this->collectList($commandList[$name]['arguments']) : "\t - no arguments";

        $result .= 'Options:' . PHP_EOL;
        $result .= array_key_exists('options', $commandList[$name])
            ? $this->collectList($commandList[$name]['options']) : "\t - no options";

        return $result;
    }

    public function displayCommandHelpDescription(string $name, array $commandList): string
    {
        if (!isset($commandList[$name])) {
            throw new NotExistsCommandException();
        }

        $description = array_key_exists('description', $commandList[$name])
            ? $commandList[$name]['description'] : 'description not exists';

        return '- command [' . $name . '] has been ran with help argument' . PHP_EOL . "\t - description: " . $description;
    }

    public function displayCommandAddLine(string $name, array $commandList): string
    {
        echo 'Command [' . $name . '] will be add? [Y/N]: ';
        $line = strtolower(trim(fgets(STDIN)));
        if (!(new AddCommandValidator())->checkCommandName($line, $name, $commandList)) {
            return 'buy';
        }

        echo 'Put command description: ';
        $description = strtolower(trim(fgets(STDIN)));

        if ((new CommandCreator())->saveCommand($name, $description)) {
            return $name . ' has been saved';
        }

        return 'something went wrong';
    }

    private function collectList(array $items, int $inheritLevel = 1): string
    {
        $result = '';
        $tabs = str_repeat("\t", $inheritLevel++);
        foreach ($items as $key => $item)
        {
            if (is_array($item) && count($item) > 0) {
                $result .= $tabs . " - ". $key . PHP_EOL;
                $result .= $this->collectList($item, $inheritLevel);
                continue;
            }

            $result .= $tabs . " - ". $item . PHP_EOL;
        }

        return $result;
    }
}