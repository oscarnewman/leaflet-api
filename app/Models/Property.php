<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * Class Property
 *
 * @package App\Models
 * @property string $id
 * @property string $area
 * @property int $bedrooms
 * @property int $rent
 * @property string $start_date
 * @property string $end_date
 * @property string $image
 * @property string $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 * @method static Builder|Property newModelQuery()
 * @method static Builder|Property newQuery()
 * @method static Builder|Property query()
 * @method static Builder|Property whereArea($value)
 * @method static Builder|Property whereBedrooms($value)
 * @method static Builder|Property whereCreatedAt($value)
 * @method static Builder|Property whereEndDate($value)
 * @method static Builder|Property whereId($value)
 * @method static Builder|Property whereImage($value)
 * @method static Builder|Property whereRent($value)
 * @method static Builder|Property whereStartDate($value)
 * @method static Builder|Property whereUpdatedAt($value)
 * @method static Builder|Property whereUserId($value)
 * @mixin \Eloquent
 */
class Property extends BaseModel
{
    use HasFactory;

    protected $appends = ['featured_image'];

    protected $fillable = ['user', 'area', 'bedrooms', 'rent', 'start_date', 'end_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'property_image')
            ->orderBy('property_image.order');
    }

    public function getFeaturedImageAttribute()
    {
        return $this->images()->first();
    }
}
