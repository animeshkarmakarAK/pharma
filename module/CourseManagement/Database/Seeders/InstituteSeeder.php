<?php

namespace Module\CourseManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('institutes')->truncate();

        \DB::table('institutes')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'title_en' => 'BITAC',
                    'title_bn' => 'বিটাক',
                    'code' => '1212',
                    'domain' => 'https://www.bitac.com',
                    'address' => 'dhaka-1000',
                    'row_status' => 1
                ),
            1 => array(
                'id' => 2,
                'title_en' => 'BASIS',
                'title_bn' => 'বেসিস',
                'code' => '1213',
                'domain' => 'https://www.basis.com',
                'address' => 'dhaka-1000',
                'row_status' => 1
            ),
        ));
        Schema::enableForeignKeyConstraints();
    }
}
