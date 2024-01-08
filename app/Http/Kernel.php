<?php

namespace App\Http;

use Psr\Http\Message\ServerRequestInterface as Request;

class Kernel 
{
    public function __construct(protected Request $request)
    {
    }
}
