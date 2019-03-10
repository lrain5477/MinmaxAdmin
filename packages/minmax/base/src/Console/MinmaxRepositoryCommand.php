<?php

namespace Minmax\Base\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MinmaxRepositoryCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'minmax:repository';

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
        return __DIR__.'/../../resources/stubs/repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $inputGuard = studly_case($this->option('guard'));
        $inputPackage = $this->option('package');

        if ($inputPackage == 'app') {
            return "{$rootNamespace}\\Repositories\\{$inputGuard}";
        } else {
            return "{$rootNamespace}\\{$inputGuard}";
        }
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $inputPackage = $this->option('package');

        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        if ($inputPackage == 'app') {
            return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . '.php';
        } else {
            return $this->laravel->basePath() . '\\packages\\' . str_replace('/', '\\', $inputPackage) . '\\src/' .
                str_replace('\\', '/', $name) . '.php';
        }
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceName($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $inputGuard = studly_case($this->option('guard'));

        $baseNamespace = 'Minmax\\Base\\' . $inputGuard;

        $modelNamespace = $this->rootNamespace() . 'Models';

        $stub = str_replace(
            ['DummyNamespace', 'DummyRootNamespace', 'DummyBaseNamespace', 'DummyModelNamespace'],
            [$this->getNamespace($name), $this->rootNamespace(), $baseNamespace, $modelNamespace],
            $stub
        );

        return $this;
    }

    /**
     * Replace the kinds of name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceName(&$stub, $name)
    {
        $tableName = snake_case(preg_replace('/Repository$/i', '', str_replace($this->getNamespace($name).'\\', '', $name)));

        $stub = str_replace(
            ['DummyTableName'],
            [$tableName],
            $stub
        );

        return $this;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $modelClass = preg_replace('/Repository$/i', '', $class);

        return str_replace(
            ['DummyClass', 'DummyModelClass'],
            [$class, $modelClass],
            $stub
        );
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        $inputPackage = $this->option('package');

        if ($inputPackage == 'app') {
            return parent::rootNamespace();
        } else {
            return str_replace(' ', '\\', title_case(str_replace('/', ' ', $inputPackage))) . '\\';
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['guard', null, InputOption::VALUE_OPTIONAL, 'Witch guard for generate', 'admin'],
            ['package', null, InputOption::VALUE_OPTIONAL, 'Can set your package path with lower case', 'app'],
        ];
    }
}
