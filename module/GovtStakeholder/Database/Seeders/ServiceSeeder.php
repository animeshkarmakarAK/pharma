<?php

namespace Module\GovtStakeholder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ServiceSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('services')->truncate();

        DB::table('services')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'organization_id' => '1',
                    'title_en' => 'Web Development',
                    'title_bn' => 'ওয়েব ডেভেলপমেন্ট',
                    'row_status' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'organization_id' => '2',
                    'title_en' => 'Graphic design',
                    'title_bn' => 'গ্রাফিক ডিজাইন',
                    'row_status' => 1,
                ),
            2 =>
                array(
                    'id' => 3,
                    'organization_id' => '3',
                    'title_en' => 'video editing',
                    'title_bn' => 'ভিডিও এডিটিং',
                    'row_status' => 1,
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
