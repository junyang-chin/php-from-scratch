<?php

use App\Core\Container\Container;
use App\Core\Http\Kernel;

$app = app();

/**
 * 
 * This is where you register all your bindings into the container
 * 
 */
$app->bind(Kernel::class, function (Container $app) {
    $app->bind('foo', function () {
        return 'bar';
    });

    return new Kernel();
});

return $app;