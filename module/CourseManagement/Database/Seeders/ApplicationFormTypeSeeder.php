<?php

namespace Module\CourseManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ApplicationFormTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('application_form_types')->truncate();

        \DB::table('application_form_types')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'institute_id' => 1,
                    'title_en' => 'Regular Application Form',
                    'title_bn' => 'নিয়মিত আবেদন ফর্ম',
                    'row_status' => '1',
                    'created_by' => '1',
                    'ethnic' => '1',
                    'freedom_fighter' => '0',
                    'disable_status' => '0',
                    'ssc' => '1',
                    'hsc' => '1',
                    'honors' => '1',
                    'masters' => '1',
                ),
        ));
        Schema::enableForeignKeyConstraints();
    }
}
