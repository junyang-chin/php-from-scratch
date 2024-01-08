# PHP-FROM-SCRATCH

## Part 1: Dependency Injection - implementing a Service Container

The service container embraces the "declare once, use everywhere" philosophy, serving as a registry for class bindings and their concrete implementations. It encapsulates the logic of resolving a class and provides a convenient interface for accessing service classes throughout your application without worrying about dependencies.

### Registering services
Before you can use the service container you must first define the bindings of your dependencies into the container so it knows how to resolve them for you.
In `bootstrap/app.php`, you are provided with the `app\Container` class which has the following methods.
### Obtaining an instance of the container
There is a helpful global function `app()` which returns only a single instances throughout the entire execution of the php script.
```php
$app = app();

get_class($app) // App\Container\Container
```
You should not attempt to manually attempt to resolve multiple instance of containers as there should only be a single source of truth for your entire application.

### The `bind` method

The first argument of is where you define a unique identifier. The second argument accepts either a simple string or a `Closure`. The closure receives an instance of `App\Container` that you for your convenience. It is up to you whether to use it or not

```php
$object = $app->bind('foo', function (App\Container\Container $app)
   return new App\Bar(); 
);
```

### The `singleton` method
The singleton methodd works just like `bind`. The only difference is for the entire request lifecycle the `Clousre` will only be executed once.

```php
$object = $app->singleton('foo', function (\App\Container\Container $app)
    return new App\Bar();
);
```

### The `resolve` method
Remember the `Closure` that you bound to the container before this? By calling the `resolve` method, the container executes it and returns the value to you.
```php
$app = app();

$bar = $app->resolve('foo'); 

get_class($bar); // "App\Bar"
```
### Auto wiring
Autowiring is a container feature that could recusrively attempt to resolve the dependencies even though they aren't explicitly defined using the methods above. However, it should be noted that classes with no dependencies or with conrete dependencies can be resolved.