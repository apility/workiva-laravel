<?php

namespace Apility\Workiva\Exceptions;

class InvalidClient extends Exception
{
    public static function invalidRegion(string $region): self
    {
        return new self("Invalid region: {$region}");
    }
}
