<?php

namespace Module\GovtStakeholder\App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Module\GovtStakeholder\App\Models\organizationUnitStatistic;
use Module\GovtStakeholder\App\Policies\OrganizationUnitStatisticPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        OrganizationUnitStatistic::class => OrganizationUnitStatisticPolicy::class
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
