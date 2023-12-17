<?php

namespace pulse\console;

use pocketmine\utils\Terminal;

class Logger
{

    public static function info(string $message): void
    {
        echo(Terminal::$COLOR_GREEN . 'LowEngine | ' . Terminal::$COLOR_WHITE . $message . PHP_EOL);
    }

    public static function error(string $message): void
    {
        echo(Terminal::$COLOR_RED . 'LowEngine | ' . $message . PHP_EOL);
    }

}