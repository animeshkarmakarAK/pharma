<?php

namespace Module\CourseManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PublishedCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('publish_courses')->truncate();

        \DB::table('publish_courses')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'institute_id' => 1,
                    'application_form_type_id' => 1,
                    'course_id' => 1,
                    'created_by' => 1,
                    'row_status' => 1
                ),
            1 =>
                array(
                    'id' => 2,
                    'institute_id' => 1,
                    'application_form_type_id' => 1,
                    'course_id' => 1,
                    'created_by' => 1,
                    'row_status' => 1
                )
        ));
        Schema::enableForeignKeyConstraints();
    }
}
