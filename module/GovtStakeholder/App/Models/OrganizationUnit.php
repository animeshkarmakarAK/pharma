<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\LocDistrictBelongsToRelation;
use App\Traits\LocDivisionBelongsToRelation;
use App\Traits\LocUpazilaBelongsToRelation;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Module\GovtStakeholder\App\Traits\ScopeAclTrait;

/**
 * Class OrganizationUnit
 * @package Module\GovtStakeholder\App\Models
 * @property string title_en
 * @property string title_bn
 * @property int organization_id
 * @property int organization_unit_type_id
 * @property string address
 * @property string mobile
 * @property string email
 * @property string fax_no
 * @property string contact_person_name
 * @property string contact_person_email
 * @property string contact_person_mobile
 * @property string contact_person_designation
 * @property int employee_size
 * @property-read Organization organization
 * @property-read OrganizationUnitType organizationUnitType
 * @method static \Illuminate\Database\Eloquent\Builder|Organization acl()
 * @method static Builder|Organization active()
 * @method static Builder|Organization newModelQuery()
 * @method static Builder|Organization newQuery()
 * @method static Builder|Organization query()
 */
class OrganizationUnit extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, LocDistrictBelongsToRelation, LocDivisionBelongsToRelation, LocUpazilaBelongsToRelation, ScopeAclTrait;

    protected $guarded = ['id'];


    public function getHierarchy()
    {
        $topRoot = $this->humanResources->where('parent_id', null)->first();
        if (!$topRoot) {
            return null;
        }
        $topRoot->load('children');
        return $this->makeHierarchy($topRoot);
    }

    public function makeHierarchy($root)
    {
        $root['name'] = $root->title_en;
        $root['parent'] = $root->parent_id;
        $root['organization_title'] = $root->organization->title_en;

        $children = $root->children;

        if (empty($children)) {
            return $root;
        }

        foreach ($children as $key => $child) {
            $root['children'][$key] = $child;
            $this->makeHierarchy($child);
        }
        return $root;
    }

    /**************************
     *   ----Relationships----
     **************************/
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function organizationUnitType(): BelongsTo
    {
        return $this->belongsTo(OrganizationUnitType::class);
    }

    public function humanResources(): HasMany
    {
        return $this->hasMany(HumanResource::class);
    }

    public function statistics(): HasOne
    {
        return $this->hasOne(organizationUnitStatistic::class);
    }
}
