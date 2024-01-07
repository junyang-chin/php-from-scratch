<?php

namespace App\Container;

use App\Core\Container\Exceptions\BindingNotFoundException;
use Closure;
use Psr\Container\ContainerInterface as PsrContainer;
use ReflectionClass;
use ReflectionNamedType;

class Container implements PsrContainer
{
    private $bindings = [];

    private $singletons = [];

    public function get(string $id)
    {
        if (isset($this->bindings[$id])) {
            return $this->bindings[$id];
        }

        $this->autowire($id);
    }

    protected function autowire(string $id)
    {
        if (! class_exists($id)) {
            throw UnknownDependencyException::make($id);
        }

        $reflector = new ReflectionClass($id);
        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            $this->bind(
                $id,
                function () use ($id) {
                    return new $id();
                },
                false
            );

            return $this->get($id);
        }

        $parameters = $constructor->getParameters();

        $dependencies = [];
        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if (is_null($type)) {
                throw BindingNotFoundException::make($id);
            }

            if (! $type instanceof ReflectionNamedType) {
                throw BindingNotFoundException::make($id);
            }

            $dependencies[] = $this->resolve($type->getName(), []);
        }

        $this->bind(
            $id,
            function () use ($id, $dependencies) {
                return new $id(...$dependencies);
            },
            false
        );

        return $this->get($id);
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

        if (! $concrete instanceof Closure) {
            return $concrete;
        }

        if (! $this->shouldCache($abstract)) {
            return $this->instantiate($concrete, $params);
        }

        if (! $this->hasCache($abstract)) {
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
