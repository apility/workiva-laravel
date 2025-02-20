<?php

namespace Apility\Workiva\Concerns;

use ReflectionClass;
use Apility\Workiva\Attributes\Property;

trait HasAttributes
{
    protected array $properties = [];
    protected array $handlers = [];
    protected array $serializers = [];

    public function __construct(protected array $attributes = [])
    {
        $this->bootHasAttributes();
    }

    public function __get(string $name)
    {
        $value = $this->attributes[$name] ?? null;

        if ($value === null && method_exists($this, $method = 'get' . ucfirst($name) . 'Attribute')) {
            $value = $this->{$method}($value);
        }

        if ($value === null && $property = $this->getProperty($name)) {
            $value = $property?->getDefaultValue();
        }

        if (isset($this->handlers[$name])) {
            return $this->handlers[$name]($value);
        }

        return $value;
    }

    public function __isset(string $name): bool
    {
        if (isset($this->attributes[$name])) {
            return true;
        }

        if (method_exists($this, $method = 'get' . ucfirst($name) . 'Attribute')) {
            return $this->{$method}() !== null;
        }

        if (isset($this->handlers[$name])) {
            return $this->handlers[$name]($this->attributes[$name]) !== null;
        }

        return false;
    }

    public function propertySerialize(): array
    {
        return collect($this->properties)
            ->mapWithKeys(fn($property) => [$property->name => $property->serializeProperty($this->{$property->name})])
            ->all();
    }

    protected function getProperty(string $name): ?Property
    {
        return $this->properties[$name] ?? null;
    }

    protected function bootHasAttributes(): void
    {
        $reflection = new ReflectionClass($this);
        $attributes = $reflection->getAttributes();

        foreach ($attributes as $attribute) {
            if ($attribute->getName() === Property::class) {
                $attribute = $attribute->newInstance();
                /** @var Property $property */
                $property = $attribute;
                $this->properties[$property->name] = $property;
                $this->handlers[$property->name] = $property->getPropertyHandler($this);
                $this->serializers[$property->name] = $property->getPropertySerializer();
            }
        }
    }
}
