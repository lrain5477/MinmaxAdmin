<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CrudMakeRepository extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'crud:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom crud repository';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories';
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $className = preg_replace('/Repository$/i', '', str_replace($this->getNamespace($name).'\\', '', $name));

        $replace = [
            'DummyModelClass' => $className,
            'DummyTableName' => snake_case($className),
        ];

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }
}
