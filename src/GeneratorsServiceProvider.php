<?php

namespace AmestSantim\Generators;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSeedGenerator();
    }

    /**
     * Register the make:seed generator.
     */
    private function registerSeedGenerator()
    {
        $this->app->singleton('command.amestsantim.seed', function ($app) {
            return $app['AmestSantim\Generators\SeedMakeCommand'];
        });

        $this->commands('command.amestsantim.seed');
    }
}
