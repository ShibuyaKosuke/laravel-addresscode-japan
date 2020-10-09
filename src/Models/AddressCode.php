<?php

namespace ShibuyaKosuke\LaravelAddressCodeJapan\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AddressCode
 *
 * @method static Builder|AddressCode newModelQuery()
 * @method static Builder|AddressCode newQuery()
 * @method static Builder|AddressCode query()
 * @method static Builder|AddressCode whereCreatedAt($value)
 * @method static Builder|AddressCode whereId($value)
 * @method static Builder|AddressCode whereName($value)
 * @method static Builder|AddressCode wherePrefectureId($value)
 * @method static Builder|AddressCode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AddressCode extends Model
{
    use Timestamp;

    /**
     * @var string
     */
    protected $table = 'geolonia_address_code_japan';

    /**
     * @var string
     */
    protected $primaryKey = 'chome_code';

    /**
     * @var string[]
     */
    protected $fillable = [
        'prefecture_code',
        'prefecture_name',
        'prefecture_name_kana',
        'prefecture_name_roman',
        'city_code',
        'city_name',
        'city_name_kana',
        'city_name_roman',
        'chome_code',
        'chome_name',
        'latitude',
        'longitude',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('address_code_japan.table_name');
        parent::__construct($attributes);
    }
}