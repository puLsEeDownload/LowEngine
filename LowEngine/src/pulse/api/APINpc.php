<?php

namespace pulse\api;

use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\Human;
use pocketmine\entity\Location;
use pocketmine\entity\Skin;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\ByteArrayTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\network\mcpe\protocol\AnimateEntityPacket;
use pocketmine\world\World;
use pulse\api\format\ItemFormat;
use pulse\entity\npc\NPCEntity;
use pulse\api\format\PositionFormat;
use pulse\Kernel;
use pulse\master\PlayerMaster;
use pulse\npc\NPCMoveTask;

class APINpc
{

    private static array $npcID;

    /**
     * Обязательная функция! Ставить в начале скрипта, если не инициализировать будет сбой при summonNPC
     *
     * @return void
     */
    public static function init(): void
    {
        EntityFactory::getInstance()->register(NPCEntity::class, function (World $world, CompoundTag $nbt): NPCEntity{
            return new NPCEntity(EntityDataHelper::parseLocation($nbt, $world), Human::parseSkinNBT($nbt), $nbt);
        }, ['NPCEntity', 'NPCEntity']);
    }

    /**
     * Спавнит NPC в указанном месте, с указанным айди и скином
     *
     * @param PositionFormat $pos
     * @param Skin $skin
     * @param int $id
     * @return void
     */
    public static function summonNPC(PositionFormat $pos, Skin $skin, int $id): void
    {
        $nbt = CompoundTag::create()
            ->setTag("Name", new StringTag($skin->getSkinId()))
            ->setTag("Data", new ByteArrayTag($skin->getSkinData()))
            ->setTag("CapeData", new ByteArrayTag($skin->getCapeData()))
            ->setTag("GeometryName", new StringTag($skin->getGeometryName()))
            ->setTag("GeometryData", new ByteArrayTag($skin->getGeometryData()))
            ->setString('commands', '');
        $npc = new NPCEntity(new Location(
           $pos->x,
           $pos->y,
           $pos->z,
           PlayerMaster::getPlayer()->getWorld(),
           0,
           0
        ), $skin, $nbt);

        $geometrySkin = new Skin(
            $skin->getSkinId(),
            $skin->getSkinData(),
            "",
            'geometry.npc',
            file_get_contents(RESOURCES_FOLDER . 'models/entity/steve.entity.json')
        );
        $npc->setSkin($geometrySkin);
        $npc->sendSkin();

        self::attributes($npc);

        $npc->spawnToAll();

        $npc->setNpcID($id);

        self::$npcID[$id] = $npc;

        self::loopAnimation($id, 'npc.animation.idle');
    }

    /**
     * Удаляет NPC по айди
     *
     * @param int $id
     * @return void
     */
    public static function destroyNPC(int $id): void
    {
        if(isset(self::$npcID[$id]))
        {
            self::getNPCById($id)->kill();
            unset(self::$npcID[$id]);
        }
    }

    /**
     * Заствляет NPC смотреть на другого
     *
     * @param int $npcID
     * @return void
     */
    public static function lookAt(int $npcID, NPCEntity $entity): void
    {
        self::getNPCById($npcID)->lookAt(new Vector3(
            $entity->getPosition()->getX(),
            $entity->getPosition()->getY() + 1.5,
            $entity->getPosition()->getZ()
        ));
    }

    /**
     * Заствляет NPC смотреть на другого
     *
     * @param int $npcID
     * @return void
     */
    public static function lookAtPlayer(int $npcID): void
    {
        self::getNPCById($npcID)->lookAt(new Vector3(
            APIPlayer::getX(),
            APIPlayer::getY() + 1.5,
            APIPlayer::getZ()
        ));
    }

    /**
     * Заставляет NPC идти к координатам
     *
     * @param PositionFormat $pos
     * @return void
     */
    public static function moveTo(int $id, PositionFormat $pos, float $speed): void
    {
        $vec = new Vector3($pos->x, $pos->y, $pos->z);

        Kernel::getInstance()->getEngine()->getScheduler()->scheduleRepeatingTask(new NPCMoveTask(
            self::getNPCById($id),
            $vec,
            $speed
        ), 1);
        self::getNPCById($id)->lookAt($vec);
    }

    public static function loopAnimation(int $id, string $animation): void
    {
        $pk = AnimateEntityPacket::create($animation, '', '', 0, 'steve', 3.25, [self::getNPCById($id)->getId()]);
        PlayerMaster::getPlayer()->getNetworkSession()->sendDataPacket($pk);
    }

    /**
     * Выдать предмет в руку NPC
     *
     * @param int $id
     * @param ItemFormat $itemFormat
     * @return void
     */
    public static function giveItemInHand(int $id, ItemFormat $itemFormat): void
    {
        $item = new Item(new ItemIdentifier($itemFormat->id));
        $item->setCount($itemFormat->count);

        self::getNPCById($id)->getInventory()->setItemInHand($item);
    }

    /**
     * Устанавливает NPC никнейм
     *
     * @param int $id
     * @param string $name
     * @return void
     */
    public static function setName(int $id, string $name): void
    {
        self::getNPCById($id)->setNameTag($name);
        self::getNPCById($id)->setNameTagVisible(true);
        self::getNPCById($id)->setNameTagAlwaysVisible(true);
    }

    public static function attributes(Human $npc): void
    {
        $npc->setMaxHealth(20);
        $npc->setHealth(20);
    }

    /**
     * Возвращает самого NPC по указанному айди
     *
     * @param int $id
     * @return Human|null
     */
    public static function getNPCById(int $id): ?NPCEntity
    {
        return self::$npcID[$id] ?? null;
    }

}