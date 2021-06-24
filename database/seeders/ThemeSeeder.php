<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('themes')->truncate();

        DB::table('themes')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Default Theme',
                    'key' => 'admin-lte-sidebar-menu'
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Big Icon Theme',
                    'key' => 'admin-lte-sidebar-big-icon-menu'
                )
        ));

        Schema::enableForeignKeyConstraints();
    }
}
