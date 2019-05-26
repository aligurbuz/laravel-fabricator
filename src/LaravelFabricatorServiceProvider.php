<?php

namespace Fabricator;

use Illuminate\Support\ServiceProvider;
use Fabricator\Resource\Console\FabricatorCommand;

class LaravelFabricatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // with the help of console,
        // we define a class that allows you to create factory models.
        $this->commands([FabricatorCommand::class]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
