<?php

namespace Apility\Workiva\Enums;

enum Endpoint: string
{
    case V1 = '/platform/v1';
    case OAuth2 = '/iam/v1/oauth2';

    public function forBaseURL(BaseURL $baseUrl): string
    {
        return $baseUrl->buildURL($this->value);
    }
}
