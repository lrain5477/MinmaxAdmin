<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CrudMakeRequest extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'crud:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom crud request';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/request.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Requests';
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
        $className = preg_replace('/Request$/i', '', str_replace($this->getNamespace($name).'\\', '', $name));
        $customPath = last(explode('\\', $this->getNamespace($name)));

        $replace = [
            'DummyModelClass' => $className,
            'DummyAuthorizeName' => camel_case($className),
            'DummyGuardName' => camel_case($customPath),
        ];

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }
}
