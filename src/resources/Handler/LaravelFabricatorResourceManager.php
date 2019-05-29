<?php

namespace Fabricator\Resource\Handler;

use Fabricator\Resource\Contracts\FabricatorManager;

class LaravelFabricatorResourceManager extends FabricatorAbstract implements FabricatorManager
{
    /**
     * generates fabricator source files
     *
     * @var array
     */
    protected $sourceFiles = ['FabricatorSourceManager'];

    /**
     * isCreated information for file process
     *
     * @var bool
     */
    protected $isCreated = true;

    /**
     * it generates a fabricator source with all its everything.
     *
     * @return bool|mixed
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function generate()
    {
        // first we create the fabricator source directory.
        $this->setFabricatorSourcePath();

        // the source manager files must be installed...
        // after the fabricator source directory is created.
        $this->setFabricatorSourceManagerFiles();

        if(!$this->isCreated){
            $this->files->deleteDirectory($this->getFabricatorSourcePath());
            //throw new ManagerFilesCreatingException;
        }

        return true;
    }

    /**
     * set fabricator directory path
     *
     * @return bool
     */
    public function setFabricatorSourcePath() : bool
    {
        //set fabricator source directory
        if($this->files->isDirectory($this->getFabricatorDirectoryPath())
            && !$this->files->exists($this->getFabricatorSourcePath())){
            $this->isCreated = $this->files->makeDirectory($this->getFabricatorSourcePath());
        }

        return $this->isCreated;
    }

    /**
     * it generates source files in fabricator source directory.
     *
     * @return bool
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function setFabricatorSourceManagerFiles() : bool
    {
        //manager files can only be created if the fabricator directory is available.
        if($this->files->exists($this->getFabricatorSourcePath())){
            foreach ($this->sourceFiles as $file){

                $managerFile = 'get'.$file.'File';

                // the manager files will be created
                // if the isCreated property is true and the file does not exist.
                if($this->isCreated && !$this->files->isFile($this->{$managerFile}())){
                    $managerStub = $this->files->get($this->{$managerFile}(true));

                    $this->isCreated = $this->files->put($this->{$managerFile}(),
                        $managerStub) === false ?:  true;
                }
            }
        }

        return $this->isCreated;
    }
}
