<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Module\CourseManagement\App\Models\Youth;
use Module\GovtStakeholder\App\Traits\ScopeAclTrait;
use PhpParser\Builder;

/**
 * Class OrganizationInformation
 * @package Module\GovtStakeholder\App\Models
 * @property string informant_name
 * @property string informant_email
 * @property int informant_mobile
 * @property date informant_date
 * @property string respondent_name
 * @property string respondent_designation
 * @property string industry_sector
 * @property string industry_started
 * @property string industry_association
 * @property string industry_type
 * @property int total_employee_one
 * @property int full_time_emplyee_one
 * @property int half_time_employee_one
 * @property int female_number_one
 * @property int male_number_one
 * @property int others_number_one
 * @property int unhelped_group
 * @property int disabled_person
 * @property int senior_level_one
 * @property int middle_level_one
 * @property int junior_level_one
 * @property int outside_employee
 * @property int other_country_employee_number
 * @property int senior_level_two
 * @property int middle_level_two
 * @property int junior_level_two
 * @property string contact_person_designation
 * @property string employee_problem
 * @property string employee_problem_detail
 * @property string employee_recruitment
 * @property string institute_facilities
 * @property string recruitment_media
 * @property string decision_problem_1
 * @property string decision_problem_2
 * @property string decision_problem_3
 * @property string decision_problem_4
 * @property string decision_problem_5
 */
class OrganizationInformation extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait, ScopeAclTrait;


    protected $guarded = ['id'];
    protected $table = "organization_informations";


    public function organizationEfficient(): HasMany
    {
        return $this->hasMany(OrganizationEfficient::class);
    }


}
