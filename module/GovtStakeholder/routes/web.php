<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/stakeholder', 'as' => 'govt_stakeholder::admin.', 'middleware' => ['auth']], function () {
    Route::resources([
        'organization-units' => \Module\GovtStakeholder\App\Http\Controllers\OrganizationUnitController::class,
        'organization-unit-types' => \Module\GovtStakeholder\App\Http\Controllers\OrganizationUnitTypeController::class,
        'human-resource-templates' => \Module\GovtStakeholder\App\Http\Controllers\HumanResourceTemplateController::class,
        'occupations' => \Module\GovtStakeholder\App\Http\Controllers\OccupationController::class,

    ]);

    Route::post('human-resource-templates/{human_resource_template}/update-node-on-drag', [\Module\GovtStakeholder\App\Http\Controllers\HumanResourceTemplateController::class, 'updateNodeOnDrag'])
        ->name('human-resource-templates.update-node-on-drag');
    Route::post('human-resource-templates/{human_resource_template}/update', [\Module\GovtStakeholder\App\Http\Controllers\HumanResourceTemplateController::class, 'updateNode'])->name('human-resource-templates.update-node');
    Route::post('human-resource-templates/addNode', [\Module\GovtStakeholder\App\Http\Controllers\HumanResourceTemplateController::class, 'addNode']);
    Route::get('human-resource-templates/{human_resource_template}/deleteNode', [\Module\GovtStakeholder\App\Http\Controllers\HumanResourceTemplateController::class, 'deleteNode'])->name('human-resource-templates.delete-node');

    Route::post('human-resource-templates/datatable', [\Module\GovtStakeholder\App\Http\Controllers\HumanResourceTemplateController::class, 'getDatatable'])->name('human-resource-templates.datatable');
    Route::post('organization-unit-types/datatable', [\Module\GovtStakeholder\App\Http\Controllers\OrganizationUnitTypeController::class, 'getDatatable'])->name('organization-unit-types.datatable');
    Route::get('organization-unit-types/{organization_unit_type}/hierarchy', [\Module\GovtStakeholder\App\Http\Controllers\OrganizationUnitTypeController::class, 'employeeHierarchy'])->name('organization-unit-types.hierarchy');
    Route::post('organization-units/datatable', [\Module\GovtStakeholder\App\Http\Controllers\OrganizationUnitController::class, 'getDatatable'])->name('organization-units.datatable');
    Route::post('occupations/datatable', [\Module\GovtStakeholder\App\Http\Controllers\OccupationController::class, 'getDatatable'])->name('occupations.datatable');

    Route::resources([
        'organization-types' => \Module\GovtStakeholder\App\Http\Controllers\OrganizationTypeController::class,
        'organizations' => \Module\GovtStakeholder\App\Http\Controllers\OrganizationController::class,
        'rank-types' => \Module\GovtStakeholder\App\Http\Controllers\RankTypeController::class,
        'ranks' => \Module\GovtStakeholder\App\Http\Controllers\RankController::class,
        'skills' => \Module\GovtStakeholder\App\Http\Controllers\SkillController::class,
        'services' => \Module\GovtStakeholder\App\Http\Controllers\ServiceController::class,
        'job-sectors' => \Module\GovtStakeholder\App\Http\Controllers\JobSectorController::class,
        'upazila-job-statistics' => \Module\GovtStakeholder\App\Http\Controllers\UpazilaJobStatisticController::class,
    ]);

    Route::post('rank-types/datatable', [\Module\GovtStakeholder\App\Http\Controllers\RankTypeController::class, 'getDatatable'])->name('rank-types.datatable');
    Route::post('ranks/datatable', [\Module\GovtStakeholder\App\Http\Controllers\RankController::class, 'getDatatable'])->name('ranks.datatable');
    Route::post('skills/datatable', [\Module\GovtStakeholder\App\Http\Controllers\SkillController::class, 'getDatatable'])->name('skills.datatable');
    Route::post('services/datatable', [\Module\GovtStakeholder\App\Http\Controllers\ServiceController::class, 'getDatatable'])->name('services.datatable');
    Route::post('organization-types/datatable', [\Module\GovtStakeholder\App\Http\Controllers\OrganizationTypeController::class, 'getDatatable'])->name('organization-types.datatable');
    Route::post('organizations/datatable', [\Module\GovtStakeholder\App\Http\Controllers\OrganizationController::class, 'getDatatable'])->name('organizations.datatable');
    Route::post('job-sectors/datatable', [\Module\GovtStakeholder\App\Http\Controllers\JobSectorController::class, 'getDatatable'])->name('job-sectors.datatable');
    Route::post('upazila-job-statistics/datatable', [\Module\GovtStakeholder\App\Http\Controllers\UpazilaJobStatisticController::class, 'getDatatable'])->name('upazila-job-statistics.datatable');
});



