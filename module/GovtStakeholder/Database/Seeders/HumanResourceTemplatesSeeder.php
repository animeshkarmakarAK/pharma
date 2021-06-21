<?php

namespace Module\GovtStakeholder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HumanResourceTemplatesSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('human_resource_templates')->truncate();

        DB::table('human_resource_templates')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'title_en' => 'Marketing',
                    'title_bn' => 'মার্কেটিং',
                    'organization_id' => 1,
                    'organization_unit_type_id' => 1,
                    'parent_id' => 0,
                    'is_designation' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'title_en' => 'Sales executive',
                    'title_bn' => 'সেলস এক্সিকিউটিভ',
                    'organization_id' => 1,
                    'organization_unit_type_id' => 1,
                    'parent_id' => 1,
                    'is_designation' => 1,
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
