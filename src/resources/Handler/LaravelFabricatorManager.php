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
        //first we create the fabricator directory.
        if(!$this->files->isDirectory($this->getFabricatorDirectoryPath())){

            // after making directory checks by using the files object..
            // that is registered in laravel container, we create a directory with the same object.
            $this->isCreated = $this->files->makeDirectory($this->getFabricatorDirectoryPath());

            $this->loadManagerFiles();

            if(!$this->isCreated){
                $this->files->deleteDirectory($this->getFabricatorDirectoryPath());
                throw new ManagerFilesCreatingException;
            }
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
    public function loadManagerFiles() : bool
    {
        if($this->files->exists($this->getFabricatorDirectoryPath())){
            foreach ($this->managerFiles as $file){

                $managerFile = 'get'.$file.'File';

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
