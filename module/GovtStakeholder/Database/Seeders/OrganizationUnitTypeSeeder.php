<?php

namespace Module\GovtStakeholder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrganizationUnitTypeSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('organization_unit_types')->truncate();

        DB::table('organization_unit_types')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'title_en' => 'Mobile Banking',
                    'title_bn' => 'মোবাইল ব্যাংকিং',
                    'row_status' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'title_en' => 'Payment Method',
                    'title_bn' => 'রকেট মোবাইল ব্যাংকিং',
                    'row_status' => 1,
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
