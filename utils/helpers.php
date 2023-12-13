<?php

function app()
{
    static $container = null;

    if (is_null($container)) {
        $container = new \App\Core\Container\Container();
    }

    return $container;
}
