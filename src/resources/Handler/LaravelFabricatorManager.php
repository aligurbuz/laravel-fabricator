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
        if(!$this->files->isDirectory($this->getFabricDirectoryPath())){
            $this->files->makeDirectory($this->getFabricDirectoryPath());

            // the fabric manager classes will be created...
            // only once and will serve as the fabric manager.
            if(!$this->files->isFile($this->getFabricManagerFile())){
                $factoryManagerStub = $this->files->get($this->getFactoryManagerInStub());

                //the content of factoryManager.stub file will be write fabric manager file
                $this->files->put($this->getFabricManagerFile(),$factoryManagerStub);
            }
        }
    }
}
