<?php

namespace ShibuyaKosuke\LaravelAddressCodeJapan\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Town
 * @package ShibuyaKosuke\LaravelAddressCodeJapan\Models
 *
 * @method static Builder|Town newModelQuery()
 * @method static Builder|Town newQuery()
 * @method static Builder|Town query()
 * @method static Builder|Town whereCreatedAt($value)
 * @method static Builder|Town whereId($value)
 * @method static Builder|Town whereName($value)
 * @method static Builder|Town wherePrefectureId($value)
 * @method static Builder|Town whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Town extends Model
{
    use Timestamp;

    protected $fillable = [
        'id',
        'city_id',
        'name',
        'created_at',
        'updated_at'
    ];

    /**
     * 市町村
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
