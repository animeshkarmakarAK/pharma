<?php

namespace Module\CourseManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Module\CourseManagement\App\Models\Institute;

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
                    'institute_id' => array_rand($institutes),
                    'title_en' => 'Graphic Design',
                    'title_bn' => 'গ্রাফিক্স ডিজাইন',
                    'fee' => '500',
                    'objects' => "Introduction to different types of welding processes;
                                            l Identification of different metals;
                                            l Preparation of different types of welding joints;
                                            l Welding practice at positions;
                                            l Safety awareness",
                    'contents' => "l Welding Theory on Arc Welding    l Heat Treatment l Gas Welding/Cutting l Safety & Mainteance
                                            l Engineering Materials
                                            l Technical Drawing Reading
                                            l Welding Hand tools/Measuring Tools.",
                    'target_group' => "Candidate having SSC or equivalent certificate
                                        along with technical experience, Merchant Navy
                                        Cadets, Defense civilian staff (army, air force
                                        and navy), TTC/VTI certificate holders, Diploma
                                        in Engineering.",
                    'training_methodology' => "l Class-room lecture
                                            l Group discussion
                                            l Practical exercise
                                            l Demonstration",
                    "evaluation_system" => "l Observation
                                            l Question and answer
                                            l Individual exercise
                                            l Written test
                                            l Oral test
                                            l Overall performance.",

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
