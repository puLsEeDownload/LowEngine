<?php

namespace pulse\master;

trait InstanceMaster
{

    private static self $instance;

    public static function getInstance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

}