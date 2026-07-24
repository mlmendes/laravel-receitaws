<?php

namespace MLMendes\LaravelReceitaWS;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ReceitaWSServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-receitaws')
            ->hasMigrations([
                'create_empresas_tables',
                'create_receitaws_table',
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishMigrations()
                    ->askToStarRepoOnGitHub('mlmendes/laravel-receitaws');
            });
    }

    public function packageRegistered()
    {
        $this->app->singleton('ReceitaWS', function ($app) {
            return new ReceitaWS;
        });
    }
}
