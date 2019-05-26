<?php

namespace Fabricator\Resource\Handler;

use Fabricator\Resource\Contracts\FactoryManagerContract;

class LaravelFabricatorManager implements FactoryManagerContract
{
    /**
     * @return mixed|string
     */
    public function generate()
    {
        return app()->basePath();
    }
}
