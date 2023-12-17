<?php

namespace pulse\api;

use pulse\master\TriggerMaster;

abstract class APIScript
{

    /**
     * Выполняется при запуске скрипта
     * ОБЯЗАТЕЛЬНАЯ ФУНКЦИЯ В СКРИПТЕ!
     *
     * @return void
     */
    abstract public function run(): void;

    /**
     * Устанавливает каллбэк для приходящих триггеров
     *
     * @param \Closure $callback
     * @return void
     */
    protected function registerTriggerCallback($callback): void
    {
        TriggerMaster::setTriggerCallback($callback);
    }

}