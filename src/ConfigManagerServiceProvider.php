<?php

namespace Vanni\ConfigManager;

use Illuminate\Support\ServiceProvider;
use Vanni\ConfigManager\Console\Commands\ExportEnvCommand;

class ConfigManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            \Vanni\ConfigManager\Contracts\EnvExporterContract::class,
            \Vanni\ConfigManager\Services\EnvExporter::class
        );

        $this->app->singleton(
            \Vanni\ConfigManager\Validation\ConfigValidator::class
        );

        $this->app->singleton(
            \Vanni\ConfigManager\Services\EnvApplier::class
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/config-manager.php',
            'config-manager'
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ExportEnvCommand::class,
            ]);

            $this->publishes([
                __DIR__ . '/../config/config-manager.php' => config_path('config-manager.php'),
            ], 'config');
        }
    }
}
