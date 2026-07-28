<?php

namespace MLMendes\LaravelReceitaWS;

use MLMendes\LaravelReceitaWS\Commands\LaravelReceitaWSCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelReceitaWSServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-receitaws')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations(['create_empresas_tables', 'create_receitaws_table'])
            ->hasCommand(LaravelReceitaWSCommand::class);
    }
}
