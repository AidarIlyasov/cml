<?php

namespace Library;

interface ICommandLineContext
{
    public function getCommandList();
    public function setCommandList(string $json): bool;
}