<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TablePermissionKeySeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();

        $skipTables = [
            "failed_jobs",
            "migrations",
            "password_resets",
            "permission_role",
            "row_status",
            "sms_configs",
            "sms_sending_logs",
            "user_roles",
            "users_permissions",
//            "menus",
            "menu_items"
        ];

        $tables = Schema::getAllTables();

        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . env('DB_DATABASE')};
            if (!in_array($tableName, $skipTables)) {
                Permission::generateFor($tableName);
            }
        }

        $extraPermissionKeys = [
            [
                'table_name' => '',
                'key' => 'browse_admin',
            ],
            [
                'table_name' => 'users',
                'key' => 'change_user_password',
            ],
            [
                'table_name' => 'users',
                'key' => 'view_user_permission',
            ],
            [
                'table_name' => 'users',
                'key' => 'change_user_permission',
            ],
            [
                'table_name' => 'users',
                'key' => 'change_user_role',
            ],
            [
                'table_name' => 'batches',
                'key' => 'view_batch_youth',
            ],
            [
                'table_name' => 'data_entry',
                'key' => 'view_any_organization_wise_statistic',
            ],
            [
                'table_name' => 'data_entry',
                'key' => 'view_any_occupation_wise_statistic',
            ],
            [
                'table_name' => 'data_entry',
                'key' => 'view_any_upazila_job_statistic',
            ],
            [
                'table_name' => 'data_entry',
                'key' => 'view_any_organization_unit_statistic',
            ],
        ];

        foreach ($extraPermissionKeys as $permission) {
            Permission::updateOrCreate(['key' => $permission['key']], $permission);
        }

        Schema::enableForeignKeyConstraints();
    }
}
