<?php

namespace Library;

use Library\Exceptions\AlreadyExistsCommandException;
use Library\Exceptions\InvalidCommandException;

class CommandCreator
{
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

    public function collectCommandArgumentsAndParams(string $name, array $arguments, array $params): array
    {
        $this->commandList[$name]['arguments'] = $arguments[0];

        foreach ($params as $param) {
            if (array_key_exists('p_v2', $param)) {
                $this->commandList[$name]['options'][$param['p_n2']] = explode(',', $param['p_v2']);
            } else {
                $this->commandList[$name]['options'][$param['p_name']][] = $param['p_value'];
            }
        }

        return $this->commandList;
    }

    public function saveCommand(string $name, string $description): bool
    {
        $this->commandList[$name] = ['description' => $description];

        $this->context->setCommandList(json_encode($this->commandList));

        return true;
    }
}