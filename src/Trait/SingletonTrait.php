<?php

trait SingletonTrait
{
    protected static $instance = null;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}
