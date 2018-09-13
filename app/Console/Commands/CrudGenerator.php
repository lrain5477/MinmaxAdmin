<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generator {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new crud feature';

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
     * @return mixed
     */
    public function handle()
    {
        $inputName = $this->argument('name');

        $controllerName = $inputName . 'Controller';
        $modelName = last(explode('/', $inputName));
        $requestName = $inputName . 'Request';
        $presenterName = $inputName . 'Presenter';
        $repositoryName = $inputName . 'Repository';
        $transformerName = $inputName . 'Transformer';
        $viewName = $inputName;

        $this->call('crud:controller', ['name' => $controllerName]);
        $this->call('crud:model', ['name' => $modelName]);
        $this->call('crud:request', ['name' => $requestName]);
        $this->call('crud:presenter', ['name' => $presenterName]);
        $this->call('crud:repository', ['name' => $repositoryName]);
        $this->call('crud:transformer', ['name' => $transformerName]);
        $this->call('crud:view', ['name' => $viewName]);
    }
}
