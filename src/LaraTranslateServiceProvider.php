<?php

namespace Manadinho\LaraTranslate;

use Illuminate\Support\ServiceProvider;
use Manadinho\LaraTranslate\Console\Commands\ShowMissingTranslationKeys;
use Manadinho\LaraTranslate\Console\Commands\SyncMissingTranslationKeys;

class LaraTranslateServiceProvider extends ServiceProvider{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__."/../routes/web.php");
        $this->loadViewsFrom(__DIR__."/../views", "lara-translate");
        $this->publishes([
            __DIR__.'/../config/laraTranslate.php' => config_path('laraTranslate.php'),
            __DIR__.'/../views' => resource_path('views/vendor/lara-translate'),
            __DIR__.'/../resources/assets' => public_path('vendor/lara-translate/assets')
        ]);
    }

    public function register()
    {
        $this->commands([
            ShowMissingTranslationKeys::class,
            SyncMissingTranslationKeys::class
        ]);
    }
}

