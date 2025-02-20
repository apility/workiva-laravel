<?php

namespace Apility\Workiva\Auth;

use Illuminate\Support\Facades\Http;

use Apility\Workiva\Enums\BaseURL;
use Apility\Workiva\Enums\Endpoint;
use Apility\Workiva\Exceptions\Exception;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;

class OAuth2
{
    protected Endpoint $endpoint = Endpoint::OAuth2;

    protected function __construct(protected ClientCredentials $credentials)
    {
        //
    }

    protected function http(): PendingRequest
    {
        return Http::baseUrl(
            $this->endpoint->forBaseURL(
                BaseURL::forRegion(
                    $this->credentials->getRegion()
                )
            )
        )
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded;charset=UTF-8')
            ->asForm()
            ->throw();
    }

    /**
     * @return Token
     * @throws Exception  
     */
    public function getAccessToken(): Token
    {
        try {
            return Token::make($this->http()->post('token', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->credentials->getClientId(),
                'client_secret' => $this->credentials->getClientSecret(),
            ])->json());
        } catch (RequestException $e) {
            $response = $e->response->json();
            throw Exception::fromErrorCode($response['error'], $response['error_description']);
        }
    }

    public static function make(ClientCredentials $credentials): OAuth2
    {
        return new OAuth2($credentials);
    }
}
