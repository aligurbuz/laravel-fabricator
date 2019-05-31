<?php

namespace Fabricator;

use Illuminate\Support\ServiceProvider;
use Fabricator\Resource\Console\FabricatorCommand;
use Illuminate\Contracts\Support\DeferrableProvider;
use Fabricator\Resource\Handler\LaravelFabricatorManager;
use Fabricator\Resource\Handler\LaravelFabricatorResourceManager;

class LaravelFabricatorServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // with the name fabricator manager abstract,
        // we save the laravelFabricatorManager class to the container object as a singleton.
        $this->app->singleton('fabricator.manager',function($app,$arguments=array()){
            return new LaravelFabricatorManager($app,$arguments);
        });

        // with the name fabricator resource abstract,
        // we save the laravelFabricatorResourceManager class to the container object as a singleton.
        $this->app->singleton('fabricator.resource',function($app,$arguments=array()){
            return new LaravelFabricatorResourceManager($app,$arguments);
        });

        // with the help of console,
        // we define a class that allows you to create factory models.
        $this->commands([FabricatorCommand::class]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['fabricator.manager','fabricator.resource'];
    }
}
