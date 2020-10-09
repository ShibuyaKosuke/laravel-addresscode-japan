<?php

namespace ShibuyaKosuke\LaravelAddressCodeJapan;

use Illuminate\Contracts\Support\DeferrableProvider;
use ShibuyaKosuke\LaravelAddressCodeJapan\Console\AddressCodeCommand;

/**
 * Class ServiceProvider
 * @package ShibuyaKosuke\LaravelAddressCodeJapan
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider implements DeferrableProvider
{
    protected $deferred = true;

    public function boot(): void
    {
        // migration
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');

        // Command
        $this->registerCommands();

        $this->publishes([
            __DIR__ . '/../config/address_code_japan.php' => config_path('address_code_japan.php')
        ], 'address_code_japan');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/address_code_japan.php', 'address_code_japan');
    }

    protected function registerCommands(): void
    {
        $this->app->singleton('command.address_code_japan', static function ($app) {
            return new AddressCodeCommand($app);
        });

        $this->commands([
            'command.address_code_japan'
        ]);
    }

    public function provides(): array
    {
        return [
            'command.address_code_japan'
        ];
    }
}
