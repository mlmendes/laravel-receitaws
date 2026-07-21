<?php

namespace MLMendes\LaravelReceitaWS;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ReceitaWSServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-receitaws')
            ->discoversMigrations();
    }
}