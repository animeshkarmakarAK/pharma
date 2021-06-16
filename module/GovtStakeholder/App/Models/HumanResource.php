<?php

namespace Module\GovtStakeholder\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class HumanResource
 * @package Module\GovtStakeholder\App\Models
 * @property string title_en
 * @property string title_bn
 * @property int display_order
 * @property int human_resource_template_id
 * @property int organization_id
 * @property int organization_unit_id
 * @property int parent_id
 * @property int rank_id
 * @property int is_designation
 * @property int status
 * @property array skill_ids
 */

class HumanResource extends BaseModel
{
    use HasFactory;
}
