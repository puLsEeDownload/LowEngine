# LowEngine DOCUMENTATION

![image(1)](https://github.com/puLsEeDownload/LowEngine/assets/154051064/4cad5827-a371-40dc-9336-dcd9ba14488f)

Это документация по движку LowEngine

* [Вступление](#main)
* [APIScript](#script)

* [APIPlayer](#player)
* [APINpc](#npc)
* [APISkin](#skin)
* [APIWorld](#world)
* [APIDelay](#delay)

* [PositionFormat](#positionform)
* [ItemFormat](#itemform)
* [ParticleFormat](#particleform)

* [ParticleList](#particlelist)
* [TriggerList](#triggerlist)

<a id="main"></a>

## Вступление
Движок поддерживает версию ядра PocketMine-MP 5 и только ее.
Удачи

<a id="script"></a>

## APIScript 
```php
abstract public function run(): void - Выполняется при запуске скрипта;
protected function registerTriggerCallback($function): void - Регистрирует функцию с триггером каллбэков (туда приходят триггеры);
```

<a id="player"></a>

## APIPlayer
```php
public static function sendMessage(string $message): void - Отправляет игроку сообщение в чат;
public static function showFadeScreen(?string $title = null): void - Делает игроку экран затемненым (с помощью эффекта) на 5 секунд. Если параметр не пуст, то отправляет титл вместе с темным экраном;
public static function getX(): float - Возвращает координату X игрока;
public static function getY(): float - Возвращает координату Y игрока;
public static function getZ(): float - Возвращает координату Z игрока;
public static function getPosition(): PositionFormat - Возвращает PositionFormat;
public static function addItem(ItemFormat $item): void - Выдает игроку предмет в инвентарь;
```

<a id="npc"></a>

## APINpc
```php
public static function init(): void - Инициализация NPC, без нее они не будут спавнится;
public static function summonNPC(PositionFormat $pos, Skin $skin, int $id): void - Спавнит NPC в нужном месте, с нужным скином и айди;
public static function getNPCById(int $id): NPCEntity - Возвращает сущность NPC по айди;
public static function destroyNPC(int $id): void - Удаляет NPC с указанным айди;
public static function moveTo(int $id, PositionFormat $pos, float $speed): void - Заставляет двигаться NPC к указанным координатам с указанной скоростью;
public static function giveItemInHand(int $id, ItemFormat $itemFormat): void - Дает в руки NPC предмет;
public static function lookAt(int $id, NPCEntity $entity): void - Заставляет NPC смотреть на другого NPC;
public static function lookAtPlayer(int $id): void - Заставляет NPC смотреть на игрока
public static function setName(int $id, string $name): void - Устанавливает имя NPC сверху
```

<a id="skin"></a>

## APISkin
```php
public static function convert(string $skinName): Skin - Конвертирует файл из plugin_data/LowEngine/skins/ в используемый везде Skin. Вводить $skinName нужно без .png;
```

<a id="world"></a>

## APIWorld
```php
public static function summonParticle(PositionFormat $pos, ParticleFormat $particle): void - Спавнит указанный партикл на указанной позиции;
public static function addLineParticle(PositionFormat $pos, ParticleFormat $particle, int $radius): void - Спавнит небольшую линию из партиклов на указанной позиции и с указанным радиусом;
```

<a id="delay"></a>

## APIDelay
```php
public static function registerTask(int $taskId, int $ticks): void - Регистирует таск с айди. Так-же, стоит не забывать что в одной секунде 20 тиков. При выполнении вызывает trigger.delay.success;
```

<a id="positionform"></a>

## PositionFormat
```php
public function __construct(float $x, float $y, float $z);
```

<a id="itemform"></a>

## ItemFormat
```php
public function __construct(int $id, int $meta = 0, int $count = 1);
```

<a id="particleform"></a>

## ParticleFormat
```php
public function __construct(string $particleName);
```

<a id="particlelist"></a>

## ParticleList
```php
string 'world.particle.flame' - Партикл огня;
string 'world.particle.lava' - Партикл лавы, падает в разные стороны;
string 'world.particle.heart' - Партикл сердечка;
```

<a id="triggerlist"></a>

## TriggerList
```php
string 'trigger.player.chat' - Когда игрок вводит что-то в чат, в массиве $optional передается сообщение message;
string 'trigger.npc.hit' - Когда игрок бьет по NPC, в массиве $optional передается айди NPC id;
string 'trigger.delay.success' - Вызывается когда таск (APIDelay) закончен;
string 'trigger.npc.passive' - Когда NPC доходит до координат, в массиве $optional передается айди NPC id;
```
