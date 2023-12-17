<?php

namespace pulse;

use pocketmine\plugin\PluginBase;

class SaintEngine extends PluginBase
{

    public function onEnable(): void
    {
        Kernel::getInstance()->start($this);
    }

    public function onDisable(): void
    {
        Kernel::getInstance()->shutdown();
    }

}