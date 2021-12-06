<?php

namespace Module\CourseManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('institutes')->truncate();

        \DB::table('institutes')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => 'BITAC',
                    'email' => 'bitac@gmail.com',
                    'mobile' => '01837473838',
                    'office_head_name' => 'SK',
                    'office_head_post' => 'SWE',
                    'contact_person_name' => 'HR',
                    'contact_person_email' => 'HR@gmail.com',
                    'contact_person_mobile' => 'HR@gmail.com',
                    'contact_person_post' => 'HR',
                    'row_status' => 1,
                    'slug' => Str::slug('bitac')
                ),
        ));
        Schema::enableForeignKeyConstraints();
    }
}
