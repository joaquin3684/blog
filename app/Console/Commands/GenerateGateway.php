<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class GenerateGateway extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:gateway';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a gateway class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Gateway';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() === false) {
            return;
        }

    }


    protected function replaceClass($stub, $name)
    {
        $class = $this->argument('name');
        $j = explode('Gateway', $class);
        $p = str_replace('DummyClass', $class, $stub);
        return str_replace('DummyModel', $j[0], $p);

    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../Stubs/gateway.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories\Eloquent\Repos\Gateway';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    /* protected function getOptions()
     {
         return [
             ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the model already exists.'],

             ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model.'],

             ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the model.'],

             ['resource', 'r', InputOption::VALUE_NONE, 'Indicates if the generated controller should be a resource controller.'],
         ];
     }*/
}
