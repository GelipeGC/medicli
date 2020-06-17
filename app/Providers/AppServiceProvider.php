<?php

namespace App\Providers;

use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->registerRepositoryInterfaces();

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
    /**
     * Register repository interfaces from config/repositories.php
     */
    protected function registerRepositoryInterfaces()
    {
        foreach (config('repositories') as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
