<?php

namespace App\Core\Container\Exceptions;

use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class BindingNotFoundException implements NotFoundExceptionInterface
{
    public function __construct(protected string $id)
    {
    }

    public function getMessage(): string
    {
        return "Binding does not exist in container for {$this->id}";
    }

    public function getCode(): void
    {
    }

    public function getFile(): string
    {
    }

    public function getLine(): int
    {
    }

    public function getTrace(): array
    {
    }

    public function getTraceAsString(): string
    {
    }

    public function getPrevious(): Throwable|null
    {
    }

    public function __toString()
    {
    }
}
