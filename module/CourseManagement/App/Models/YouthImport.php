<?php

namespace Module\CourseManagement\App\Models;

use Faker\Provider\Uuid;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Module\CourseManagement\App\Services\YouthManagementService;

class YouthImport implements WithMapping, WithStartRow, WithChunkReading, WithBatchInserts
{
    use Importable;

    public const NULL = "null";

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
        $locationInfo = app(YouthManagementService::class);
        $requiredFields = [
            "access_key" => Youth::getUniqueAccessKey(),
            "mobile" => $row[2],
            "email" => $row[3],
            "present_address_division_id" => $locationInfo->getDivisionId($row[4]),
            "present_address_district_id" => $locationInfo->getDistrictId($row[5],$row[4]),
            "present_address_upazila_id" => $locationInfo->getUpazilaId($row[6],$row[5]),
            "present_address_house_address" => $row[7],
            "permanent_address_division_id" => $locationInfo->getDivisionId($row[8]),
            "permanent_address_district_id" => $locationInfo->getDistrictId($row[9],$row[8]),
            "permanent_address_upazila_id" => $locationInfo->getUpazilaId($row[10],$row[9]),
            "permanent_address_house_address" => $row[11],

            /** Youth Family information */
            "member_mobile" => $row[26],
            "relation_with_youth" => $row[28],

            /** Youth Educational Qualifications */
            "examination" => Youth::EXAMINATION_LEVELS[$row[44]]??Youth::EXAMINATION_OTHERS,
            "examination_name" => $row[45],
        ];

        /** Youth Nullable Field */
        if (strtolower($row[0]) != self::NULL) {
            $requiredFields['name_en'] = $row[0];
        }
        if (strtolower($row[0]) != self::NULL) {
            $requiredFields['name_bn'] = $row[1];
        }
        if (strtolower($row[12]) != self::NULL) {
            $requiredFields['ethnic_group'] = Youth::STATUS_CODE_WITH_LABEL[$row[12]] ?? Youth::FALSE;
        }
        if (strtolower($row[13]) != self::NULL) {
            $requiredFields['youth_registration_no'] = $row[13];
        }
        if (strtolower($row[14]) != self::NULL) {
            $requiredFields['recommended_by_organization'] = $row[14];
        }
        if (strtolower($row[15]) != self::NULL) {
            $requiredFields['recommended_org_name'] = $row[15];
        }
        if (strtolower($row[16]) != self::NULL) {
            $requiredFields['current_employment_status'] = Youth::STATUS_CODE_WITH_LABEL[$row[16]] ?? Youth::FALSE;
        }
        if (strtolower($row[17]) != self::NULL) {
            $requiredFields['year_of_experience'] = $row[17];
        }
        if (strtolower($row[18]) != self::NULL) {
            $requiredFields['personal_monthly_income'] = $row[18];
        }
        if (strtolower($row[19]) != self::NULL) {
            $requiredFields['have_family_own_house'] = Youth::STATUS_CODE_WITH_LABEL[$row[19]] ?? Youth::FALSE;
        }
        if (strtolower($row[20]) != self::NULL) {
            $requiredFields['have_family_own_land'] = Youth::STATUS_CODE_WITH_LABEL[$row[20]] ?? Youth::FALSE;
        }
        if (strtolower($row[21]) != self::NULL) {
            $requiredFields['number_of_siblings'] = $row[21];
        }
        if (strtolower($row[22]) != self::NULL) {
            $requiredFields['student_signature_pic'] = $row[22];
        }
        if (strtolower($row[23]) != self::NULL) {
            $requiredFields['student_pic'] = $row[23];
        }

