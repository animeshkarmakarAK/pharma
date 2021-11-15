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
 * @property string respondent_others_detail
 * @property string industry_sector
 * @property string industry_started
 * @property string industry_association
 * @property string industry_type
 * @property int total_employee_one
 * @property int full_time_employee_one
 * @property int half_time_employee_one
 * @property int female_number_one
 * @property int male_number_one
 * @property string others_number_one
 * @property int others_total_number
 * @property string unhelped_group
 * @property int unhelped_group_number
 * @property string disabled_person
 * @property int disabled_person_number
 * @property int senior_level_one
 * @property int middle_level_one
 * @property int junior_level_one
 * @property string outside_employee
 * @property int other_country_employee_number
 * @property int senior_level_two
 * @property int middle_level_two
 * @property int junior_level_two
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
    protected $fillable = ['informant_name','informant_email','informant_mobile','informant_date',
        'respondent_name','respondent_designation','respondent_others_detail','industry_sector','industry_started','industry_association',
        'industry_type','total_employee_one','full_time_employee_one','half_time_employee_one','female_number_one','male_number_one',
        'others_number_one','others_total_number','unhelped_group','unhelped_group_number','disabled_person','disabled_person_number',
        'senior_level_one','senior_level_two','senior_level_three','employee_problem','employee_problem_detail','employee_recruitment',
        'institute_facilities','recruitment_media','decision_problem_1','decision_problem_2','decision_problem_3','decision_problem_4',
        'decision_problem_5'];


    public function organizationEfficient(): HasMany
    {
        return $this->hasMany(OrganizationEfficient::class);
    }


}
