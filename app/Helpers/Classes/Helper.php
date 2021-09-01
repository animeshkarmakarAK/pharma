<?php

namespace App\Helpers\Classes;

use Illuminate\Support\Facades\Cache;
use Module\CourseManagement\App\Models\Institute;

class Helper
{
    public static function randomPassword($length, $onlyDigit = false): string
    {
        $alphabet = $onlyDigit ? '1234567890' : 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = random_int(0, $alphaLength);
            $pass[] = $alphabet[$n] == '0' ? '1' : $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public static function getDomainConfig()
    {
        try {
            $urls = [
                \request()->getSchemeAndHttpHost(),
                \request()->getScheme() . '://www.' . \request()->getHttpHost(),
                \request()->getSchemeAndHttpHost() . '/',
                \request()->getScheme() . '://www.' . \request()->getHttpHost() . '/',
            ];

            /** @var Institute $institute */
            $institute = Institute::whereIn('domain', $urls)->first();

            return Cache::rememberForever($institute->domain, function () use ($institute) {
                return collect(['institute' => $institute]);
            });
        } catch (\Throwable $exception) {
            return collect(['institute' => null]);
        }
    }

    public static function forgetDomainConfig(Institute $institute): bool
    {
//        $urls = [
//            \request()->getSchemeAndHttpHost(),
//            \request()->getScheme() . '://www.' . \request()->getHttpHost(),
//            \request()->getSchemeAndHttpHost() . '/',
//            \request()->getScheme() . '://www.' . \request()->getHttpHost() . '/',
//        ];

        return Cache::forget($institute->domain);
    }

    public static function getMuktoPathCourses(): array
    {
        return array(
            0 =>
                array(
                    'wishlist_status' => 0,
                    'id' => 25,
                    'title' => 'Batch-1',
                    'course_alias_name' => 'Digital Education',
                    'payment_point_amount' => NULL,
                    'enrolment_approval_status' => 0,
                    'discount' => NULL,
                    'discount_status' => 0,
                    'payment_status' => 0,
                    'certificate_approval_status' => 0,
                    'details' => '<!DOCTYPE html>
<html>
<head>
</head>
<body>
<p><span style="color: #202124; font-family: arial, sans-serif; font-size: 16px; background-color: #ffffff;">Digital education</span><span style="color: #202124; font-family: arial, sans-serif; font-size: 16px; background-color: #ffffff;"> is the innovative use of </span><span style="color: #202124; font-family: arial, sans-serif; font-size: 16px; background-color: #ffffff;">digital</span><span style="color: #202124; font-family: arial, sans-serif; font-size: 16px; background-color: #ffffff;"> tools and technologies during </span><span style="color: #202124; font-family: arial, sans-serif; font-size: 16px; background-color: #ffffff;">teaching</span><span style="color: #202124; font-family: arial, sans-serif; font-size: 16px; background-color: #ffffff;"> and </span><span style="color: #202124; font-family: arial, sans-serif; font-size: 16px; background-color: #ffffff;">learning</span><span style="color: #202124; font-family: arial, sans-serif; font-size: 16px; background-color: #ffffff;">, and is often referred to as Technology Enhanced </span><span style="color: #202124; font-family: arial, sans-serif; font-size: 16px; background-color: #ffffff;">Learning</span><span style="color: #202124; font-family: arial, sans-serif; font-size: 16px; background-color: #ffffff;"> (TEL) or e-</span><span style="color: #202124; font-family: arial, sans-serif; font-size: 16px; background-color: #ffffff;">Learning</span><span style="color: #202124; font-family: arial, sans-serif; font-size: 16px; background-color: #ffffff;">.</span></p>
</body>
</html>',
                    'requirement' => '<p> </p>',
                    'course_requirment' =>
                        array(
                            0 =>
                                array(
                                    'info' => '',
                                    'attach' => false,
                                ),
                        ),
                    'code' => NULL,
                    'course_alias_name_en' => 'Digital Education',
                    'totalEnroll' => 1,
                    'averageRating' => 3,
                    'totalRatingCount' => 2,
                    'logo_image' => '5dbfaf79863b7.png',
                    'thumnail' =>
                        array(
                            'file_name' => 'image-1-1621932386.png',
                            'file_encode_path' => 'dXNlci0xL2ltYWdlLTEtMTYyMTkzMjM4Ng==.png',
                            'owner_id' => 1,
                            'created_by' => 1,
                        ),
                    'course_duration' => '1hour',
                    'admission_status' => 1,
                    'reg_start_date' => NULL,
                    'reg_end_date' => NULL,
                    'start_date' => NULL,
                    'end_date' => NULL,
                    'institution_name_bn' => 'মুক্তপাঠ',
                    'institution_name' => 'OrangeBD Super Admin',
                    'slug' => 'Eng',
                    'courseStatistics' =>
                        array(
                            'total_lesson' => 15,
                            'total_content' => 6,
                            'quiz' => 3,
                            'exam' => 3,
                            'assignment' => 2,
                        ),
                ),
            1 =>
                array(
                    'wishlist_status' => 0,
                    'id' => 23,
                    'title' => 'Batch-1',
                    'course_alias_name' => 'Software automation',
                    'payment_point_amount' => NULL,
                    'enrolment_approval_status' => 0,
                    'discount' =>
                        array(
                            'amount' => '',
                            'type' => '0',
                            'date' => '',
                        ),
                    'discount_status' => 0,
                    'payment_status' => 0,
                    'certificate_approval_status' => 0,
                    'details' => '<!DOCTYPE html>
<html>
<head>
</head>
<body>
<p><strong style="box-sizing: inherit; line-height: inherit; color: #222222; font-family: \'Source Sans Pro\', Arial, sans-serif; font-size: 18px; background-color: #ffffff;">Automation Testing or Test Automation</strong><span style="color: #222222; font-family: \'Source Sans Pro\', Arial, sans-serif; font-size: 18px; background-color: #ffffff;"> is a software testing technique that performs using special automated testing software tools to execute a test case suite. On the contrary, </span><a style="box-sizing: inherit; background: #ffffff; text-decoration-line: none; color: #04b8e6; transition: all 0.2s ease 0s; font-family: \'Source Sans Pro\', Arial, sans-serif; font-size: 18px;" href="https://www.guru99.com/manual-testing.html">Manual Testing</a><span style="color: #222222; font-family: \'Source Sans Pro\', Arial, sans-serif; font-size: 18px; background-color: #ffffff;"> is performed by a human sitting in front of a computer carefully executing the test steps.</span></p>
</body>
</html>',
                    'requirement' => '<p> </p>',
                    'course_requirment' =>
                        array(
                            0 =>
                                array(
                                    'info' => '',
                                    'attach' => false,
                                ),
                        ),
                    'code' => NULL,
                    'course_alias_name_en' => 'Software automation',
                    'totalEnroll' => 1,
                    'averageRating' => 3,
                    'totalRatingCount' => 2,
                    'logo_image' => '5dbfaf79863b7.png',
                    'thumnail' =>
                        array(
                            'file_name' => 'image-1-1620547108.png',
                            'file_encode_path' => 'dXNlci0xL2ltYWdlLTEtMTYyMDU0NzEwOA==.png',
                            'owner_id' => 1,
                            'created_by' => 1,
                        ),
                    'course_duration' => NULL,
                    'admission_status' => 1,
                    'reg_start_date' => NULL,
                    'reg_end_date' => NULL,
                    'start_date' => NULL,
                    'end_date' => NULL,
                    'institution_name_bn' => 'মুক্তপাঠ',
                    'institution_name' => 'OrangeBD Super Admin',
                    'slug' => 'Eng',
                    'courseStatistics' =>
                        array(
                            'total_lesson' => 4,
                            'total_content' => 4,
                            'quiz' => 0,
                            'exam' => 0,
                            'assignment' => 0,
                        ),
                ),
            2 =>
                array(
                    'wishlist_status' => 0,
                    'id' => 22,
                    'title' => 'Batch-27',
                    'course_alias_name' => 'UISC User Training Bangla',
                    'payment_point_amount' => NULL,
                    'enrolment_approval_status' => 0,
                    'discount' =>
                        array(
                            'amount' => '',
                            'type' => '0',
                            'date' => '',
                        ),
                    'discount_status' => 0,
                    'payment_status' => 0,
                    'certificate_approval_status' => 1,
                    'details' => '',
                    'requirement' => '<p> </p>',
                    'course_requirment' =>
                        array(
                            0 =>
                                array(
                                    'info' => '',
                                    'attach' => false,
                                ),
                        ),
                    'code' => NULL,
                    'course_alias_name_en' => 'UISC User Training',
                    'totalEnroll' => 2,
                    'averageRating' => 3,
                    'totalRatingCount' => 2,
                    'logo_image' => '5dbfaf79863b7.png',
                    'thumnail' =>
                        array(
                            'file_name' => 'image-1-1610514732.jpg',
                            'file_encode_path' => 'dXNlci0xL2ltYWdlLTEtMTYxMDUxNDczMg==.jpg',
                            'owner_id' => 1,
                            'created_by' => 1,
                        ),
                    'course_duration' => NULL,
                    'admission_status' => 1,
                    'reg_start_date' => NULL,
                    'reg_end_date' => NULL,
                    'start_date' => NULL,
                    'end_date' => NULL,
                    'institution_name_bn' => 'মুক্তপাঠ',
                    'institution_name' => 'OrangeBD Super Admin',
                    'slug' => 'Eng',
                    'courseStatistics' =>
                        array(
                            'total_lesson' => 6,
                            'total_content' => 5,
                            'quiz' => 1,
                            'exam' => 0,
                            'assignment' => 0,
                        ),
                ),
            3 =>
                array(
                    'wishlist_status' => 0,
                    'id' => 18,
                    'title' => 'Batch-1',
                    'course_alias_name' => 'Email Marketing Made Easy For Beginners',
                    'payment_point_amount' => 10,
                    'enrolment_approval_status' => 0,
                    'discount' =>
                        array(
                            'amount' => 0,
                            'type' => '0',
                            'date' => '',
                        ),
                    'discount_status' => 0,
                    'payment_status' => 1,
                    'certificate_approval_status' => 0,
                    'details' => '<!DOCTYPE html>
<html>
<head>
</head>
<body>
<ul>
<li class="objective--objective-item--13Jmw" style="box-sizing: border-box; align-items: flex-start; display: flex; color: #1c1d1f; font-family: \'sf pro text\', -apple-system, BlinkMacSystemFont, Roboto, \'segoe ui\', Helvetica, Arial, sans-serif, \'apple color emoji\', \'segoe ui emoji\', \'segoe ui symbol\'; font-size: 16px; text-align: left;"><span style="box-sizing: border-box; margin: 0px; padding: 0px;"><span style="font-size: 14px;">Email marketing is by far the most effective internet marketing method that you can use in an online business.  It doesn\'t matter if you sell products, services, or simply rely on advertising to make money from your website, email marketing will give you the greatest return on investment in all online business models.   However, the only way you\'ll see success with email marketing is if you build effective campaigns, and that\'s what this cour covers the basics of.</span><br /></span></li>
</ul>
</body>
</html>',
                    'requirement' => '<p> </p>',
                    'course_requirment' =>
                        array(
                            0 =>
                                array(
                                    'info' => '',
                                    'attach' => false,
                                ),
                        ),
                    'code' => NULL,
                    'course_alias_name_en' => 'Email Marketing Made Easy For Beginners',
                    'totalEnroll' => 1,
                    'averageRating' => 3,
                    'totalRatingCount' => 2,
                    'logo_image' => '5dbfaf79863b7.png',
                    'thumnail' =>
                        array(
                            'file_name' => 'image-1-1610963435.jpg',
                            'file_encode_path' => 'dXNlci0xL2ltYWdlLTEtMTYxMDk2MzQzNQ==.jpg',
                            'owner_id' => 1,
                            'created_by' => 1,
                        ),
                    'course_duration' => '1hr 11min',
                    'admission_status' => 1,
                    'reg_start_date' => NULL,
                    'reg_end_date' => NULL,
                    'start_date' => NULL,
                    'end_date' => NULL,
                    'institution_name_bn' => 'মুক্তপাঠ',
                    'institution_name' => 'OrangeBD Super Admin',
                    'slug' => 'Eng',
                    'courseStatistics' =>
                        array(
                            'total_lesson' => 0,
                            'total_content' => 0,
                            'quiz' => 0,
                            'exam' => 0,
                            'assignment' => 0,
                        ),
                ),
        );
    }
}
