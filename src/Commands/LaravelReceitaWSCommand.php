<?php

namespace MLMendes\LaravelReceitaWS\Commands;

use Illuminate\Console\Command;

class LaravelReceitaWSCommand extends Command
{
    public $signature = 'laravel-receitaws';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
