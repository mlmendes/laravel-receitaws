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
            ->hasMigration('create_laravel_receitaws_table')
            ->hasCommand(LaravelReceitaWSCommand::class);
    }
}
