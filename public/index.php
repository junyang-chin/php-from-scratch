<?php

require __DIR__ . '/../vendor/autoload.php';

require __DIR__. '/../utils/helpers.php';


/**
 * 
 * Start the bootstrapping process. Obtain the service container
 * 
 */
$app = require __DIR__. '/../bootstrap/app.php';


$kernel = $app->resolve(\App\Core\Http\Kernel::class);

