<?php

namespace Module\CourseManagement\Database\Seeders;

use Module\CourseManagement\App\Models\Institute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstituteDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Institute::factory()->count(2)->create();
    }
}
