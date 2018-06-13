<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeListItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:itemlist {name} {guard=Admin} {--controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Item for NAV';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function parseName($name)
    {
        return $name;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $name = $this->argument('name');
        $guard = $this->argument('guard');

        $guard_lower = strtolower($guard);
        $name_lower = strtolower($name);
        
        $parseName = $this->parseName($name);

        // create Model
        $this->call('make:Model' , [
            'name' => '\\Models\\' . $parseName
        ]);

        // create presenter
        $this->call('make:presenter' , [
            'name' => '\\' . $guard . '\\' . $parseName
        ]);
        // create transformer
        $this->call('make:transformer' , [
            'name' =>  '\\' . $guard . '\\' . $parseName
        ]);
        $controller = $this->option('controller');
        // create controller user --Controller
        if($controller) {
            $this->call('make:controller' , [
                'name' => '\\' . $guard . '\\' . $parseName ,
                '-r' => true,
            ]);
        }
        $dir_path = resource_path('views/' . $guard_lower . '/' . $name_lower);
        // create CRUD view
        \File::makeDirectory($dir_path , "0777", true, true);
        \File::put($dir_path . '/index.blade.php' , "");
        \File::put($dir_path . '/create.blade.php' , "");
        \File::put($dir_path . '/edit.blade.php' , "");
        \File::put($dir_path . '/view.blade.php' ,"");

    }
}

