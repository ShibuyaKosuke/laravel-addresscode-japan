<?php

namespace ShibuyaKosuke\LaravelAddressCodeJapan\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class City
 * @package ShibuyaKosuke\LaravelAddressCodeJapan\Models
 *
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City wherePrefectureId($value)
 * @method static Builder|City whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    use Timestamp;

    protected $fillable = [
        'id',
        'prefecture_id',
        'name',
        'created_at',
        'updated_at'
    ];

    /**
     * 都道府県
     * @return BelongsTo
     */
    public function prefecture(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class);
    }

    /**
     * 大字・丁目
     * @return HasMany
     */
    public function towns(): HasMany
    {
        return $this->hasMany(Town::class);
    }
}
