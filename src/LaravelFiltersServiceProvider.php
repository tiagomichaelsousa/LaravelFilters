<?php

namespace tiagomichaelsousa\LaravelFilters;

use Illuminate\Support\ServiceProvider;
use tiagomichaelsousa\LaravelFilters\Commands\NewFilterCommand;

class LaravelFiltersServiceProvider extends ServiceProvider
{
    /**
     * The console commands.
     *
     * @var array
     */
    protected $commands = [
        NewFilterCommand::class,
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-filters.php', 'laravel-filters');
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravel-filters.php' => config_path('laravel-filters.php'),
        ], 'config');

        // Registering package commands.
        $this->commands($this->commands);
    }
}
