<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class OrganizationUnitType
 * @package Module\GovtStakeholder\App\Models
 * @property string title_en
 * @property string title_bn
 * @property-read HumanResourceTemplate humanResourceTemplate
 */
class OrganizationUnitType extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait;

    protected $guarded = ['id'];

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
