<?php

namespace pulse\api;

use pocketmine\math\Vector3;
use pocketmine\world\particle\FlameParticle;
use pocketmine\world\particle\HeartParticle;
use pocketmine\world\particle\LavaParticle;
use pulse\api\format\ParticleFormat;
use pulse\api\format\PositionFormat;

class APIWorld
{

    /**
     * Спавнит указанный партикл на указанной позиции
     *
     * @param PositionFormat $pos
     * @param ParticleFormat $particle
     * @return void
     */
    public static function summonParticle(PositionFormat $pos, ParticleFormat $particle): void
    {
        switch($particle->particle){
            case 'world.particle.flame':
                APIPlayer::getWorld()->addParticle(
                    new Vector3($pos->x, $pos->y, $pos->z),
                    new FlameParticle()
                );
                break;
            case 'world.particle.heart':
                APIPlayer::getWorld()->addParticle(
                    new Vector3($pos->x, $pos->y, $pos->z),
                    new HeartParticle()
                );
                break;
            case 'world.particle.lava':
                APIPlayer::getWorld()->addParticle(
                    new Vector3($pos->x, $pos->y, $pos->z),
                    new LavaParticle()
                );
                break;
            case 'world.particle.unkown':
                break;
        }
    }

    public static function addLineParticle(PositionFormat $pos, ParticleFormat $particle, float $radius = 1): void
    {
        $vec = new Vector3($pos->x, $pos->y, $pos->z);

        $x = $vec->x;
        $z = $vec->z;

        for($i = 0; $i <= 360; $i += 1){
            $angle = $i * (M_PI / 180);

            $x1 = $radius * cos($angle);
            $z1 = $radius * sin($angle);

            self::summonParticle(new PositionFormat($x + $x1, $vec->y, $z + $z1), $particle);
        }
    }

}