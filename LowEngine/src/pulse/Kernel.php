<?php

namespace pulse;

use pulse\commands\SaintEngineCommand;
use pulse\console\Logger;
use pulse\event\EventListen;
use pulse\master\InstanceMaster;
use pulse\scripts\Script;

class Kernel
{
    use InstanceMaster;

    private SaintEngine $engine;
    public bool $scriptStarted = false;

    public function start(SaintEngine $engine): void
    {
        try{
            $this->engine = $engine;

            $folder = $engine->getDataFolder() . 'resources/';
            if(!(is_dir($folder)))
                @mkdir($folder);
            define('RESOURCES_FOLDER', $folder);
            Logger::info('Зарегистрирована дата папки resources');

            $engine->getServer()->getPluginManager()->registerEvents(new EventListen(), $engine);
            Logger::info('Зарегистриован обработчик событий');

            Logger::info('Движок запущен!');

            $engine->getServer()->getCommandMap()->register('saintengine', new SaintEngineCommand());

        }catch(\Throwable $throwable){
            Logger::error($throwable->getMessage());
            $engine->getServer()->shutdown();
        }
    }

    public function shutdown(): void
    {
        Logger::info('Отключаюсь...');
    }

    public function getEngine(): SaintEngine
    {
        return $this->engine;
    }

    public function startScript(): void
    {
        $script = new Script();
        $script->run();
        $this->scriptStarted = true;
        Logger::info('Скрипт запущен!');
    }

}