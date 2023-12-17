<?php

namespace pulse\entity\npc;

use pocketmine\entity\Human;
use pocketmine\network\mcpe\protocol\AnimateEntityPacket;

class NPCEntity extends Human
{

    protected static int $npcID;

    public function getName(): string
    {
        return 'NPC.';
    }

    public function setNpcID(int $id): void
    {
        self::$npcID = $id;
    }

    public function getNpcID(): ?int
    {
        if(isset(self::$npcID))
            return self::$npcID;
        return null;
    }
}