<?php

namespace pulse\api;

use pulse\Kernel;
use pulse\tasks\TriggerTask;

class APIDelay
{

    /**
     * Регистрирует таск после которого вызывается триггер
     *
     * @param int $taskId
     * @param int $ticks
     * @return void
     */
    public static function registerTask(int $taskId, int $ticks): void
    {
        Kernel::getInstance()->getEngine()->getScheduler()->scheduleDelayedTask(new TriggerTask($taskId), $ticks);
    }

}