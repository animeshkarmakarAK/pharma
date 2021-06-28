<?php

namespace Module\GovtStakeholder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RankTypeSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('rank_types')->truncate();

        DB::table('rank_types')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'organization_id' => '5',
                    'title_en' => 'Chief of Army Staff',
                    'title_bn' => 'সেনাপ্রধান',
                    'description' => 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface',
                    'row_status' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'organization_id' => '5',
                    'title_en' => 'Chief of General Staff',
                    'title_bn' => 'চিফ অফ জেনারেল স্টাফ',
                    'description' => 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface',
                    'row_status' => 1,
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
