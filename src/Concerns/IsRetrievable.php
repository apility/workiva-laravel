<?php

namespace Apility\Workiva\Concerns;

use Apility\Workiva\Facades\Workiva;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait IsRetrievable
{
    /**
     * @return string
     */
    protected static function guessEndpoint(): string
    {
        return Str::plural(
            Str::lower(
                class_basename(static::class)
            )
        );
    }

    /**
     * @return string
     */
    public static function getEndpoint(): string
    {
        if (method_exists(static::class, 'endpoint')) {
            return static::endpoint();
        }

        if (property_exists(static::class, 'endpoint')) {
            return static::$endpoint;
        }

        return static::guessEndpoint();
    }

    /**
     * @param string $id
     * @param array $query
     * @return static|null
     */
    public static function retrieve(string $id, array $query = ['$expand']): self|null
    {
        $response = Workiva::get(static::getEndpoint() . '/' . $id, $query);

        if ($response->status() === 404) {
            return null;
        }

        return new static($response->json());
    }

    /**
     * @param array $query
     * @return Collection<int, static>
     */
    public static function list(array $query = []): Collection
    {
        return collect(Workiva::get(static::getEndpoint())->json()['data'] ?? [])
            ->map(fn(array $attributes) => new static($attributes));
    }
}
