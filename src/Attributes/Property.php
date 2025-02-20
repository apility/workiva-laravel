<?php

namespace Apility\Workiva\Attributes;

use Attribute;
use Closure;
use Exception;

use Apility\Workiva\Concerns\SerializesProperty;
use Apility\Workiva\Contracts\PropertySerialization;
use Apility\Workiva\Types\Type;
use Apility\Workiva\Concerns\HasParent;
use Apility\Workiva\Types\XlsxOptions;
use BackedEnum;
use Carbon\CarbonImmutable;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Property implements PropertySerialization
{
    use SerializesProperty;

    public function __construct(public string $name, public string|null $type = null, protected bool $nullable = true, protected bool $collection = false, protected mixed $default = null, protected bool $serialize = true)
    {
        if ($this->default === null && $this->nullable === false) {
            $this->default = match ($this->type) {
                'array' => [],
                'bool' => false,
                'float' => 0.0,
                'int' => 0,
                'string' => '',
                default => null,
            };

            if ($this->default === null && $this->collection === true) {
                $this->default = [];
            }
        }
    }

    public function getDefaultValue(): mixed
    {
        return $this->default;
    }

    public function getPropertyHandler(Type $parent): Closure
    {
        return function (mixed $value) use ($parent): mixed {
            if ($this->nullable === true && $value === null) {
                return null;
            }

            if ($this->collection === true && $value === null) {
                return [];
            }

            if ($this->nullable === false && $value === null) {
                throw new Exception("Value for property '{$this->name}' cannot be null");
            }

            if ($this->collection === true && (!is_array($value) || !array_is_list($value))) {
                throw new Exception("Value for property '{$this->name}' must be an array");
            }

            if ($this->collection === true) {
                return collect($value)
                    ->map(fn($item) => $this->cast($item))
                    ->each(fn($item) => in_array(HasParent::class, class_uses_recursive($item)) ? $item->setParent($parent) : null);
            }

            return $this->cast($value);
        };
    }

    protected function cast(mixed $value): mixed
    {
        $type = $this->type ?? gettype($value);

        if (enum_exists($type)) {
            $type = 'enum';
        }

        if ($value instanceof BackedEnum) {
            $value = $value->value;
        }

        $castFn = match ($type) {
            'array' => fn($value) => (array) $value,
            'datetime', CarbonImmutable::class => fn($value): CarbonImmutable => CarbonImmutable::parse($value),
            'enum' => fn($value) => $this->type::from($value),
            default => fn() => class_exists($this->type) ? new $this->type($value) : $value,
        };

        return $castFn($value);
    }
}
