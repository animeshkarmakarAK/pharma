<?php

namespace Module\CourseManagement\App\Models;

use Faker\Provider\Uuid;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;

class YouthImport implements WithMapping, WithStartRow, WithChunkReading, WithBatchInserts
{
    use Importable;

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function map($row): array
    {
        return [
            "access_key"=>Youth::getUniqueAccessKey(),
            "name_en"=>$row[0],
            "name_bn"=>$row[1],
            "mobile"=>$row[2],
            "email"=>$row[3],
            "present_address_division_id"=>$row[4],
            "present_address_district_id"=>$row[5],
            "present_address_upazila_id"=>$row[6],
            "present_address_house_address"=>$row[7],
            "permanent_address_division_id"=>$row[8],
            "permanent_address_district_id"=>$row[9],
            "permanent_address_upazila_id"=>$row[10],
            "permanent_address_house_address"=>$row[11],
            "ethnic_group"=>$row[12],
            "youth_registration_no"=>$row[13],
            "recommended_by_organization"=>$row[14],
            "recommended_org_name"=>$row[15],
            "current_employment_status"=>$row[16],
            "year_of_experience"=>$row[17],
            "personal_monthly_income"=>$row[18],
            "have_family_own_house"=>$row[19],
            "have_family_own_land"=>$row[20],
            "number_of_siblings"=>$row[21],
            "student_signature_pic"=>$row[22],
            "student_pic"=>$row[23],
            "row_status"=>$row[24],
            "member_name_en"=>$row[25],
            "member_name_bn"=>$row[26],
            "member_mobile"=>$row[27],
            "educational_qualification"=>$row[28],
            "relation_with_youth"=>$row[29],
            "is_guardian"=>$row[30],
            "member_personal_monthly_income"=>$row[31],
            "gender"=>$row[32],
            "marital_status"=>$row[33],
            "main_occupation"=>$row[34],
            "other_occupations"=>$row[35],
            "physical_disabilities"=>$row[36],
            "disable_status"=>$row[37],
            "freedom_fighter_status"=>$row[38],
            "nid"=>$row[39],
            "birth_certificate_no"=>$row[40],
            "passport_number"=>$row[41],
            "religion"=>$row[42],
            "nationality"=>$row[43],
            "date_of_birth"=>date_format(date_create($row[44]),"Y-m-d"),
            "examination"=>$row[45],
            "examination_name"=>$row[46],
            "board"=>$row[47],
            "institute"=>$row[48],
            "roll_no"=>$row[49],
            "reg_no"=>$row[50],
            "grade"=>$row[51],
            "result"=>$row[52],
            "group"=>$row[53],
            "passing_year"=>$row[54],
            "subject"=>$row[55],
            "course_duration"=>$row[56]
        ];
    }

    public function startRow(): int
    {
        return 2;
    }
}
