<?php

use App\Core\Container\Container;
use App\Core\Http\Kernel;

$app = app();

/**
 *
 * This is where you register all your bindings into the container
 *
 */
$app->singleton(Kernel::class, function () {
    return new Kernel();
});

return $app;
