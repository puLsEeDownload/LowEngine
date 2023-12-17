<?php

namespace pulse\master;

class TriggerMaster
{

    private static array $trigger;

    public static function call(string $trigger, array $optional = []): void
    {
        if(isset(self::$trigger['closure']))
            call_user_func(self::$trigger['closure'], $trigger, $optional);
    }

    public static function setTriggerCallback($closure): void
    {
        if(empty(self::$trigger['closure']))
            self::$trigger['closure'] = $closure;
    }

}