<?php

namespace Module\CourseManagement\App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Module\CourseManagement\App\Models\OrganizationComplainToYouth;
use Module\CourseManagement\App\Models\YouthComplainToOrganization;
use Module\CourseManagement\App\Models\YouthOrganization;
use Module\CourseManagement\App\Policies\OrganizationComplainToYouthPolicy;
use Module\CourseManagement\App\Policies\YouthComplainToOrganizationPolicy;
use Module\CourseManagement\App\Policies\YouthOrganizationPolicy;


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
        //YouthOrganization::class => YouthOrganizationPolicy::class,
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
