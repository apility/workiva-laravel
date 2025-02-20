<?php

namespace Apility\Workiva\Exceptions;

use Throwable;

class Exception extends \Exception
{
    public static function fromErrorCode(string $errorCode, string|null $errorDescription = null, Throwable $previous = null): self
    {
        return match ($errorCode) {
            'invalid_client' => new InvalidClient($errorDescription, previous: $previous),
            default => new static($errorDescription, previous: $previous),
        };
    }
}
