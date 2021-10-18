<?php

namespace Module\GovtStakeholder\App\Services;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Module\CourseManagement\App\Models\OrganizationComplainToYouth;

class OrganizationComplainToYouthService
{
    public function validateOrganizationComplainToYouth(Request $request): Validator
    {
        $rules = [
            'institute_id' => [
                'required',
                'integer',
                'exists:institutes,id'
            ],
            'organization_id' => [
                'required',
                'integer',
                'exists:organizations,id'
            ],
            'youth_id' => [
                'exists:youths,id'
            ],
            'complain_title' => [
                'required',
                'string',
            ],
            'complain_message' => [
                'required',
                'string',
            ],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function addOrganizationComplainToYouth(array $data): OrganizationComplainToYouth
    {
        return OrganizationComplainToYouth::create($data);
    }

}
