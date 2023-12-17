<?php

namespace pulse\api\format;

class ItemFormat
{

    public int $id;
    public int $meta;
    public int $count;

    public function __construct(int $id, int $meta = 0, int $count = 1)
    {
        $this->id = $id;
        $this->meta = $meta;
        $this->count = $count;
    }

}