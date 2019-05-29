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
     * isCreated information for file process
     *
     * @var bool
     */
    protected $isCreated = true;

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
     * @param bool $stub
     * @return string
     */
    public function getFabricatorManagerFile($stub=false)
    {
        if($stub){
            return $this->getFabricatorManagerInStub();
        }
        return implode(DIRECTORY_SEPARATOR,[$this->getFabricatorDirectoryPath(),'FabricatorManager.php']);
    }

    /**
     * get fabricator abstract file name
     *
     * @param bool $stub
     * @return string
     */
    public function getFabricatorAbstractFile($stub=false)
    {
        if($stub){
            return $this->getFabricatorAbstractInStub();
        }
        return implode(DIRECTORY_SEPARATOR,[$this->getFabricatorDirectoryPath(),'FabricatorAbstract.php']);
    }

    /**
     * get fabricator helper file name
     *
     * @param bool $stub
     * @return string
     */
    public function getFabricatorHelperFile($stub=false)
    {
        if($stub){
            return $this->getFabricatorHelperInStub();
        }
        return implode(DIRECTORY_SEPARATOR,[$this->getFabricatorDirectoryPath(),'FabricatorHelper.php']);
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

    /**
     * get fabricator helper stub file in console directory
     *
     * @return string
     */
    public function getFabricatorHelperInStub()
    {
        return implode(DIRECTORY_SEPARATOR,[__DIR__,'..','Console','stubs','FabricatorHelper.stub']);
    }

    /**
     * get fabricator source path
     *
     * @return string
     */
    public function getFabricatorSourcePath()
    {
        return implode(DIRECTORY_SEPARATOR,[$this->getFabricatorDirectoryPath(),
            ucfirst($this->arguments['fabricator'])]);
    }

    /**
     * get fabricator source manager file
     *
     * @param bool $stub
     * @return string
     */
    public function getFabricatorSourceManagerFile($stub=false)
    {
        if($stub){
            return $this->getFabricatorSourceManagerInStub();
        }
        return implode(DIRECTORY_SEPARATOR,[$this->getFabricatorSourcePath(),''.ucfirst($this->arguments['fabricator']).'Manager.php']);
    }

    /**
     * get fabricator source manager stub file in console directory
     *
     * @return string
     */
    public function getFabricatorSourceManagerInStub()
    {
        return implode(DIRECTORY_SEPARATOR,[__DIR__,'..','Console','stubs','FabricatorSourceManager.stub']);
    }

    /**
     * check if available console argument
     *
     * @param null|string $argument
     * @return bool
     */
    public function hasOption($argument=null)
    {
        return isset($this->arguments[$argument]);
    }

    /**
     * set directory path
     *
     * @return bool
     */
    public function setDirectoryPath($path) : bool
    {
        //set fabricator directory
        if(!$this->files->isDirectory($path)){
            $this->isCreated = $this->files->makeDirectory($path);
        }

        return $this->isCreated;
    }

    /**
     * get replacement variables
     *
     * @param array $replacement
     * @return array
     */
    public function replacementVariables($replacement=array())
    {
        $replacementVaribles = array_merge($this->arguments,$replacement);

        return array_map(function($item){
            return ucfirst($item);
        },$replacementVaribles);
    }

    /**
     * it generates manager files.
     *
     * @param $path
     * @param $files
     * @param array $replacement
     * @return bool
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function setManagerFiles($path,$files,$replacement=array()) : bool
    {
        //manager files can only be created if the fabricator directory is available.
        if($this->files->exists($path)){
            foreach ($files as $file){

                $managerFile = 'get'.$file.'File';

                // the manager files will be created
                // if the isCreated property is true and the file does not exist.
                if($this->isCreated && !$this->files->isFile($this->{$managerFile}())){
                    $managerStub = $this->files->get($this->{$managerFile}(true));

                    $this->isCreated = $this->files->put($this->{$managerFile}(),
                        $managerStub) === false ?:  true;

                    if($this->isCreated){

                        $replacementVariables = $this->replacementVariables($replacement);
                        $content = $this->files->get($this->{$managerFile}());

                        foreach ($replacementVariables as $key=>$replacementVariable){
                            $search = '/\['.$key.'\]/';
                            $replace = $replacementVariable;
                            $content = preg_replace($search,$replace,$content);
                        }

                        $this->files->replace($this->{$managerFile}(),$content);
                    }
                }
            }
        }

        return $this->isCreated;
    }
}
