<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class YouthApplicationForCourseRegistrationTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_youth_registration_for_course()
    {
        $response = $this->post(route('youth-registrations.store'), [
            '_token' => csrf_token(),
            "name_en" => "xcv",
            "name_bn" => "বাংলা",
            "institute_id" => "1",
            "branch_id" => "1",
            "course_id" => "1",
            "gender" => "1",
            "mobile" => "01757808214",
            "date_of_birth" => "2021-06-01",
            "marital_status" => "2",
            "religion" => "2",
            "nationality" => "bd",
            "nid" => "12345678rt",
            "ethnic_group" => "2",
            "address" => [
                "present" => [
                    "present_address_division_id" => "3",
                    "present_address_district_id" => "18",
                    "present_address_upazila_id" => "113",
                    "present_address_house_address" => [
                        "postal_code" => "1216",
                        "village_name" => "dfsg",
                        "house_and_road" => "dsfg2",
                    ],
                ],
                "permanent" => [
                    "permanent_address_division_id" => "3",
                    "permanent_address_district_id" => "18",
                    "permanent_address_upazila_id" => "113",
                    "permanent_address_house_address" => [
                        "postal_code" => "1216",
                        "village_name" => "dfsg",
                        "house_and_road" => "dsfg2",
                    ],
                ],
            ],
            "permanent_address_same_as_present_address" => "on",
            "familyMember" => [
                "father" => [
                    "member_name_en" => "xcv",
                    "date_of_birth" => "2021-06-01",
                    "nid" => "234234234234",
                    "mobile" => "01757808214",
                    "relation_with_youth" => "Father",
                ],
                "mother" => [
                    "member_name_en" => "xcv",
                    "date_of_birth" => "2021-06-01",
                    "nid" => "1234567899",
                    "mobile" => "01757808214",
                    "relation_with_youth" => "Mother",
                ],
            ],
            'student_pic' => UploadedFile::fake()->image('avatar.jpg'),
            'student_signature_pic' => UploadedFile::fake()->image('avatar.jpg'),

            /*'name_en' => 'Chaki',
            'name_bn' => 'চাকি',
            //'institute_id' => '1',
            //'course_id' => 1,
            'gender' => 1,
            'mobile' => '01757808214',
            'date_of_birth' => '21/04/1993',
            'marital_status' => 1,
            'religion' => 1,
            'nationality' => 'bd',
            'nid' => '12345678901',
            'freedom_fighter_status' => 3,
            'disable_status' => 2,
            'student_pic' => '',
            'student_signature_pic' => 2,
            'address.present.present.division_id' => '1',
            'present_address_district_id' => '1',
            'present_address_upazila_id' => '1',
            'present_address_postal_code' => '2222',
            'present_address_village_name' => '2',
            'present_address_house_and_road' => '2',
            'permanent_address_division_id' => '1',
            'permanent_address_district_id' => '1',
            'permanent_address_upazila_id' => '1',
            'permanent_address_postal_code' => '2222',
            'permanent_address_village_name' => '2',
            'permanent_address_house_and_road' => '2',
            'permanent_address_same_as_present_address' => 1,
            'father_name' => 's Chaki',
            'fathers_date_of_birth' => '22/2/1965',
            'fathers_nid' => '2222222222',
            'fathers_mobile' => '01700000000',
            'mother_name' => 's Chaki',
            'mothers_date_of_birth' => '22/2/1965',
            'mothers_nid' => '2222222222',
            'mothers_mobile' => '01700000000',*/
        ]);
        //dd($response->assertSessionHasNoErrors());

    }
}
