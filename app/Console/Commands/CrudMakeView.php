<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class CrudMakeView extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'crud:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom crud views';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Crud views';

    /**
     * Get the stub file for the generator.
     *
     * @return array
     */
    protected function getStub()
    {
        return [
            'index' => __DIR__.'/stubs/index.blade.stub',
            'view' => __DIR__.'/stubs/view.blade.stub',
            'create' => __DIR__.'/stubs/create.blade.stub',
            'edit' => __DIR__.'/stubs/edit.blade.stub',
        ];
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $name = $this->getNameInput();

        $paths = $this->getPath($name);

        foreach ($paths as $typeKey => $path) {
            if (!is_null($this->option('only')) && $this->option('only') !== $typeKey) continue;

            // First we will check to see if the class already exists. If it does, we don't want
            // to create the class and overwrite the user's code. So, we will bail out so the
            // code is untouched. Otherwise, we will continue generating this class' files.
            if ((!$this->hasOption('force') || !$this->option('force')) && $this->alreadyExists($path)) {
                $this->error($typeKey.'.blade.php already exists!');

                return false;
            }

            // Next, we will generate the path to the location where this class' file should get
            // written. Then, we will build the class and make the proper replacements on the
            // stub files so that it gets the correctly formatted namespace and class name.
            $this->makeDirectory($path);

            $this->files->put($path, $this->buildView($name, $typeKey));
        }

        $this->info($this->type.' created successfully.');
    }

    /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        return $this->files->exists($rawName);
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return array
     */
    protected function getPath($name)
    {
        $basePath = $this->laravel['path'].'/../resources/views/';
        $name = str_replace('/-', '/', kebab_case($name));

        return [
            'index' => $basePath.$name.'/index.blade.php',
            'view' => $basePath.$name.'/view.blade.php',
            'create' => $basePath.$name.'/create.blade.php',
            'edit' => $basePath.$name.'/edit.blade.php',
        ];
    }

    /**
     * Build the view with the given name.
     *
     * @param  string  $name
     * @param  string  $type
     * @return string|null
     */
    protected function buildView($name, $type)
    {
        try {
            $stubs = $this->getStub();
            $stub = $this->files->get($stubs[$type] ?? '');

            $className = last(explode('/', $name));
            $adminClassName = str_replace('/'.$className, '', $name);

            $replace = [
                'DummyModelClass' => $className,
                'DummyModelVariable' => camel_case($className),
                'DummyAdminClass' => $adminClassName,
                'DummyGuardName' => camel_case($adminClassName),
            ];

            return str_replace(
                array_keys($replace), array_values($replace), $stub
            );
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['only', null, InputOption::VALUE_OPTIONAL, 'The type you only need'],
        ];
    }
}
