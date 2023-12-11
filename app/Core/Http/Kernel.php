<?php

namespace App\Core\Http;

class Kernel
{
    private static Kernel $instance = null;

    public static function getInstance(): static
    {
        if (! isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
