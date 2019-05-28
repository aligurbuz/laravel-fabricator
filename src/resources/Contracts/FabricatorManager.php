<?php

namespace Fabricator\Resource\Contracts;

interface FabricatorManager
{
    /**
     * @param $arguments
     * @return mixed
     */
    public function generate($arguments);
}
