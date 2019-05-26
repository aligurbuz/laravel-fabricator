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

    /**
     * get fabric manager file name
     *
     * @return string
     */
    public function getFabricManagerFile()
    {
        return $this->getFabricDirectoryPath().''.DIRECTORY_SEPARATOR.'FabricManager.php';
    }

    /**
     * get factory manager stub file in console directory
     *
     * @return string
     */
    public function getFactoryManagerInStub()
    {
        return __DIR__.''.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Console'.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'FabricManager.stub';
    }
}
