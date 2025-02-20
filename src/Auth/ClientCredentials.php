<?php

namespace Apility\Workiva\Auth;

use Apility\Workiva\Enums\Region;

class ClientCredentials
{
    protected function __construct(protected string $clientId, protected string $clientSecret, protected Region $region)
    {
        //
    }

    public function getRegion(): Region
    {
        return $this->region;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public static function make(string $clientId, string $clientSecret, Region|string|null $region = null): ClientCredentials
    {
        if ($region && !($region instanceof Region)) {
            $region = Region::from($region);
        }

        return new ClientCredentials($clientId, $clientSecret, $region ?? Region::EU);
    }
}
