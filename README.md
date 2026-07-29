# Laravel ReceitaWS

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mlmendes/laravel-receitaws.svg?style=flat-square)](https://packagist.org/packages/mlmendes/laravel-receitaws)
[![GitHub Tests Action Status](https://github.com/mlmendes/laravel-receitaws/actions/workflows/run-tests.yml/badge.svg)](https://github.com/mlmendes/laravel-receitaws/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://github.com/mlmendes/laravel-receitaws/actions/workflows/fix-php-code-style-issues.yml/badge.svg)](https://github.com/mlmendes/laravel-receitaws/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mlmendes/laravel-receitaws.svg?style=flat-square)](https://packagist.org/packages/mlmendes/laravel-receitaws)

Integrate a Laravel application to ReceitaWS API by Leads2b

## Installation

You can install the package via composer:

```bash
composer require mlmendes/laravel-receitaws
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="receitaws-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="receitaws-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravelReceitaWS = new MLMendes\LaravelReceitaWS();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
