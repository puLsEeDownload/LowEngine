<?php

namespace pulse\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pulse\api\APIPlayer;
use pulse\Kernel;

class SaintEngineCommand extends Command
{

    private const PREFIX = '§r§aLowEngine | §f';

    public function __construct()
    {
        parent::__construct(
            'lowengine',
            'Движок'
        );
        $this->setPermission('pocketmine.command.clear.self');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if(!(isset($args[0])) or !(in_array($args[0], ['start', 'pos']))){
            $sender->sendMessage(self::PREFIX . 'Использование: §alowengine [start, pos, ...]');
            $sender->sendMessage(self::PREFIX . '§astart §f- Запускает скрипт');
            $sender->sendMessage(self::PREFIX . '§apos §f- Отправляет сообщение с твоей позицией');
            return;
        }
        if($args[0] === 'start'){
            Kernel::getInstance()->startScript();
            $sender->sendMessage(self::PREFIX . 'Скрипт был §bперезапущен');
            return;
        }
        if($args[0] === 'pos'){
            $sender->sendMessage(self::PREFIX . 'Твоя позиция:');
            $sender->sendMessage(self::PREFIX . 'X: §b' . APIPlayer::getX() . '§f, Y: §b' . APIPlayer::getY() . '§f, Z: §b' . APIPlayer::getZ());
        }
    }
}