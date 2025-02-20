<?php

namespace Apility\Workiva\Facades;

use Illuminate\Support\Facades\Facade;
use Apility\Workiva\Client;

/**
 * @method static \Illuminate\Http\Client\Response get(string $uri, array $query = [])
 * @method static \Illuminate\Http\Client\Response post(string $uri, mixed $data = null, array $query = [])
 * @method static \Apility\Workiva\Client throwIf(\Closure $closure)
 * @method static \Apility\Workiva\Client dontThrow()
 * @method static \Illuminate\Http\Client\PendingRequest http()
 * @package Apility\Workiva\Facades
 * @see \Apility\Workiva\Client
 */
class Workiva extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Client::class;
    }
}
