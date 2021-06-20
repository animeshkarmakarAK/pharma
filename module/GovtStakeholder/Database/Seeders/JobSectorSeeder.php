<?php

namespace Module\GovtStakeholder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class JobSectorSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('job_sectors')->truncate();

        DB::table('job_sectors')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'title_en' => 'Accountancy, banking and finance',
                    'title_bn' => 'হিসাবরক্ষক, ব্যাংকিং এবং ফিনান্স',
                    'row_status' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'title_en' => 'Business, consulting and management',
                    'title_bn' => 'কর্পোরেট ব্যবস্থাপনা, বাণিজ্যিক পরিষেবা সমূহ',
                    'row_status' => 1,
                ),
            2 =>
                array(
                    'id' => 3,
                    'title_en' => 'Charity and voluntary work',
                    'title_bn' => 'দাতব্য এবং স্বেচ্ছাসেবী কাজ',
                    'row_status' => 1,
                ),
            3 =>
                array(
                    'id' => 4,
                    'title_en' => 'Creative arts and design',
                    'title_bn' => 'সৃজনশীল শিল্প ও নকশা',
                    'row_status' => 1,
                ),
            4 =>
                array(
                    'id' => 5,
                    'title_en' => 'Energy and utilities',
                    'title_bn' => 'শক্তি এবং ইউটিলিটিস',
                    'row_status' => 1,
                ),
            5 =>
                array(
                    'id' => 6,
                    'title_en' => 'Engineering and manufacturing',
                    'title_bn' => 'ইঞ্জিনিয়ারিং এবং উত্পাদন',
                    'row_status' => 1,
                ),
            6 =>
                array(
                    'id' => 7,
                    'title_en' => 'Information technology',
                    'title_bn' => 'তথ্য প্রযুক্তি',
                    'row_status' => 1,
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
