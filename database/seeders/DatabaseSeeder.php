<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\BranchSeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\InstituteSeeder;
use Database\Seeders\ProgrammeSeeder;
use Database\Seeders\StaticPageSeeder;
use Database\Seeders\TrainingCenterSeeder;

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
            GeoLocationDatabaseSeeder::class,
            RoleTableSeeder::class,
            RowStatusSeeder::class,
            UserTypeSeeder::class,
            \Database\Seeders\DatabaseSeeder::class,
            InstituteSeeder::class,
            CourseSeeder::class,
            StaticPageSeeder::class,
            BranchSeeder::class,
            TrainingCenterSeeder::class,
            ProgrammeSeeder::class,
        ]);
    }
}
