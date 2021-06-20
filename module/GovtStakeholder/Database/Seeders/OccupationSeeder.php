<?php

namespace Module\GovtStakeholder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OccupationSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('occupations')->truncate();

        DB::table('occupations')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'title_en' => 'Job',
                    'title_bn' => 'জব',
                    'job_sector_id' => '1',
                    'row_status' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'title_en' => 'Private Job',
                    'title_bn' => 'বেসরকারি জব',
                    'job_sector_id' => '1',
                    'row_status' => 1,
                ),
            2 =>
                array(
                    'id' => 3,
                    'title_en' => 'Govt. Job',
                    'title_bn' => 'সরকারি জব',
                    'job_sector_id' => '1',
                    'row_status' => 1,
                ),
            3 =>
                array(
                    'id' => 4,
                    'title_en' => 'Banker',
                    'title_bn' => 'ব্যাঙ্কার',
                    'job_sector_id' => '1',
                    'row_status' => 1,
                ),
            4 =>
                array(
                    'id' => 5,
                    'title_en' => 'Teacher',
                    'title_bn' => 'শিক্ষক/শিক্ষিকা',
                    'job_sector_id' => '1',
                    'row_status' => 1,
                ),
            5 =>
                array(
                    'id' => 6,
                    'title_en' => 'Engineer',
                    'title_bn' => 'ইঞ্জিনিয়ার',
                    'job_sector_id' => '1',
                    'row_status' => 1,
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
