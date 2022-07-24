<?php

namespace Library;

use Library\commandLineContext;

class CommandLineMather
{
    private string $consoleLine;

    public function getArguments(): array
    {
        $pattern = '/\w*[^,{}\s]/';
        preg_match_all($pattern, $this->consoleLine, $arguments);

        return $arguments;
    }

    public function getParameters(): array
    {
        /*
         * Если пользователь запускает параметры без пробелов [methods={create,update,delete}],
         * то в $this->consoleLine будет значение [methods=create][methods=update][methods=delete]
         * */
        $pattern = '/\[(?<p_name>\w*)=(?<p_value>[\w.]{1,})\]|';
        /*
         * Если пользователь запускает параметры с пробелами [ methods = { create, update, delete }  ],
         * то в $this->consoleLine будет значение [methods={create,update,delete}]
         * */
        $pattern .= '\[(?<p_n2>\w*)={(?<p_v2>[^{]*)}]/m';

        preg_match_all($pattern, $this->consoleLine, $parameters, PREG_SET_ORDER, 0);
        $this->consoleLine = preg_replace($pattern, '', $this->consoleLine);

        return $parameters;
    }

    public function parseConsoleLineString(array $consoleArguments): void
    {
        unset($consoleArguments[0], $consoleArguments[1]);
        $this->consoleLine = implode('', $consoleArguments);
    }
}