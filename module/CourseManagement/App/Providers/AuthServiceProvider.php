<?php

namespace Module\CourseManagement\App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Module\CourseManagement\App\Models\OrganizationComplainToYouth;
use Module\CourseManagement\App\Models\YouthComplainToOrganization;
use Module\CourseManagement\App\Policies\OrganizationComplainToYouthPolicy;
use Module\CourseManagement\App\Policies\YouthComplainToOrganizationPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        YouthComplainToOrganization::class => YouthComplainToOrganizationPolicy::class,
        OrganizationComplainToYouth::class => OrganizationComplainToYouthPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
