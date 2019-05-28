<?php

namespace Fabricator\Resource\Handler;

use Fabricator\Resource\Contracts\FabricatorManager;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class LaravelFabricatorManager extends FabricatorAbstract implements FabricatorManager
{
    /**
     * it generates a fabricator structure with all its everything.
     *
     * @return bool|mixed
     *
     * @throws FileNotFoundException
     */
    public function generate()
    {
        //first we create the fabricator directory.
        $this->generateManagerForFabricatorDirectory();

        return true;
    }

    /**
     * it generates manager files in fabricator directory.
     *
     * @return bool
     *
     * @throws FileNotFoundException
     */
    public function generateManagerForFabricatorDirectory() : bool
    {
        // after making directory checks by using the files object..
        // that is registered in laravel container, we create a directory with the same object.
        if(!$this->files->isDirectory($this->getFabricatorDirectoryPath())){
            $isCreatedFabricatorDirectoryPath = $this->files->makeDirectory($this->getFabricatorDirectoryPath());

            // the fabricator manager classes will be created only once...
            // and will serve as the fabricator manager.
            if($isCreatedFabricatorDirectoryPath && !$this->files->isFile($this->getFabricatorManagerFile())){
                $fabricatorManagerStub = $this->files->get($this->getFabricatorManagerInStub());

                //the content of fabricatorManager.stub file will be write fabricatorManager file
                return $this->files->put($this->getFabricatorManagerFile(),$fabricatorManagerStub) === false ?:  true;
            }
        }

        return false;
    }
}
