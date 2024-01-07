<?php

require __DIR__ . '/../vendor/autoload.php';

require __DIR__. '/../utils/helpers.php';


/**
 *
 * Start the bootstrapping process. Get the service container
 *
 */
$app = require __DIR__. '/../bootstrap/app.php';


$kernel = $app->resolve(\App\Http\Kernel::class);
