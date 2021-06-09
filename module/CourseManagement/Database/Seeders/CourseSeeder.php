<?php

namespace Module\CourseManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('courses')->truncate();

        \DB::table('courses')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'institute_id' => 1,
                    'title_en' => 'Graphic Design',
                    'title_bn' => 'গ্রাফিক্স ডিজাইন',
                    'description' => 'course-description',
                    'eligibility' => 'course-eligibility',
                    'prerequisite' => 'prerequisites',
                    'code' => '111',
                    'created_by' => '1',
                    'row_status' => 1,
                    'cover_image' => 'default cover image',
                )
        ));
        Schema::enableForeignKeyConstraints();
    }
}
