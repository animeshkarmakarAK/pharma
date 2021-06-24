<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class OrganizationUnitType
 * @package Module\GovtStakeholder\App\Models
 * @property string title_en
 * @property string title_bn
 * @property int organization_id
 * @property-read HumanResourceTemplate humanResourceTemplate
 * @property-read Organization organization
 */
class OrganizationUnitType extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait;

    protected $guarded = ['id'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
    public function humanResourceTemplate(): HasMany
    {
        return $this->hasMany(HumanResourceTemplate::class);
    }

    public function getHierarchy()
    {
        $topRoot = $this->humanResourceTemplate->where('parent_id', null)->first();
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
        $root['organization_unit_type_title'] = $root->organizationUnitType->title_en;

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
}
