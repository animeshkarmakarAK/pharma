<?php

namespace Database\Seeders;

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
            GeoLocationDatabaseSeeder::class,
            RoleTableSeeder::class,
            RowStatusSeeder::class,
            UserTypeSeeder::class,
            \Module\CourseManagement\Database\Seeders\DatabaseSeeder::class,
            \Module\GovtStakeholder\Database\Seeders\DatabaseSeeder::class,
        ]);
    }
}
