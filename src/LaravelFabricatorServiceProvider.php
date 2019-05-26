<?php

namespace Fabricator;

use Illuminate\Support\ServiceProvider;
use Fabricator\Resource\Console\FabricatorCommand;
use Illuminate\Contracts\Support\DeferrableProvider;
use Fabricator\Resource\Handler\LaravelFabricatorManager;

class LaravelFabricatorServiceProvider extends ServiceProvider implements DeferrableProvider
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
        // this section, which can only be published for the console,
        // copies the fabric directory of the package into the app directory of your application.
        if($this->app->runningInConsole()){
            $this->publishes([__DIR__ . '/resources/Publish' => app_path()],'fabric');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['fabricator'];
    }
}
