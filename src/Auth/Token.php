<?php

namespace Apility\Workiva\Auth;

use Carbon\CarbonImmutable;
use DateTimeInterface;

class Token
{
    protected function __construct(protected string $type, protected string $accessToken, protected CarbonImmutable $expiresAt, protected array $scopes = [])
    {
        //
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getToken(): string
    {
        return $this->accessToken;
    }

    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function getExpiresAt(): DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function hasExpired(): bool
    {
        return $this->expiresAt->isPast();
    }

    public static function make(array $response): self
    {
        return new static(
            type: $response['token_type'] ?? '',
            accessToken: $response['access_token'] ?? '',
            scopes: isset($response['scope']) ? explode(' ', $response['scope']) : [],
            expiresAt: CarbonImmutable::parse('@' . (time() + $response['expires_in'] ?? 0))
        );
    }
}
