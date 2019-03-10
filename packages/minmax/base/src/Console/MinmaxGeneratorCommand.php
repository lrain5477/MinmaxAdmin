<?php

namespace Minmax\Base\Console;

use Illuminate\Console\Command;

class MinmaxGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minmax:generator
                            {name : Your class base name, best with studly case}
                            {method=crud : Can be "crud", "model", "controller"}
                            {--guard=admin : Witch guard for generate}
                            {--package=app : Can set your package path with lower case}';

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
     * @return void
     */
    public function handle()
    {
        $inputMethod = $this->argument('method');
        $inputName = $this->argument('name');
        $inputGuard = $this->option('guard');
        $inputPackage = $this->option('package');

        if ($inputMethod == 'crud' || $inputMethod == 'model') {
            $modelName = studly_case($inputName);
            $this->call('minmax:model', ['name' => $modelName, '--package' => $inputPackage]);
        }

        if ($inputMethod == 'crud' || $inputMethod == 'repository') {
            $requestName = studly_case($inputName) . 'Repository';
            $this->call('minmax:repository', ['name' => $requestName, '--guard' => $inputGuard, '--package' => $inputPackage]);
        }

        if ($inputMethod == 'crud' || $inputMethod == 'controller') {
            $controllerName = studly_case($inputName) . 'Controller';
            $this->call('minmax:controller', ['name' => $controllerName, '--guard' => $inputGuard, '--package' => $inputPackage]);
        }

        if ($inputMethod == 'crud' || $inputMethod == 'request') {
            $requestName = studly_case($inputName) . 'Request';
            $this->call('minmax:request', ['name' => $requestName, '--guard' => $inputGuard, '--package' => $inputPackage]);
        }

        if ($inputMethod == 'crud' || $inputMethod == 'presenter') {
            $requestName = studly_case($inputName) . 'Presenter';
            $this->call('minmax:presenter', ['name' => $requestName, '--guard' => $inputGuard, '--package' => $inputPackage]);
        }

        if ($inputMethod == 'crud' || $inputMethod == 'transformer') {
            $requestName = studly_case($inputName) . 'Transformer';
            $this->call('minmax:transformer', ['name' => $requestName, '--guard' => $inputGuard, '--package' => $inputPackage]);
        }

//        $viewName = kebab_case($inputName);
//        $this->call('crud:view', ['name' => $viewName]);
    }
}
