<?php

namespace pulse\master;

use pocketmine\player\Player;

class PlayerMaster
{

    private static Player $player;

    public static function getPlayer(): Player
    {
        return self::$player;
    }

    public static function setPlayer(Player $player): void
    {
        self::$player = $player;
    }

}