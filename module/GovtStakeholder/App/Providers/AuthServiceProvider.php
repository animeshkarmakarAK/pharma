<?php

namespace Module\GovtStakeholder\App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Module\GovtStakeholder\App\Models\organizationUnitStatistic;
use Module\GovtStakeholder\App\Models\UpazilaJobStatistic;
use Module\GovtStakeholder\App\Policies\OrganizationUnitStatisticPolicy;
use Module\GovtStakeholder\App\Policies\UpazilaJobStatisticPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        OrganizationUnitStatistic::class => OrganizationUnitStatisticPolicy::class,
        UpazilaJobStatistic::class => UpazilaJobStatisticPolicy::class,
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
