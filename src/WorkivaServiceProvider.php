<?php

namespace Apility\Workiva;

use Apility\Workiva\Auth\ClientCredentials;
use Apility\Workiva\Enums\Region;
use Illuminate\Support\ServiceProvider;

class WorkivaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $configPath = realpath(__DIR__ . '/../config/workiva.php');

        $this->mergeConfigFrom($configPath, 'workiva');
        $this->publishes([$configPath => $this->app->configPath('workiva.php')], 'config');

        $this->app->bind(Client::class, function () {
            return new Client(
                ClientCredentials::make(
                    clientId: $this->app['config']->get('workiva.client_id'),
                    clientSecret: $this->app['config']->get('workiva.client_secret'),
                    region: Region::from($this->app['config']->get('workiva.region', 'eu'))
                )
            );
        });
    }

    public function boot()
    {
        //
    }
}
