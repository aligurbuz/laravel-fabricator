<?php

namespace Fabricator\Resource\Exception;

use Exception;

class FabricatorHandlingException extends Exception
{
    /**
     * @var string $message
     */
    protected $message = 'You must use cli to create a fabricator.';

    /**
     * @var int
     */
    protected $code = 401;
}