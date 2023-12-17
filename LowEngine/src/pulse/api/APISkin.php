<?php

namespace pulse\api;

use pocketmine\entity\Skin;
use pulse\lib\SkinConverter;

class APISkin
{

    /**
     * Конвертирует файл скина в дату
     *
     * @param string $skinName
     * @return Skin|null
     * @throws \JsonException
     */
    public static function convert(string $skinName): ?Skin
    {
        $skinPlayer = APIPlayer::getSkin();

        return new Skin($skinPlayer->getSkinId(), SkinConverter::pngToData($skinName), $skinPlayer->getCapeData(), $skinPlayer->getGeometryName(), $skinPlayer->getGeometryData());
    }

}