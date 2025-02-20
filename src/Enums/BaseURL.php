<?php

namespace Apility\Workiva\Enums;

enum BaseURL: string
{
    case US = 'https://api.app.wdesk.com';
    case EU = 'https://api.eu.wdesk.com';
    case APAC = 'https://api.apac.wdesk.com';

    public static function forRegion(Region $region): BaseURL
    {
        return match ($region) {
            Region::US => static::US,
            Region::EU => static::EU,
            Region::APAC => static::APAC,
        };
    }

    public function buildURL(string|null $path = null): string
    {
        return sprintf('%s/%s', rtrim($this->value, '/'), trim($path, '/'));
    }
}
