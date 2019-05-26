<?php

namespace Fabricator;

use Illuminate\Support\Facades\Facade;
use Fabricator\Resource\Contracts\FactoryManagerContract;
use Fabricator\Resource\Handler\LaravelFabricatorManager;

/**
 * @method static FactoryManagerContract generate
 *
 * @see LaravelFabricatorManager
 */
class Fabricator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fabricator';
    }
}
