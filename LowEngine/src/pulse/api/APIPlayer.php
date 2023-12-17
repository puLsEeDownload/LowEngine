<?php

namespace pulse\api;

use pocketmine\entity\effect\Effect;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Skin;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\world\World;
use pulse\api\format\ItemFormat;
use pulse\api\format\PositionFormat;
use pulse\master\PlayerMaster;

class APIPlayer
{

    /**
     * Отправляет игроку сообщение в чат
     *
     * @param string $message
     * @return void
     */
    public static function sendMessage(string $message): void
    {
        PlayerMaster::getPlayer()->sendMessage('§r§7§l| §r' . $message);
    }

    /**
     * Делает игроку экран черным на 5 секунд
     *
     * @param string|null $title
     * @return void
     */
    public static function showFadeScreen(?string $title = null): void
    {
        PlayerMaster::getPlayer()->getEffects()->add(new EffectInstance(VanillaEffects::BLINDNESS(),
        20 * 5,
        255,
        false
        ));
        if($title !== null)
            PlayerMaster::getPlayer()->sendTitle($title);
    }

    /**
     * Возвращает координату X игрока
     *
     * @return float
     */
    public static function getX(): float
    {
        return PlayerMaster::getPlayer()->getPosition()->getX();
    }

    /**
     * Возвращает координату Y игрока
     *
     * @return float
     */
    public static function getY(): float
    {
        return PlayerMaster::getPlayer()->getPosition()->getY();
    }

    /**
     * Возвращает координату Z игрока
     *
     * @return float
     */
    public static function getZ(): float
    {
        return PlayerMaster::getPlayer()->getPosition()->getZ();
    }

    /**
     * Возвращает формат позиции игрока (PositionFormat)
     *
     * @return PositionFormat
     */
    public static function getPosition(): PositionFormat
    {
        return new PositionFormat(self::getX(), self::getY(), self::getZ());
    }

    /**
     * Возвращает мир игрока
     *
     * @return World
     */
    public static function getWorld(): World
    {
        return PlayerMaster::getPlayer()->getWorld();
    }

    /**
     * Возвращает класс скина (из ядра) от игрока
     *
     * @return Skin
     */
    public static function getSkin(): Skin
    {
        return PlayerMaster::getPlayer()->getSkin();
    }

    /**
     * Выдать игроку предмет
     *
     * @param ItemFormat $itemFormat
     * @return void
     */
    public static function addItem(ItemFormat $itemFormat): void
    {
        $item = new Item(new ItemIdentifier($itemFormat->id));
        $item->setCount($itemFormat->count);

        PlayerMaster::getPlayer()->getInventory()->addItem($item);
    }

}