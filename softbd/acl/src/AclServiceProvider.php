<?php

namespace Softbd\Acl;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AclServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any application services.
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            'softbd-acl',
            static function () {
                return new SoftbdAcl();
            }
        );

        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'softbd-acl');

        $this->loadHelpers();
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/config/config.php' => config_path('softbd-acl.php'),
                ],
                'config'
            );

            $this->publishes(
                [
                    __DIR__ . '/resources/views' => resource_path('views/vendor/softbd/acl'),
                ],
                'views'
            );
        }

        $this->loadTranslations();
        $this->loadViews();
        $this->loadRoute();
        $this->loadMigrations();
    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'softbd-acl');
    }

    protected function loadHelpers(): void
    {
        require_once __DIR__ . '/helpers/helper.php';
    }

    protected function loadRoute(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    protected function loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . DIRECTORY_SEPARATOR . 'migrations');
    }

    protected function loadTranslations()
    {
        $langPath = base_path('softbd' . DIRECTORY_SEPARATOR . 'acl' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'lang');
        $this->loadTranslationsFrom($langPath, 'softbd-acl');
    }
}
