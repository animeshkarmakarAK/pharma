<?php

namespace Module\CourseManagement\Database\Seeders;

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
            InstituteSeeder::class,
            CourseSeeder::class,
            ApplicationFormTypeSeeder::class,
            StaticPageSeeder::class,
            BranchSeeder::class,
            TrainingCenterSeeder::class,
            ProgrammeSeeder::class,
        ]);
    }
}
