<?php

namespace Fabricator\Resource\Handler;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Foundation\Application;

abstract class FabricatorAbstract
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var string
     */
    protected $fabricPath;

    /**
     * FabricatorAbstract constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->files = $this->app['files'];

        $this->fabricPath = app_path();
    }

    /**
     * get fabric directory path
     *
     * @return string
     */
    public function getFabricDirectoryPath()
    {
        return $this->fabricPath.''.DIRECTORY_SEPARATOR.'Fabric';
    }
}
