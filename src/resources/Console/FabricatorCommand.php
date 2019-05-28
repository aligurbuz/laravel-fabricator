<?php

namespace Fabricator\Resource\Console;

use Fabricator\Resource\Handler\LaravelFabricatorManager;
use Illuminate\Console\Command;

class FabricatorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:fabricator {--fabricator= : creates any fabricator class}
                                            {--resource= : creates any resource in fabricator class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Fabricator Model For Laravel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        /** @var LaravelFabricatorManager $fabricator */
        $fabricator = app('fabricator',$this->options());

        $this->info($fabricator->generate());
    }
}
