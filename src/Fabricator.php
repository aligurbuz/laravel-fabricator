<?php

namespace Fabricator;

use Illuminate\Support\Facades\Facade;

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
