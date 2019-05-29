<?php

namespace Fabricator\Resource\Handler;

use Fabricator\Resource\Contracts\FabricatorManager;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Fabricator\Resource\Exception\ManagerFilesCreatingException;

class LaravelFabricatorManager extends FabricatorAbstract implements FabricatorManager
{
    /**
     * generates fabricator manager files
     *
     * @var array
     */
    protected $managerFiles = ['FabricatorManager','FabricatorAbstract','FabricatorHelper'];

    /**
     * it generates a fabricator structure with all its everything.
     *
     * @return bool|mixed
     *
     * @throws FileNotFoundException
     * @throws ManagerFilesCreatingException
     */
    public function generate()
    {
        // first we create the fabricator directory.
        $this->setFabricatorDirectoryPath();

        // the manager files must be installed...
        // after the fabricator directory is created.
        $this->setManagerFiles($this->getFabricatorDirectoryPath(),$this->managerFiles);

        if(!$this->isCreated){
            $this->files->deleteDirectory($this->getFabricatorDirectoryPath());
            throw new ManagerFilesCreatingException;
        }

        return true;
    }

    /**
     * set fabricator directory path
     *
     * @return bool
     */
    public function setFabricatorDirectoryPath() : bool
    {
        //set fabricator directory
        if(!$this->files->isDirectory($this->getFabricatorDirectoryPath())){
            $this->isCreated = $this->files->makeDirectory($this->getFabricatorDirectoryPath());
        }

        return $this->isCreated;
    }
}
