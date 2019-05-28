<?php

namespace Fabricator\Resource\Handler;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Foundation\Application;
use Fabricator\Resource\Exception\FabricatorHandlingException;
use Fabricator\Resource\Exception\LaravelContainerFilesystemException;

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
     * @var array
     */
    protected $arguments;

    /**
     * FabricatorAbstract constructor.
     * @param Application $app
     *
     * @param array $arguments
     * @throws FabricatorHandlingException
     * @throws LaravelContainerFilesystemException
     */
    public function __construct(Application $app,$arguments=array())
    {
        if($app->runningInConsole() === false){
            throw new FabricatorHandlingException;
        }

        $this->app = $app;

        if($this->app['files'] instanceof Filesystem === false ){
            throw new LaravelContainerFilesystemException;
        }

        $this->files = $this->app['files'];

        $this->fabricPath = app_path();

        $this->arguments = $arguments;
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
     * get fabricator abstract file name
     *
     * @return string
     */
    public function getFabricatorAbstractFile()
    {
        return implode(DIRECTORY_SEPARATOR,[$this->getFabricatorDirectoryPath(),'FabricatorAbstract.php']);
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

    /**
     * get fabricator abstract stub file in console directory
     *
     * @return string
     */
    public function getFabricatorAbstractInStub()
    {
        return implode(DIRECTORY_SEPARATOR,[__DIR__,'..','Console','stubs','FabricatorAbstract.stub']);
    }
}
