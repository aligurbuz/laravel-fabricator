<?php

namespace Fabricator\Resource\Exception;

use Exception;

class LaravelContainerFilesystemException extends Exception
{
    /**
     * @var string $message
     */
    protected $message = 'The files object is not registered in the container, for example, in the instance of the bind object.';

    /**
     * @var int
     */
    protected $code = 401;
}