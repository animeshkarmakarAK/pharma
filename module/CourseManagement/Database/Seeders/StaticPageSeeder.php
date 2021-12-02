<?php

namespace Module\CourseManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Schema::disableForeignKeyConstraints();

        DB::table('static_pages')->truncate();

        \DB::table('static_pages')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'title_en' => 'About Us',
                    'page_id' => 'about_us',
                    'institute_id' => '1',
                    'created_by' => '1',
                    'page_contents' => '<h2 class="section-heading" style="text-align: center;">আমাদের সম্পর্কে</h2>
                            <p>&nbsp;</p>
                            <p>গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের রূপকল্প ২০২১ বাস্তবায়নে যুবকদের আত্নকর্মসংস্থান ও স্বাবলম্বী করে তোলার লক্ষ্যে "অনলাইনে বিভিন্ন প্রশিক্ষণ কোর্সের পরিচালনা ও পর্যবেক্ষণ করা"। এই ওয়েব অ্যাপ্লিকেশনটি মূলত "অনলাইন কোর্স ম্যানেজমেন্ট সিস্টেম"। এই প্ল্যাটফর্মে শিক্ষার্থী অতি সহজে বিভিন্ন প্রশিক্ষণ কোর্সে প্রশিক্ষণ নিয়ে স্বাবলম্বী হতে পাড়বে। শিক্ষার্থী তার নিজ পছন্দের বিষয়ে প্রশিক্ষণের জন্য এডমিনে কাছে অনুরোধ/আবেদন করতে পাড়বে। প্রশিক্ষণ শেষে শিক্ষার্থীকে সার্টিফিকেট প্রদান করা হবে।</p>
                            <h2 class="para-heading">পোর্টালের লক্ষ্য/উদ্দেশ্য সমূহঃ</h2>
                            <ul class="sidebar-list">
                            <li>&nbsp;এই প্ল্যাটফর্মে শিক্ষার্থী বিভিন্ন প্রশিক্ষণ কোর্সের জন্য আবেদন করতে পারবে।</li>
                            <li>&nbsp;বিভিন্ন ক্যাটাগরিতে অনেক গুলো কোর্স একসাথে পরিচালনা ও পর্যবেক্ষণ করা সম্ভব।</li>
                            <li>&nbsp;সঠিক পদ্ধতিতে শিক্ষার্থীর দক্ষতা যাচাই করা এবং বৃদ্ধি করা হয় ।</li>
                            </ul>'
                ),

        ));
        Schema::enableForeignKeyConstraints();
    }
}
