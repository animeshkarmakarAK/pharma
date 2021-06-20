<?php

namespace Module\GovtStakeholder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrganizationUnitSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('organization_units')->truncate();

        DB::table('organization_units')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'title_en' => 'Rocket Mobile Banking',
                    'title_bn' => 'রকেট মোবাইল ব্যাংকিং',
                    'organization_id' => 1,
                    'organization_unit_type_id' => 1,
                    'loc_division_id' => 1,
                    'loc_district_id' => 1,
                    'loc_upazila_id' => 2,
                    'row_status' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'title_en' => 'NexusPay',
                    'title_bn' => 'নেক্সাস পে',
                    'organization_id' => 1,
                    'organization_unit_type_id' => 1,
                    'loc_division_id' => 1,
                    'loc_district_id' => 1,
                    'loc_upazila_id' => 2,
                    'row_status' => 1,
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
