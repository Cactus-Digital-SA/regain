<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OpenAI;
use OpenAI\Client;

class OpenAIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function ($app) {
            return OpenAI::client(config('services.openai.api_key'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
