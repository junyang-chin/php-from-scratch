<?php

namespace App\Core;

use App\Core\Container\Exceptions\BindingNotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private static Container $instance;

    private $bindings = [];

    public function get(string $id)
    {
        if (! isset($this->bindings[$id])) {
            throw new BindingNotFoundException($id);
        }

        return $this->bindings[$id]();
    }

    public function has(string $id): bool
    {
        return isset($this->bindings[$id]);
    }
}
