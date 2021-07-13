<?php

namespace Module\CourseManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CourseSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('course_sessions')->truncate();

        \DB::table('course_sessions')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'course_id' => 1,
                    'session_name_en' => "session 1",
                    'session_name_bn' => "session 1",
                    'publish_course_id' => 1,
                    'number_of_batches' => 1,
                    'application_start_date' => '2021-05-02 15:25:42',
                    'application_end_date' => '2021-05-02 15:25:42',
                    'course_start_date' => '2021-05-02 15:25:42',
                    'max_seat_available' => '20',
                ),
            1 =>
                array(
                    'id' => 2,
                    'course_id' => 1,
                    'publish_course_id' => 2,
                    'number_of_batches' => 2,
                    'session_name_en' => "session two",
                    'session_name_bn' => "session two",
                    'application_start_date' => '2021-05-02 15:25:42',
                    'application_end_date' => '2021-05-02 15:25:42',
                    'course_start_date' => '2021-05-02 15:25:42',
                    'max_seat_available' => '30',
                )
        ));
        Schema::enableForeignKeyConstraints();
    }
}
