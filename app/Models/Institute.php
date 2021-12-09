<?php

namespace App\Models;

use App\Helpers\Classes\AuthHelper;
use App\Models\User;
use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * Class Institute
 * @package App\Models
 * @property string title_en
 * @property string|null title_bn
 * @property string code
 * @property string domain
 * @property string|null address
 * @property string|null google_map_src
 * @property string logo
 * @property string|null config
 * @method static \Illuminate\Database\Eloquent\Builder|Institute acl()
 * @method static Builder|Institute active()
 * @method static Builder|Institute newModelQuery()
 * @method static Builder|Institute newQuery()
 * @method static Builder|Institute query()
 */
class Institute extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait;

    protected $guarded = ['id'];

    const DEFAULT_LOGO = 'institute/default.jpg';

//    protected $casts = [
//        'phone_numbers' => 'array',
//        'mobile_numbers' => 'array',
//    ];

    public function setSlugAttribute($value) {

        if (static::whereSlug($slug = Str::slug($value))->exists()) {

            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug) {

        $original = $slug;

        $count = 2;

        while (static::whereSlug($slug)->exists()) {

            $slug = "{$original}-" . $count++;
        }

        return $slug;
    }

    public function title(): ?string
    {
        return $this->title_bn || $this->title_en;
    }

    /**
     * @param Builder $query
     * @param string|null $alias
     * @return Builder
     */
    public function scopeAcl(Builder $query, string $alias = null): Builder
    {
        if (empty($alias)) {
            $alias = $this->getTable() . '.';
        }

        if (AuthHelper::checkAuthUser()) {
            $authUser = AuthHelper::getAuthUser();
            if ($authUser->isInstituteUser()) {
                $query->where($alias . 'id', $authUser->institute_id);
            }
        }

        return $query;
    }

    /**
     * @return HasMany
     */
    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function programmes(): HasMany
    {
        return $this->hasMany(Programme::class);
    }

    public function trainingCenters(): HasMany
    {
        return $this->hasMany(TrainingCenter::class);
    }

    public function publishCourses(): HasMany
    {
        return $this->hasMany(PublishCourse::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function applicationFormType(): HasOne
    {
        return $this->hasOne(ApplicationFormType::class);
    }

    public function logoIsDefault(): bool
    {
        return $this->logo === self::DEFAULT_LOGO;
    }

    public function sliders(): HasMany
    {
        return $this->hasMany(Slider::class);
    }

}
