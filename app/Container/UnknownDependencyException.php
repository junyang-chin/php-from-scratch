<?php

namespace App\Container;

use Exception;

class UnknownDependencyException extends Exception
{
    public static function make(string $dependency): static
    {
        return new self("Unable to automatically dependency : {$dependency}");
    }
}
