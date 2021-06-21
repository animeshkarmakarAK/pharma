<?php

namespace Module\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    const MODULE_HELPER_DIR = 'Helpers';

    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        $this->loadHelpers();

        /** Register other code service providers */
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ViewServiceProvider::class);

        /** Register module specific service providers */
        $this->loadModuleServiceProviders();
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        /** Register module specific translations */
        $this->loadTranslations();

        /** Register module specific migrations */
        $this->loadMigrations();
    }

    protected function loadTranslations()
    {
        $modules = collect(is_array(config('module.list')) ? config('module.list') : []);

        $modules->each(function ($module) {
            $langPath = base_path('module' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'lang');
            $this->loadTranslationsFrom($langPath, Str::snake($module));
        });
    }

    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        $modules = collect(is_array(config('module.list')) ? config('module.list') : []);

        $modules->each(function ($module) {
            if (file_exists(base_path('module') . DIRECTORY_SEPARATOR . self::MODULE_HELPER_DIR)) {
                foreach (glob(base_path('module') . DIRECTORY_SEPARATOR . self::MODULE_HELPER_DIR . DIRECTORY_SEPARATOR . '*.php') as $filename) {
                    require_once $filename;
                }
            }
        });
    }

    protected function loadMigrations()
    {
        $modules = collect(is_array(config('module.list')) ? config('module.list') : []);

        $modules->each(function ($module) {
            if (file_exists(base_path('module' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'Database')) &&
                file_exists(base_path('module' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'migrations'))) {
                $migrationPath = base_path('module' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'migrations');
                $this->loadMigrationsFrom($migrationPath);
            }
        });
    }

    private function loadModuleServiceProviders()
    {
        $modules = collect(is_array(config('module.list')) ? config('module.list') : []);

        $modules->each(function ($module) {
            if (class_exists("Module\\" . $module . "\\Providers\\ModuleServiceProvider")) {
                $this->app->register("Module\\" . $module . "\\Providers\\ModuleServiceProvider");
            }
        });
    }
}
