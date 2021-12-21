<?php

namespace App\Providers;

use App\Models\Institute;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadHelpers();

        $this->app->singleton('currentInstitute', static function ($app) {
            $currentInstituteSlug = $app->request->input('current_institute_slug');
            $currentInstitute = null;

            if ($currentInstituteSlug) {
                $currentInstitute = Institute::where('slug', $currentInstituteSlug)->first();
                if (!$currentInstitute) {
                    abort('404', 'Not found');
                }
            }

            return $currentInstitute;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if(App::environment('production')) {
            $url->forceScheme('https');
        }

        $this->loadViewsFrom(resource_path('views'), 'master');
    }

    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(app_path('Helpers/functions') . DIRECTORY_SEPARATOR . '*.php') as $filename) {
            require_once $filename;
        }
    }
}
