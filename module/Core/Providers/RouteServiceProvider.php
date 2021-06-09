<?php

namespace Module\Core\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = '';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $this->loadModuleRoute('web');
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $this->loadModuleRoute('api');
    }

    private function loadModuleRoute(string $routeFor): void
    {
        $modules = collect(is_array(config('module.list')) ? config('module.list') : []);

        $modules->each(function ($module) use ($routeFor) {
            $routePath = base_path('module' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . $routeFor . '.php');

            Route::middleware($routeFor)
                ->prefix($routeFor == 'api' ? 'api' : '')
                ->namespace($this->namespace)
                ->group($routePath);
        });
    }
}
