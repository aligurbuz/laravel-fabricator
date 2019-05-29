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
     * it generates a fabricator source with all its everything.
     *
     * @return bool|mixed
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function generate()
    {
        // first we create the fabricator source directory.
        $this->setDirectoryPath($this->getFabricatorSourcePath());

        // the source manager files must be installed...
        // after the fabricator source directory is created.
        $this->setManagerFiles($this->getFabricatorSourcePath(),$this->sourceFiles);

        if(!$this->isCreated){
            $this->files->deleteDirectory($this->getFabricatorSourcePath());
            //throw new ManagerFilesCreatingException;
        }

        return true;
    }
}
