<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CrudMakePresenter extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'crud:presenter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom crud presenter';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Presenter';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/presenter.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Presenters';
    }
}
