<?php

namespace Database\Seeders;

use App\Models\Institute;
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
        $institutes = Institute::active()->pluck('id')->toArray();

        \DB::table('courses')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'institute_id' => 1,
                    'branch_id' => 1,
                    'training_center_id' => 1,
                    'title' => 'Graphic Design',
                    'course_fee' => '500',
                    'objects' => "Introduction to different types of welding processes;
                                            l Identification of different metals;
                                            l Preparation of different types of welding joints;
                                            l Welding practice at positions;
                                            l Safety awareness",
                    'contents' => "l Welding Theory on Arc Welding Heat Treatment l Gas Welding/Cutting l Safety & Maintenance",
                    'target_group' => "Candidate having SSC or equivalent certificate.",
                    'training_methodology' => "l Class-room lecture",
                    "evaluation_system" => "l Observation
                                            l Question and answer
                                            l Individual exercise.",

                    'description' => 'course-description',
                    'eligibility' => 'course-eligibility',
                    'prerequisite' => 'prerequisites',
                    'code' => '111',
                    'created_by' => '1',
                    'row_status' => 1,
                    'cover_image' => 'default/cover_image',
                ),

            1 =>
                array(
                    'id' => 2,
                    'institute_id' => 1,
                    'branch_id' => 1,
                    'training_center_id' => 2,
                    'title' => 'Electronics',
                    'course_fee' => '1000',
                    'objects' => "Introduction to different types of welding processes;
                                            l Identification of different metals;
                                            l Preparation of different types of welding joints;
                                            l Welding practice at positions;
                                            l Safety awareness",
                    'contents' => "l Welding Theory on Arc Welding Heat Treatment l Gas Welding/Cutting l Safety & Maintenance",
                    'target_group' => "Candidate having SSC or equivalent certificate.",
                    'training_methodology' => "l Class-room lecture",
                    "evaluation_system" => "l Observation
                                            l Question and answer
                                            l Individual exercise.",

                    'description' => 'course-description',
                    'eligibility' => 'course-eligibility',
                    'prerequisite' => 'prerequisites',
                    'code' => '112',
                    'created_by' => '1',
                    'row_status' => 1,
                    'cover_image' => 'default/cover_image',
                )
        ));
        Schema::enableForeignKeyConstraints();
    }
}
