<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakePresenter extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:presenter {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a presenterClass';

    protected $type = 'Presenters';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected function getStub()
    {
        return __DIR__ . '/../stubs/presenter.stub';
    }
    /**
     * Get the default namespace for the class
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Presenters';
    }
    /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);
        return str_replace('$dummy', '$' . strtolower($this->getNameInput()), $stub);
    }
    /**
     * Append "Transformer" to name input.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        return parent::getPath($name . 'Presenters');
    }
}
