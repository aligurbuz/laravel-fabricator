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
        $isCreatedFabricatorManagerFile = false;

        // after making directory checks by using the files object..
        // that is registered in laravel container, we create a directory with the same object.
        if(!$this->files->isDirectory($this->getFabricatorDirectoryPath())){
            $isCreatedFabricatorDirectoryPath = $this->files->makeDirectory($this->getFabricatorDirectoryPath());

            //this creates fabricatorManager.php
            if($isCreatedFabricatorDirectoryPath && !$this->files->isFile($this->getFabricatorManagerFile())){
                $fabricatorManagerStub = $this->files->get($this->getFabricatorManagerInStub());
                $isCreatedFabricatorManagerFile = $this->files->put($this->getFabricatorManagerFile(),$fabricatorManagerStub) === false ?:  true;
            }

            //this creates fabricatorAbstract.php
            if($isCreatedFabricatorManagerFile && !$this->files->isFile($this->getFabricatorAbstractFile())){
                $fabricatorAbstractStub = $this->files->get($this->getFabricatorAbstractInStub());
                return $this->files->put($this->getFabricatorAbstractFile(),$fabricatorAbstractStub) === false ?:  true;
            }
        }

        return false;
    }
}
