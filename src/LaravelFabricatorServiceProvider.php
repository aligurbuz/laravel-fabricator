<?php

namespace Fabricator;

use Illuminate\Support\ServiceProvider;
use Fabricator\Resource\Console\FabricatorCommand;
use Fabricator\Resource\Handler\LaravelFabricatorManager;

class LaravelFabricatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // with the name fabricator abstract,
        // we save the laravelFabricatorManager class to the container object as a singleton.
        $this->app->singleton('fabricator',function(){
            return new LaravelFabricatorManager();
        });

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
