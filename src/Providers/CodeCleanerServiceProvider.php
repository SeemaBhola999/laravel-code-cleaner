<?php

namespace CodeCleaner\Providers;

use Illuminate\Support\ServiceProvider;
use CodeCleaner\Commands\CleanCodeCommand;

class CodeCleanerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            CleanCodeCommand::class,
        ]);
    }

    public function boot()
    {
        // Boot tasks if needed
    }
}