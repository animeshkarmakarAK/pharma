<?php

namespace Module\GovtStakeholder\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            OrganizationTypeSeeder::class,
            JobSectorSeeder::class,
            OccupationSeeder::class,
            OccupationWiseStatisticSeeder::class,
            OrganizationSeeder::class,
            SkillSeeder::class,
            RankTypeSeeder::class,
            RankSeeder::class,
            ServiceSeeder::class,
            OrganizationUnitSeeder::class,
            OrganizationUnitTypeSeeder::class,
            HumanResourceTemplatesSeeder::class,
        ]);
    }
}
