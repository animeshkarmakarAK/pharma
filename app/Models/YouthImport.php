<?php

namespace App\Models;

use App\Helpers\Classes\Helper;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Services\YouthManagementService;
use App\Services\YouthService;

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
            "present_address_district_id" => $locationInfo->getDistrictId($row[5], $row[4]),
            "present_address_upazila_id" => $locationInfo->getUpazilaId($row[6], $row[5]),
            "present_address_house_address" => json_decode($row[7],true),
            "permanent_address_division_id" => $locationInfo->getDivisionId($row[8]),
            "permanent_address_district_id" => $locationInfo->getDistrictId($row[9], $row[8]),
            "permanent_address_upazila_id" => $locationInfo->getUpazilaId($row[10], $row[9]),
            "permanent_address_house_address" =>  json_decode($row[11],true)
        ];


        /** Youth Nullable Field */
        $selfInfo = [];

        $requiredFields['youth_registration_no'] = Helper::randomPassword(10, true);

        if (strtolower($row[12]) != self::NULL) {
            $requiredFields['ethnic_group'] = Youth::STATUS_CODE_WITH_LABEL[$row[12]] ?? Youth::FALSE;
        }
        if (strtolower($row[13]) != self::NULL) {
            $requiredFields['current_employment_status'] = Youth::STATUS_CODE_WITH_LABEL[$row[13]] ?? Youth::FALSE;
        }
        if (strtolower($row[14]) != self::NULL) {
            $requiredFields['year_of_experience'] = $row[14];
        }

        if (strtolower($row[16]) != self::NULL) {
            $requiredFields['have_family_own_house'] = Youth::STATUS_CODE_WITH_LABEL[$row[16]] ?? Youth::FALSE;
        }
        if (strtolower($row[17]) != self::NULL) {
            $requiredFields['have_family_own_land'] = Youth::STATUS_CODE_WITH_LABEL[$row[17]] ?? Youth::FALSE;
        }
        if (strtolower($row[18]) != self::NULL) {
            $requiredFields['number_of_siblings'] = $row[18];
        }
        if (strtolower($row[19]) != self::NULL) {
            $requiredFields['student_signature_pic'] = $row[19];
        }
        if (strtolower($row[20]) != self::NULL) {
            $requiredFields['student_pic'] = $row[20];
        }

        if (strtolower($row[20]) != self::NULL) //TODO::Last Column add
        {
            $requiredFields['recommended_org_name'] = $row[20];
        }

        /** Self Information */
        if (strtolower($row[0]) != self::NULL) {
            $requiredFields['name'] = $row[0];
            $selfInfo['member_name'] = $row[0];
        }
        if (strtolower($row[1]) != self::NULL) {
            $requiredFields['name'] = $row[1];
            $selfInfo['member_name'] = $row[1];
            $selfInfo['mobile'] = $requiredFields['mobile'];
        }
        if (strtolower($row[15]) != self::NULL) {
            $requiredFields['personal_monthly_income'] = $row[15];
            $selfInfo["personal_monthly_income"] = $row[15];
        }
        if (strtolower($row[21]) != self::NULL) {
            $selfInfo['gender'] = Youth::GENDER_STATUS[$row[21]] ?? Youth::GENDER_OTHERS;
        }
        if (strtolower($row[22]) != self::NULL) {
            $selfInfo['marital_status'] = Youth::STATUS_CODE_WITH_LABEL[$row[22]] ?? Youth::FALSE;
        }
        if (strtolower($row[23]) != self::NULL && YouthService::isDate($row[23])) {
            $selfInfo['date_of_birth'] = date("Y-m-d", strtotime($row[23]));
        }
        if (strtolower($row[24]) != self::NULL) {
            $selfInfo['nid'] = $row[24];
        }
        if (strtolower($row[25]) != self::NULL) {
            $selfInfo['birth_certificate_no'] = $row[25];
        }
        if (strtolower($row[26]) != self::NULL) {
            $selfInfo['passport_number'] = $row[26];
        }
        if (strtolower($row[27]) != self::NULL) {
            $selfInfo['religion'] = Youth::RELIGIONS[$row[27]] ?? Youth::RELIGION_OTHERS;
        }
        if (strtolower($row[28]) != self::NULL) {
            $selfInfo['nationality'] = $row[28];
        }
        if (strtolower($row[29]) != self::NULL) {
            $selfInfo['physical_disabilities'] = $row[29];
            $selfInfo['disable_status'] = Youth::TRUE;
        }
        if (strtolower($row[30]) != self::NULL) {
            $selfInfo['freedom_fighter_status'] = Youth::STATUS_CODE_WITH_LABEL[$row[30]] ?? Youth::FALSE;;
        }
        if (strtolower($row[31]) != self::NULL) {
            $selfInfo['main_occupation'] = $row[31];
        }
        if (strtolower($row[32]) != self::NULL) {
            $selfInfo['other_occupations'] = $row[32];
        }
        $selfInfo['relation_with_youth'] = 'self';
        $requiredFields['youth_family_info'][] = $selfInfo;

        /** Youth Family Information */
        $fatherInfo = [];
        $motherInfo = [];
        $guardianInfo = [];

        $fatherInfo['member_name'] = $row[33];
        $fatherInfo['mobile'] = $row[35];
        $fatherInfo['nid'] = $row[36];
        if ($row[43] == Youth::GUARDIAN_FATHER_LABEL) {
            $fatherInfo['is_guardian'] = Youth::GUARDIAN_STATUS[$row[43]];
        }
        if (strtolower($row[37]) != self::NULL && YouthService::isDate($row[37])) {
            $fatherInfo['date_of_birth'] = date("Y-m-d", strtotime($row[37]));
        }

        $fatherInfo['relation_with_youth'] = 'father';
        $requiredFields['youth_family_info'][] = $fatherInfo;

        $motherInfo['member_name'] = $row[38];
        $motherInfo['mobile'] = $row[40];
        $motherInfo['nid'] = $row[41];
        if ($row[43] == Youth::GUARDIAN_MOTHER_LABEL) {
            $motherInfo['is_guardian'] = Youth::GUARDIAN_STATUS[$row[43]];
        }
        if (strtolower($row[42]) != self::NULL && YouthService::isDate($row[42])) {
            $motherInfo['date_of_birth'] = date("Y-m-d", strtotime($row[42]));
        }
        $motherInfo['relation_with_youth'] = 'mother';
        $requiredFields['youth_family_info'][] = $motherInfo;

        if ($row[43] == Youth::GUARDIAN_OTHER_LABEL) {
            $guardianInfo['member_name'] = $row[44];
            $guardianInfo['mobile'] = $row[46];
            $guardianInfo['nid'] = $row[47];
            if (strtolower($row[48]) != self::NULL && YouthService::isDate($row[48])) {
                $guardianInfo['date_of_birth'] = date("Y-m-d", strtotime($row[48]));
            }
            $guardianInfo['is_guardian'] = Youth::GUARDIAN_STATUS[$row[43]];
            $guardianInfo['relation_with_youth'] = $row[49];
            $requiredFields['youth_family_info'][] = $guardianInfo;
        }

        /** Youth Academic Info Nullable Fields*/
        $jscInfo = [];
        $sscInfo = [];
        $hscInfo = [];
        $honorsInfo = [];
        $mastersInfo = [];

        if (strtolower($row[50]) != self::NULL) {
            $jscInfo['examination_name'] = $row[50];
            $jscInfo['examination'] = YouthAcademicQualification::EXAMINATION_JSC;
            $jscInfo['result'] = YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE;
        }
        if (strtolower($row[51]) != self::NULL) {
            $jscInfo['board'] = Youth::EXAMINATION_BOARDS[$row[51]] ?? 0;
        }
        if (strtolower($row[52]) != self::NULL) {
            $jscInfo['roll_no'] = $row[52];
        }
        if (strtolower($row[53]) != self::NULL) {
            $jscInfo['reg_no'] = $row[53];
        }
        if (strtolower($row[54]) != self::NULL) {
            $jscInfo['grade'] = $row[54];
        }
        if (strtolower($row[55]) != self::NULL) {
            $jscInfo['passing_year'] = $row[55];
        }

        $requiredFields['youth_academic_info'][] = $jscInfo;

        /** SSC Academic info */
        if (strtolower($row[56]) != self::NULL) {
            $sscInfo['examination_name'] = $row[56];
            $sscInfo['examination'] = YouthAcademicQualification::EXAMINATION_SSC;
        }
        if (strtolower($row[57]) != self::NULL) {
            $sscInfo['board'] = Youth::EXAMINATION_BOARDS[$row[57]] ?? 0;
        }
        if (strtolower($row[58]) != self::NULL) {
            $sscInfo['roll_no'] = $row[58];
        }
        if (strtolower($row[59]) != self::NULL) {
            $sscInfo['reg_no'] = $row[59];
        }
        if (strtolower($row[60]) != self::NULL) {
            $sscInfo['result'] = Youth::EXAMINATION_RESULTS[$row[60]] ?? YouthAcademicQualification::EXAMINATION_RESULT_FIRST_DIVISION;
        }
        if (strtolower($row[61]) != self::NULL) {
            $sscInfo['grade'] = $row[61];
        }
        if (strtolower($row[62]) != self::NULL) {
            $sscInfo['group'] = Youth::EXAMINATION_GROUPS[$row[62]] ?? Youth::EXAMINATION_GROUP_OTHERS;
        }
        if (strtolower($row[63]) != self::NULL) {
            $sscInfo['passing_year'] = $row[63];
        }
        $requiredFields['youth_academic_info'][] = $sscInfo;

        /** HSC Academic info */
        if (strtolower($row[64]) != self::NULL) {
            $hscInfo['examination_name'] = $row[64] ?? self::NULL;
            $hscInfo['examination'] = YouthAcademicQualification::EXAMINATION_HSC;
        }
        if (strtolower($row[65]) != self::NULL) {
            $hscInfo['board'] = Youth::EXAMINATION_BOARDS[$row[65]] ?? 0;
        }
        if (strtolower($row[66]) != self::NULL) {
            $hscInfo['roll_no'] = $row[66];
        }
        if (strtolower($row[67]) != self::NULL) {
            $hscInfo['reg_no'] = $row[67];
        }
        if (strtolower($row[68]) != self::NULL) {
            $hscInfo['result'] = Youth::EXAMINATION_RESULTS[$row[68]] ?? YouthAcademicQualification::EXAMINATION_RESULT_FIRST_DIVISION;
        }
        if (strtolower($row[69]) != self::NULL) {
            $hscInfo['grade'] = $row[69];
        }
        if (strtolower($row[70]) != self::NULL) {
            $hscInfo['group'] = Youth::EXAMINATION_GROUPS[$row[70]] ?? Youth::EXAMINATION_GROUP_OTHERS;
        }
        if (strtolower($row[71]) != self::NULL) {
            $hscInfo['passing_year'] = $row[71];
        }
        $requiredFields['youth_academic_info'][] = $hscInfo;

        /** Honor's Academic info */
        if (strtolower($row[72]) != self::NULL) {
            $honorsInfo['examination_name'] = $row[72];
            $honorsInfo['examination'] = YouthAcademicQualification::EXAMINATION_GRADUATION;
        }
        if (strtolower($row[73]) != self::NULL) {
            $honorsInfo['subject'] = $row[73];
        }
        if (strtolower($row[74]) != self::NULL) {
            $honorsInfo['institute'] = $row[74];
        }
        if (strtolower($row[75]) != self::NULL) {
            $honorsInfo['result'] = Youth::EXAMINATION_RESULTS[$row[75]] ?? YouthAcademicQualification::EXAMINATION_RESULT_FIRST_DIVISION;
        }
        if (strtolower($row[76]) != self::NULL) {
            $honorsInfo['grade'] = $row[76];
        }
        if (strtolower($row[77]) != self::NULL) {
            $honorsInfo['passing_year'] = $row[77];
        }
        if (strtolower($row[78]) != self::NULL) {
            $honorsInfo['course_duration'] = Youth::EXAMINATION_COURSE_DURATION[$row[77]] ?? YouthAcademicQualification::EXAMINATION_COURSE_DURATION_ONE_YEAR;
        }
        $requiredFields['youth_academic_info'][] = $honorsInfo;

        /** Master's Academic info */
        if (strtolower($row[79]) != self::NULL) {
            $mastersInfo['examination_name'] = $row[79];
            $mastersInfo['examination'] = YouthAcademicQualification::EXAMINATION_GRADUATION;
        }
        if (strtolower($row[80]) != self::NULL) {
            $mastersInfo['subject'] = $row[80];
        }
        if (strtolower($row[81]) != self::NULL) {
            $mastersInfo['institute'] = $row[81];
        }
        if (strtolower($row[82]) != self::NULL) {
            $mastersInfo['result'] = Youth::EXAMINATION_RESULTS[$row[82]] ?? YouthAcademicQualification::EXAMINATION_RESULT_FIRST_DIVISION;
        }
        if (strtolower($row[83]) != self::NULL) {
            $mastersInfo['grade'] = $row[83];
        }
        if (strtolower($row[84]) != self::NULL) {
            $mastersInfo['passing_year'] = $row[84];
        }
        if (strtolower($row[85]) != self::NULL) {
            $mastersInfo['course_duration'] = Youth::EXAMINATION_COURSE_DURATION[$row[85]] ?? 0;
        }
        $requiredFields['youth_academic_info'][] = $mastersInfo;

        return $requiredFields;

    }

    public function startRow(): int
    {
        return 2;
    }

}
