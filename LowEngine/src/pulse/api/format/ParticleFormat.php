<?php

namespace pulse\api\format;

class ParticleFormat
{

    public string $particle;

    public function __construct(string $particleName)
    {
        $this->particle = $particleName;
    }

}