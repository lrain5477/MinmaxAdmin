<?php

namespace Minmax\Base;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Minmax\Base\Console\MinmaxControllerCommand;
use Minmax\Base\Console\MinmaxGeneratorCommand;
use Minmax\Base\Console\MinmaxModelCommand;
use Minmax\Base\Console\MinmaxPresenterCommand;
use Minmax\Base\Console\MinmaxRepositoryCommand;
use Minmax\Base\Console\MinmaxRequestCommand;
use Minmax\Base\Console\MinmaxTransformerCommand;

class CommandServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('command.minmax.generator', function () {
            return new MinmaxGeneratorCommand();
        });

        $this->app->singleton('command.minmax.model', function ($app) {
            return new MinmaxModelCommand($app['files']);
        });

        $this->app->singleton('command.minmax.repository', function ($app) {
            return new MinmaxRepositoryCommand($app['files']);
        });

        $this->app->singleton('command.minmax.controller', function ($app) {
            return new MinmaxControllerCommand($app['files']);
        });

        $this->app->singleton('command.minmax.request', function ($app) {
            return new MinmaxRequestCommand($app['files']);
        });

        $this->app->singleton('command.minmax.presenter', function ($app) {
            return new MinmaxPresenterCommand($app['files']);
        });

        $this->app->singleton('command.minmax.transformer', function ($app) {
            return new MinmaxTransformerCommand($app['files']);
        });

        $this->commands(
            'command.minmax.generator',
            'command.minmax.model',
            'command.minmax.repository',
            'command.minmax.controller',
            'command.minmax.request',
            'command.minmax.presenter',
            'command.minmax.transformer'
        );

    }
}
