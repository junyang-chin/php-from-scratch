<?php

use App\Container\Container;
use App\Http\Kernel;
use App\Request\Request;
use Psr\Http\Message\ServerRequestInterface;

$app = app();

/**
 * --------------------------------------------------------------------
 * This is where you register all your bindings into the container
 * --------------------------------------------------------------------
 */

/**
 * Creates a request handler
 */
$app->singleton(Kernel::class, function (Container $app): Kernel {
    return new Kernel($app->resolve('request'));
});

/**
 * Creates a PSR-7 ServerRequestInterface implementation
 */
$app->singleton('request', function (): ServerRequestInterface {
    $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

    $creator = new \Nyholm\Psr7Server\ServerRequestCreator(
        $psr17Factory, // ServerRequestFactory
        $psr17Factory, // UriFactory
        $psr17Factory, // UploadedFileFactory
        $psr17Factory  // StreamFactory
    );

    return $creator->fromGlobals();
});

return $app;
