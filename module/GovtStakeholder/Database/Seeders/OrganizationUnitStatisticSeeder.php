<?php

namespace Module\GovtStakeholder\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Module\GovtStakeholder\App\Models\OrganizationUnit;

class OrganizationUnitStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('organization_unit_statistics')->truncate();
        $organizationUnitIDs = OrganizationUnit::pluck('id')->toArray();
        DB::table('organization_unit_statistics')->insert([
            [
                'organization_unit_id' => $organizationUnitIDs[array_rand($organizationUnitIDs)],
                'total_new_recruits' => random_int(1, 10),
                'total_vacancy' => random_int(1, 10),
                'total_occupied_position' => random_int(1, 10),
                'survey_date' => Carbon::now()->subMonth(rand(1, 12)),
            ],
            [
                'organization_unit_id' => $organizationUnitIDs[array_rand($organizationUnitIDs)],
                'total_new_recruits' => random_int(1, 10),
                'total_vacancy' => random_int(1, 10),
                'total_occupied_position' => random_int(1, 10),
                'survey_date' => Carbon::now()->subMonth(rand(1, 12)),
            ],
            [
                'organization_unit_id' => $organizationUnitIDs[array_rand($organizationUnitIDs)],
                'total_new_recruits' => random_int(1, 10),
                'total_vacancy' => random_int(1, 10),
                'total_occupied_position' => random_int(1, 10),
                'survey_date' => Carbon::now()->subMonth(rand(1, 12)),
            ],
            [
                'organization_unit_id' => $organizationUnitIDs[array_rand($organizationUnitIDs)],
                'total_new_recruits' => random_int(1, 10),
                'total_vacancy' => random_int(1, 10),
                'total_occupied_position' => random_int(1, 10),
                'survey_date' => Carbon::now()->subMonth(rand(1, 12)),
            ],
            [
                'organization_unit_id' => $organizationUnitIDs[array_rand($organizationUnitIDs)],
                'total_new_recruits' => random_int(1, 10),
                'total_vacancy' => random_int(1, 10),
                'total_occupied_position' => random_int(1, 10),
                'survey_date' => Carbon::now()->subMonth(rand(1, 12)),
            ],
            [
                'organization_unit_id' => $organizationUnitIDs[array_rand($organizationUnitIDs)],
                'total_new_recruits' => random_int(1, 10),
                'total_vacancy' => random_int(1, 10),
                'total_occupied_position' => random_int(1, 10),
                'survey_date' => Carbon::now()->subMonth(rand(1, 12)),
            ],
            [
                'organization_unit_id' => $organizationUnitIDs[array_rand($organizationUnitIDs)],
                'total_new_recruits' => random_int(1, 10),
                'total_vacancy' => random_int(1, 10),
                'total_occupied_position' => random_int(1, 10),
                'survey_date' => Carbon::now()->subMonth(rand(1, 12)),
            ]
        ]);
    }
}
