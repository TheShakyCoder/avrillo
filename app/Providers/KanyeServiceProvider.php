<?php

namespace App\Providers;

use App\Contracts\KanyeInterface;
use App\Services\KanyeService;
use Illuminate\Support\ServiceProvider;

class KanyeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(KanyeInterface::class, KanyeService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
