<?php

namespace Module\GovtStakeholder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OccupationWiseStatisticSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('occupation_wise_statistics')->truncate();

        DB::table('occupation_wise_statistics')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'institute_id' => '1',
                    'occupation_id'=>'1',
                    'current_month_skilled_youth' => '100',
                    'next_month_skill_youth' => '100',
                    'row_status' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'institute_id' => '2',
                    'occupation_id'=>'2',
                    'current_month_skilled_youth' => '200',
                    'next_month_skill_youth' => '200',
                    'row_status' => 1,
                ),
            2 =>
                array(
                    'id' => 3,
                    'institute_id' => '2',
                    'occupation_id'=>'3',
                    'current_month_skilled_youth' => '300',
                    'next_month_skill_youth' => '300',
                    'row_status' => 1,
                ),
            3 =>
                array(
                    'id' => 4,
                    'institute_id' => '1',
                    'occupation_id'=>'4',
                    'current_month_skilled_youth' => '200',
                    'next_month_skill_youth' => '200',
                    'row_status' => 1,
                ),
            4 =>
                array(
                    'id' => 5,
                    'institute_id' => '1',
                    'occupation_id'=>'4',
                    'current_month_skilled_youth' => '300',
                    'next_month_skill_youth' => '300',
                    'row_status' => 1,
                ),
            5 =>
                array(
                    'id' => 6,
                    'institute_id' => '1',
                    'occupation_id'=>'3',
                    'current_month_skilled_youth' => '400',
                    'next_month_skill_youth' => '400',
                    'row_status' => 1,
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
