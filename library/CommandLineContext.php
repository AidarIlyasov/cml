<?php

namespace Library;

use Library\ICommandLineContext;

class CommandLineContext implements ICommandLineContext
{
    private string $path;
    public function __construct()
    {
        // should be a config loader like dotenv package
        $this->path = getcwd() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'command_list.json';
    }

    public function getCommandList(): array
    {
        if (!file_exists($this->path)) {
            throw new \Exception("File with command list not exits or should be called like data/command_list.json");
        }

        return json_decode(file_get_contents($this->path), true);
    }

    public function setCommandList(string $json): bool
    {
        return file_put_contents($this->path, $json);
    }
}