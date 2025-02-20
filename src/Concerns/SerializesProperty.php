<?php

namespace Apility\Workiva\Concerns;

use Apility\Workiva\Attributes\Property;
use Apility\Workiva\Contracts\PropertySerializable;
use Apility\Workiva\Types\Type;
use BackedEnum;
use Carbon\CarbonImmutable;
use Closure;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

trait SerializesProperty
{
    public function getPropertySerializer(): Closure
    {
        /** @var Property $this */

        return function (mixed $value): mixed {
            if ($this->nullable === true && $value === null) {
                return null;
            }

            if ($this->collection === true && $value === null) {
                return [];
            }

            if ($this->nullable === false && $value === null) {
                throw new Exception("Value for property '{$this->name}' cannot be null");
            }

            if ($this->collection === true && (!array_is_list($value))) {
                throw new Exception("Value for property '{$this->name}' must be an array");
            }

            if ($this->collection === true) {
                collect($value)->map(fn($item) => $this->serializeProperty($item));
            }

            return $this->serializeProperty($value);
        };
    }

    public function serializeProperty(mixed $value): mixed
    {
        /** @var Property $this */

        if ($this->serialize === true) {
            if ($value instanceof BackedEnum) {
                return $value->value;
            }

            if ($value instanceof CarbonImmutable) {
                return $value->toIso8601ZuluString();
            }

            if ($value instanceof PropertySerializable) {
                return $value->propertySerialize();
            }

            if ($value instanceof Collection) {
                $value = $value->map(fn($item) => $item instanceof PropertySerializable ? $item->propertySerialize() : $item)->all();
            }

            if ($value === null) {
                if ($this->nullable === true) {
                    return null;
                }

                if ($this->default !== null) {
                    return $this->default;
                }

                if (is_subclass_of($this->type, Type::class)) {
                    return new $this->type([]);
                }

                return match ($this->type) {
                    'string' => '',
                    'int' => 0,
                    'double', 'float' => 0.0,
                    'bool', 'boolean' => false,
                    default => $value,
                };
            }
        }

        return $value;
    }
}
