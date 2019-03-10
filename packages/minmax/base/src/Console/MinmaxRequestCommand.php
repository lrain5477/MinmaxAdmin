<?php

namespace Minmax\Base\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MinmaxRequestCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'minmax:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom crud request validator';

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
        return __DIR__.'/../../resources/stubs/request.stub';
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
            return "{$rootNamespace}\\Http\\Requests\\{$inputGuard}";
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
        $stub = str_replace(
            ['DummyNamespace', 'DummyRootNamespace'],
            [$this->getNamespace($name), $this->rootNamespace()],
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
        $inputGuard = $this->option('guard');
        $inputPackage = $this->option('package');

        $guardName = camel_case($inputGuard);

        $authorizeName = camel_case(preg_replace('/Request$/i', '', str_replace($this->getNamespace($name).'\\', '', $name)));

        if ($inputPackage == 'app') {
            $packageName = '';
        } else {
            $packageName = studly_case(str_replace('/', '_', $inputPackage)) . '::';
        }

        $stub = str_replace(
            ['DummyGuardName', 'DummyAuthorizeName', 'DummyPackageName'],
            [$guardName, $authorizeName, $packageName],
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
        $modelClass = preg_replace('/Request$/i', '', $class);

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
