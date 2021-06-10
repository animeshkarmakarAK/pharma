<?php

namespace Module\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $modules = collect(is_array(config('module.list')) ? config('module.list') : []);

        $modules->each(function ($module) {
            $viewPath = base_path('module' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views');
            $this->loadViewsFrom($viewPath, Str::snake($module));
        });
    }
}
