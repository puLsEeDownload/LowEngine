<?php

namespace pulse\api;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pulse\api\format\PositionFormat;
use pulse\master\PlayerMaster;

class APICutscene
{

    private static ?Vector3 $coords;
    private static bool $is = false;

    public static function set(PositionFormat $pos): void
    {
        $vec = APIPlayer::getPosition();
        self::$coords = new Vector3($vec->x, $vec->y, $vec->z);
        PlayerMaster::getPlayer()->teleport(new Vector3(
            $pos->x,
            $pos->y,
            $pos->z
        ));
        self::$is = true;
    }

    public static function dis(): void
    {
        if(self::$is){
            self::$is = false;
            PlayerMaster::getPlayer()->teleport(self::$coords);
            self::$coords = null;
        }
    }

    public static function move(PlayerMoveEvent $event): void
    {
        if(self::$is){
            $event->cancel();
        }
    }

}