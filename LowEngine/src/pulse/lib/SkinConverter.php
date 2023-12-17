<?php

namespace pulse\lib;

// pulse for saintengine, okey)

use const pocketmine\RESOURCE_PATH;

class SkinConverter
{

    public const SKIN_WIDTH_MAP = [
        64 * 32 * 4 => 64,
        64 * 64 * 4 => 64,
        128 * 128 * 4 => 128
    ];

    public const SKIN_HEIGHT_MAP = [
        64 * 32 * 4 => 32,
        64 * 64 * 4 => 64,
        128 * 128 * 4 => 128
    ];

    public static function pngToData(string $fileName): ?string
    {
        $path = RESOURCES_FOLDER . 'skins/' . $fileName . '.png';

        $image = imagecreatefrompng($path);

        $size = imagesx($image) * imagesy($image) * 4;

        $width = self::SKIN_WIDTH_MAP[$size];
        $height = self::SKIN_HEIGHT_MAP[$size];

        imagepalettetotruecolor($image);

        $data = "";
        for($y = 0; $y < $height; $y ++){
            for($x = 0; $x < $width; $x++){
                $rgba = imagecolorat($image, $x, $y);
                $a = ($rgba >> 24) & 0xff;
                $r = ($rgba >> 16) & 0xff;
                $g = ($rgba >> 8) & 0xff;
                $b = $rgba & 0xff;
                $data .= chr($r) . chr($g) . chr($b) . chr(~(($a << 1) | ($a >> 6)) & 0xff);
            }
        }
        imagedestroy($image);

        return $data;
    }

}