<?php

namespace App\Core\Container;

use App\Core\Container\Exceptions\BindingNotFoundException;
use Closure;
use Psr\Container\ContainerInterface as PsrContainer;

class Container implements PsrContainer
{
    private $bindings = [];

    public function get(string $id)
    {
        if (! isset($this->bindings[$id])) {
            throw BindingNotFoundException::make($id);
        }

        return $this->bindings[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->bindings[$id]);
    }

    public function bind(string $abstract, Closure|string $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function resolve(string $abstract, array $params = [])
    {
        $concrete = $this->get($abstract);

        if (! $concrete instanceof Closure) {
            return $concrete;
        }

        return call_user_func_array($concrete, [$this, ...$params]);
    }
}
