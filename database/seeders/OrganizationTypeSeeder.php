<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrganizationTypeSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('organization_types')->truncate();

        \DB::table('organization_types')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'title_en' => 'Public Bank',
                    'title_bn' => 'সরকারি ব্যাংক',
                    'is_government' => '1',
                    'row_status' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'title_en' => 'Private Bank',
                    'title_bn' => 'বেসরকারি ব্যাংক',
                    'is_government' => '0',
                    'row_status' => 1,
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
