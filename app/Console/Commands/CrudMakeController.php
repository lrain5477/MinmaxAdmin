<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CrudMakeController extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'crud:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom crud controller';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/controller.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
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
        $repositoryName = preg_replace('/Controller$/i', 'Repository', str_replace($this->getNamespace($name).'\\', '', $name));
        $repositoryPath = preg_replace('/Controller$/i', 'Repository', str_replace($this->getDefaultNamespace(trim($this->rootNamespace(), '\\')).'\\', '', $name));

        $replace = [
            'DummyRepositoryVariable' => camel_case($repositoryName),
            'DummyRepositoryPath' => $repositoryPath,
            'DummyRepositoryClass' => $repositoryName,
        ];

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }
}
