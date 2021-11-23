<?php

namespace Module\SmefManagement\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        /** Register other code service providers */
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }
}
