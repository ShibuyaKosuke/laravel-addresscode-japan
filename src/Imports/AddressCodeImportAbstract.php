<?php

namespace ShibuyaKosuke\LaravelAddressCodeJapan\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use ShibuyaKosuke\LaravelAddressCodeJapan\Models\AddressCode;

/**
 * Class AddressCodeImportAbstract
 * @package ShibuyaKosuke\LaravelAddressCodeJapan\Imports
 */
abstract class AddressCodeImportAbstract implements ToCollection, WithChunkReading
{
    use Importable;

    /**
     * カラム名のリスト
     * @var array|string[]
     */
    private array $columns = [
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

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $i => $row) {
            if ($i === 0) {
                continue;
            }
            $columns = array_combine($this->columns, $row->toArray());
            AddressCode::updateOrCreate(
                ['chome_code' => $columns['chome_code']],
                $columns
            );
        }
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @return string[]
     */
    public function getCsvSettings(): array
    {
        return [
            "delimiter" => ',',
            "enclosure" => '"',
            "input_encoding" => 'utf-8',
        ];
    }
}