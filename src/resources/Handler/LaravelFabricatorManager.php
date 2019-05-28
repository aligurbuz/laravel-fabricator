<?php

namespace Fabricator\Resource\Handler;

use Fabricator\Resource\Contracts\FabricatorManager;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Fabricator\Resource\Exception\ManagerFilesCreatingException;

class LaravelFabricatorManager extends FabricatorAbstract implements FabricatorManager
{
    /**
     * fabricator manager files
     *
     * @var array
     */
    protected $managerFiles = ['FabricatorManager','FabricatorAbstract'];

    /**
     * isCreated information for file process
     *
     * @var bool
     */
    protected $isCreated = false;

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
        $this->setFabricatorManagerFiles();

        if(!$this->isCreated){
            $this->files->deleteDirectory($this->getFabricatorDirectoryPath());
            throw new ManagerFilesCreatingException;
        }

        return true;
    }

    /**
     * it generates manager files in fabricator directory.
     *
     * @return bool
     *
     * @throws FileNotFoundException
     */
    public function setFabricatorManagerFiles() : bool
    {
        //manager files can only be created if the fabricator directory is available.
        if($this->files->exists($this->getFabricatorDirectoryPath())){
            foreach ($this->managerFiles as $file){

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
