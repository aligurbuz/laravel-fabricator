<?php

namespace Fabricator\Resource\Exception;

use Exception;

class ManagerFilesCreatingException extends Exception
{
    /**
     * @var string $message
     */
    protected $message = 'An error occurred while creating the manager files.';

    /**
     * @var int
     */
    protected $code = 401;
}