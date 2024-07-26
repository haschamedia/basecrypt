<?php

namespace BaseCrypt;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class BaseCryptServiceProvider extends ServiceProvider
{
    public function register(): void
    {}
    
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/basecrypt.php' => config_path('basecrypt.php'),
        ], 'basecrypt-config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/basecrypt.php', 'basecrypt'
        );
    }
}
