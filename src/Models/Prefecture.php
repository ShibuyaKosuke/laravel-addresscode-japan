<?php

namespace ShibuyaKosuke\LaravelAddressCodeJapan\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Prefecture
 * @package ShibuyaKosuke\LaravelAddressCodeJapan\Models
 *
 * @method static Builder|Prefecture newModelQuery()
 * @method static Builder|Prefecture newQuery()
 * @method static Builder|Prefecture query()
 * @method static Builder|Prefecture whereCreatedAt($value)
 * @method static Builder|Prefecture whereId($value)
 * @method static Builder|Prefecture whereName($value)
 * @method static Builder|Prefecture wherePrefectureId($value)
 * @method static Builder|Prefecture whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Prefecture extends Model
{
    use Timestamp;

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];

    /**
     * 市町村
     * @return HasMany
     */
    public function cities():HasMany
    {
        return $this->hasMany(City::class);
    }
}
