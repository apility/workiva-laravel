<?php

namespace Apility\Workiva\Types;

use JsonSerializable;

use Apility\Workiva\Concerns\HasAttributes;
use Apility\Workiva\Contracts\PropertySerializable;

abstract class Type implements PropertySerializable, JsonSerializable
{
    use HasAttributes;

    public function isDigest(): bool
    {
        if (array_key_exists('id', $this->attributes)) {
            return count($this->attributes) === 1;
        }

        return false;
    }

    public function jsonSerialize(): mixed
    {
        return $this->propertySerialize();
    }
}