        /** Youth Family Information */
        if (strtolower($row[24]) != self::NULL) {
            $requiredFields['member_name_en'] = $row[24];
        }
        if (strtolower($row[25]) != self::NULL) {
            $requiredFields['member_name_bn'] = $row[25];
        }
        if (strtolower($row[27]) != self::NULL) {
            $requiredFields['educational_qualification'] = $row[27];
        }
        if (strtolower($row[29]) != self::NULL) {
            $requiredFields['is_guardian'] = Youth::STATUS_CODE_WITH_LABEL[$row[29]] ?? Youth::TRUE;
        }
        if (strtolower($row[30]) != self::NULL) {
            $requiredFields['member_personal_monthly_income'] = $row[30];
        }
        if (strtolower($row[31]) != self::NULL) {
            $requiredFields['gender'] = Youth::GENDER_STATUS[$row[31]] ?? Youth::GENDER_OTHERS;
        }
        if (strtolower($row[32]) != self::NULL) {
            $requiredFields['marital_status'] = Youth::STATUS_CODE_WITH_LABEL[$row[32]] ?? Youth::FALSE;
        }
        if (strtolower($row[33]) != self::NULL) {
            $requiredFields['main_occupation'] = $row[33];
        }
        if (strtolower($row[34]) != self::NULL) {
            $requiredFields['other_occupations'] = $row[34];
        }
        if (strtolower($row[35]) != self::NULL) {
            $requiredFields['physical_disabilities'] = $row[35];
        }
        if (strtolower($row[36]) != self::NULL) {
            $requiredFields['disable_status'] = Youth::STATUS_CODE_WITH_LABEL[$row[26]] ?? Youth::FALSE;;
        }
        if (strtolower($row[37]) != self::NULL) {
            $requiredFields['freedom_fighter_status'] = Youth::STATUS_CODE_WITH_LABEL[$row[37]] ?? Youth::FALSE;;
        }
        if (strtolower($row[38]) != self::NULL) {
            $requiredFields['nid'] = $row[38];
        }
        if (strtolower($row[39]) != self::NULL) {
            $requiredFields['birth_certificate_no'] = $row[39];
        }
        if (strtolower($row[40]) != self::NULL) {
            $requiredFields['passport_number'] = $row[40];
        }
        if (strtolower($row[41]) != self::NULL) {
            $requiredFields['religion'] = Youth::RELIGIONS[$row[41]] ?? Youth::RELIGION_OTHERS;
        }
        if (strtolower($row[42]) != self::NULL) {
            $requiredFields['nationality'] = $row[42];
        }
        if (strtolower($row[43]) != self::NULL) {
            $requiredFields['date_of_birth'] = date_format(date_create($row[43]), "Y-m-d");
        }

        /** Youth Academic Info Nullable Fields*/
        if (strtolower($row[46]) != self::NULL) {
            $requiredFields['board'] = Youth::EXAMINATION_BOARDS[$row[46]] ?? Youth::EXAMINATION_BOARD_OTHERS;
        }
        if (strtolower($row[47]) != self::NULL) {
            $requiredFields['institute'] = $row[47];
        }
        if (strtolower($row[48]) != self::NULL) {
            $requiredFields['roll_no'] = $row[48];
        }
        if (strtolower($row[49]) != self::NULL) {
            $requiredFields['reg_no'] = $row[49];
        }
        if (strtolower($row[50]) != self::NULL) {
            $requiredFields['result'] = Youth::EXAMINATION_RESULTS[$row[50]] ?? Youth::EXAMINATION_RESULT_PASSED;
        }
        if (strtolower($row[51]) != self::NULL) {
            $requiredFields['grade'] = $row[51];
        }
        if (strtolower($row[52]) != self::NULL) {
            $requiredFields['group'] = Youth::EXAMINATION_GROUPS[$row[52]] ?? Youth::EXAMINATION_GROUP_OTHERS;
        }
        if (strtolower($row[53]) != self::NULL) {
            $requiredFields['passing_year'] = $row[53];
        }
        if (strtolower($row[54]) != self::NULL) {
            $requiredFields['subject'] = $row[54];
        }
        if (strtolower($row[55]) != self::NULL) {
            $requiredFields['course_duration'] = Youth::EXAMINATION_COURSE_DURATION[$row[55]] ?? 0;
        }
        return $requiredFields;

    }

    public function startRow(): int
    {
        return 2;
    }
}
