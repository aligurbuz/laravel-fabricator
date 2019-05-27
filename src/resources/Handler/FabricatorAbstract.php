<?php

namespace Fabricator\Resource\Handler;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Foundation\Application;
use Fabricator\Resource\Exception\FabricatorHandlingException;

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
     *
     * @throws FabricatorHandlingException
     */
    public function __construct(Application $app)
    {
        if($app->runningInConsole()===false){
            throw new FabricatorHandlingException;
        }

        $this->app = $app;

        $this->files = $this->app['files'];

        $this->fabricPath = app_path();
    }

    /**
     * get fabric directory path
     *
     * @return string
     */
    public function getFabricatorDirectoryPath()
    {
        return implode(DIRECTORY_SEPARATOR,[$this->fabricPath,'Fabricator']);
    }

    /**
     * get fabricator manager file name
     *
     * @return string
     */
    public function getFabricatorManagerFile()
    {
        return implode(DIRECTORY_SEPARATOR,[$this->getFabricatorDirectoryPath(),'FabricatorManager.php']);
    }

    /**
     * get fabricator manager stub file in console directory
     *
     * @return string
     */
    public function getFabricatorManagerInStub()
    {
        return implode(DIRECTORY_SEPARATOR,[__DIR__,'..','Console','stubs','FabricatorManager.stub']);
    }
}
