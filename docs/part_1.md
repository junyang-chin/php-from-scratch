# PHP-FROM-SCRATCH

## Part 1: Dependency Injection - implementing a Service Container

The service container embraces the "declare once, use everywhere" philosophy, serving as a registry for class bindings and their concrete implementations. It encapsulates the logic of resolving a class and provides a convenient interface for accessing service classes throughout your application without worrying about dependencies.

### Registering services

Before you can use the service container you must first define the bindings of container so it knows how to resolve them for you.
In `bootstrap/app.php`, you are provided with the `app\Container` class which has the following methods.

### The `bind` method

The first argument of is where you define a unique identifier. The second argument accepts either a simple string or a ` Closure`. The clousre receives and instance off `app\Container` for your convenience.

```php
$app->bind('foo', function (\app\Container $app)
   return 'bar'
);

```

### The `singleton` method

The singleton methodd works just like `bind`. The only difference is for the entire request lifecycle the `Clousre` will only be executed once.

```php
$app->singleton('foo', function (\app\Container $app)
    return 'bar';
);

```

### The `resolve` method
```php


```
### Auto dependency injection
