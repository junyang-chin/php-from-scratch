<?php

namespace App\Container\Exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface as PsrNotFoundException;

class BindingNotFoundException extends Exception implements PsrNotFoundException
{
    public static function make(string $id): static
    {
        return new static("Binding is not registered in container for {$id}");
    }
}
