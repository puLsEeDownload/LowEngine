<?php

namespace pulse\tasks;

use pocketmine\scheduler\Task;
use pulse\master\TriggerMaster;

class TriggerTask extends Task
{

    private int $taskId;

    public function __construct(int $taskId)
    {
        $this->taskId = $taskId;
    }

    public function onRun(): void
    {
        TriggerMaster::call('trigger.delay.success', [
            'id' => $this->taskId
        ]);
    }

}