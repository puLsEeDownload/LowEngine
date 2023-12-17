<?php

namespace pulse\npc;

use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use pulse\entity\npc\NPCEntity;
use pulse\Kernel;
use pulse\master\TriggerMaster;

class NPCMoveTask extends Task
{

    public NPCEntity $entity;
    public Vector3 $vector;
    public float $speed;

    public function __construct(NPCEntity $entity, Vector3 $vec, float $speed)
    {
        $this->entity = $entity;
        $this->vector = $vec;
        $this->speed = $speed;
    }

    public function onRun(): void
    {
        $entityPos = $this->entity->getPosition();
        $targetPos = $this->vector;

        $distance = $entityPos->distance($targetPos);

        $direction = $targetPos->subtract($entityPos->x, $entityPos->y, $entityPos->z)->normalize();
        $motion = $direction->multiply($this->speed);

        $this->entity->setMotion($motion);
        if($distance <= 0.8) {
            Kernel::getInstance()->getEngine()->getScheduler()->cancelAllTasks();
            TriggerMaster::call('trigger.npc.passive', [
                'id' => $this->entity->getNpcID()
            ]);
        }
    }

}