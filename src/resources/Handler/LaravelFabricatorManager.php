<?php

namespace Fabricator\Resource\Handler;

use Fabricator\Resource\Contracts\FactoryManagerContract;

class LaravelFabricatorManager extends FabricatorAbstract implements FactoryManagerContract
{
    /**
     * @return mixed|string
     */
    public function generate()
    {
        //first we create the fabric directory.
        $this->makeSkeletonFabricDirectory();

        return true;
    }

    /**
     * generate skeleton fabric directory
     *
     * @return void
     */
    public function makeSkeletonFabricDirectory()
    {
        // after making directory checks by using the files object..
        // that is registered in laravel container, we create a directory with the same object.
        if(!$this->files->isDirectory($this->getFabricDirectoryPath())){
            $this->files->makeDirectory($this->getFabricDirectoryPath());
        }
    }
}
