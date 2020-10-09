<?php

namespace ShibuyaKosuke\LaravelAddressCodeJapan\Console;

use Illuminate\Console\Command;
use ShibuyaKosuke\LaravelAddressCodeJapan\Models\AddressCode;
use ShibuyaKosuke\LaravelAddressCodeJapan\Models\City;
use ShibuyaKosuke\LaravelAddressCodeJapan\Models\Prefecture;
use ShibuyaKosuke\LaravelAddressCodeJapan\Models\Town;

class AddressCodeNormalizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:normalize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geolonia 住所データから、都道府県、市町村および大字・丁目マスタを作成します。';

    /**
     * 処理の実装
     */
    public function handle(): void
    {
        $this->prefecture();
        $this->cities();
        $this->towns();

        $this->info('Finish');
    }

    protected function prefecture(): void
    {
        $this->info(PHP_EOL . __FUNCTION__);

        $prefectures = AddressCode::query()
            ->select(['prefecture_code', 'prefecture_name'])
            ->groupBy(['prefecture_code', 'prefecture_name'])
            ->get();

        $progressbar = $this->getOutput()->createProgressBar($prefectures->count());
        $progressbar->start();

        foreach ($prefectures as $prefecture) {
            Prefecture::updateOrCreate(
                [
                    'id' => $prefecture->prefecture_code
                ], [
                    'id' => $prefecture->prefecture_code,
                    'name' => $prefecture->prefecture_name,
                    'updated_at' => now()
                ]
            );
            $progressbar->advance();
        }
        $progressbar->finish();
    }

    protected function cities(): void
    {
        $this->info(PHP_EOL . __FUNCTION__);

        $cities = AddressCode::query()
            ->select(['city_code', 'city_name', 'prefecture_code'])
            ->groupBy(['city_code', 'city_name', 'prefecture_code'])
            ->get();

        $progressbar = $this->getOutput()->createProgressBar($cities->count());
        $progressbar->start();

        foreach ($cities as $city) {
            City::updateOrCreate(
                [
                    'id' => $city->city_code
                ], [
                    'id' => $city->city_code,
                    'prefecture_id' => $city->prefecture_code,
                    'name' => $city->city_name,
                    'updated_at' => now()
                ]
            );
            $progressbar->advance();
        }
        $progressbar->finish();
    }

    protected function towns(): void
    {
        $this->info(PHP_EOL . __FUNCTION__);

        $towns = AddressCode::query()
            ->select(['city_code', 'chome_code', 'chome_name'])
            ->get();

        $progressbar = $this->getOutput()->createProgressBar($towns->count());
        $progressbar->start();

        foreach ($towns as $town) {
            Town::updateOrCreate(
                [
                    'id' => $town->chome_code
                ], [
                    'id' => $town->chome_code,
                    'city_id' => $town->city_code,
                    'name' => $town->chome_name,
                    'updated_at' => now()
                ]
            );
            $progressbar->advance();
        }
        $progressbar->finish();
    }
}