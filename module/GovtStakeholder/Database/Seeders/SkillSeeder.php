<?php

namespace Module\GovtStakeholder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SkillSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('skills')->truncate();

        DB::table('skills')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'organization_id' => '1',
                    'title_en' => 'Computer skill',
                    'title_bn' => 'কম্পিউটারের দক্ষতা',
                    'description' => 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface',
                    'row_status' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'organization_id' => '2',
                    'title_en' => 'Management skills',
                    'title_bn' => 'ব্যবস্থাপনা দক্ষতা',
                    'description' => 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface',
                    'row_status' => 1,
                ),
            2 =>
                array(
                    'id' => 3,
                    'organization_id' => '3',
                    'title_en' => 'Leadership skills',
                    'title_bn' => 'নেতৃত্বের দক্ষতা',
                    'description' => 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface',
                    'row_status' => 1,
                ),
            3 =>
                array(
                    'id' => 4,
                    'organization_id' => '1',
                    'title_en' => 'Interpersonal skills',
                    'title_bn' => 'আন্তঃব্যক্তিক দক্ষতাগুলো',
                    'description' => 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface',
                    'row_status' => 1,
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
