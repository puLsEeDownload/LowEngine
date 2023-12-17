<?php

namespace pulse\event;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\player\Player;
use pulse\api\APICutscene;
use pulse\console\Logger;
use pulse\entity\npc\NPCEntity;
use pulse\Kernel;
use pulse\master\PlayerMaster;
use pulse\master\TriggerMaster;

class EventListen implements Listener
{

    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();

        PlayerMaster::setPlayer($player);
        TriggerMaster::call('trigger.player.join');

        Logger::info('Игрок ' . $player->getName() . ' был установлен как играющий');
        if(!Kernel::getInstance()->scriptStarted)
            Kernel::getInstance()->startScript();
    }

    public function onChat(PlayerChatEvent $event): void
    {
        TriggerMaster::call('trigger.player.chat', [
            'message' => $event->getMessage()
        ]);
    }

    public function onEntityDamage(EntityDamageEvent $event): void
    {
        $entity = $event->getEntity();

        if($event instanceof EntityDamageByEntityEvent){
            $damager = $event->getDamager();

            if($entity instanceof NPCEntity and $damager instanceof Player){
                TriggerMaster::call('trigger.npc.hit', [
                    'id' => $entity->getNpcId()
                ]);
                $event->cancel();
            }
        }
    }

    public function move(PlayerMoveEvent $event): void
    {
        APICutscene::move($event);
    }

}