<?php

namespace Module\GovtStakeholder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RankSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('ranks')->truncate();

        DB::table('ranks')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'organization_id' => '1',
                    'title_en' => 'General',
                    'title_bn' => 'জেনারেল',
                    'rank_type_id' => '1',
                    'grade' => 'O-1',
                    'order' => '0',
                    'row_status' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'organization_id' => '2',
                    'title_en' => 'Lieutenant general',
                    'title_bn' => 'লেফটেন্যান্ট জেনারেল',
                    'rank_type_id' => '2',
                    'grade' => 'O-2',
                    'order' => '1',
                    'row_status' => 1,
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
