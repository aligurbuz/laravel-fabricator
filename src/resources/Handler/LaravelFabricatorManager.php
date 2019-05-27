<?php

namespace Fabricator\Resource\Handler;

use Fabricator\Resource\Contracts\FactoryManagerContract;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class LaravelFabricatorManager extends FabricatorAbstract implements FactoryManagerContract
{
    /**
     * @return bool|mixed
     *
     * @throws FileNotFoundException
     */
    public function generate()
    {
        //first we create the fabric directory.
        $this->generateSkeletonFabricDirectory();

        return true;
    }

    /**
     * generate skeleton fabric directory
     *
     * @throws FileNotFoundException
     */
    protected function generateSkeletonFabricDirectory()
    {
        // after making directory checks by using the files object..
        // that is registered in laravel container, we create a directory with the same object.
        if(!$this->files->isDirectory($this->getFabricatorDirectoryPath())){
            $this->files->makeDirectory($this->getFabricatorDirectoryPath());

            // the fabricator manager classes will be created...
            // only once and will serve as the fabricator manager.
            if(!$this->files->isFile($this->getFabricatorManagerFile())){
                $fabricatorManagerStub = $this->files->get($this->getFabricatorManagerInStub());

                //the content of fabricatorManager.stub file will be write fabricatorManager file
                $this->files->put($this->getFabricatorManagerFile(),$fabricatorManagerStub);
            }
        }
    }
}
