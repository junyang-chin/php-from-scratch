<?php

namespace App\Core\Container;

use App\Core\Container\Exceptions\BindingNotFoundException;
use Closure;
use Psr\Container\ContainerInterface as PsrContainer;

class Container implements PsrContainer
{
    private $bindings = [];

    private $singletons = [];

    public function get(string $id)
    {
        if (!isset($this->bindings[$id])) {
            throw BindingNotFoundException::make($id);
        }

        return $this->bindings[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->bindings[$id]);
    }

    public function bind(string $abstract, Closure|string $concrete, bool $shouldCache = false): void
    {
        $this->bindings[$abstract] = ['concrete' => $concrete, 'shouldCache' => $shouldCache];
    }

    public function singleton(string $abstract, Closure|string $concrete): void
    {
        $this->bind($abstract, $concrete, true);
    }

    public function resolve(string $abstract, array $params = [])
    {
        $concrete = $this->get($abstract)['concrete'];

        if (!$concrete instanceof Closure) {
            return $concrete;
        }

        if (!$this->shouldCache($abstract)) {
            return $this->instantiate($concrete, $params);
        }

        if (!$this->hasCache($abstract)) {
            $this->singletons[$abstract] = $this->instantiate($concrete, $params);
        }

        return $this->singletons[$abstract];
    }

    private function shouldCache(string $abstract): bool
    {
        return $this->bindings[$abstract]['shouldCache'];
    }

    private function hasCache(string $abstract): bool
    {
        return array_key_exists($abstract, $this->singletons);
    }

    private function instantiate(Closure $concrete, array $params)
    {
        return call_user_func_array($concrete, [$this, ...$params]);
    }
}
