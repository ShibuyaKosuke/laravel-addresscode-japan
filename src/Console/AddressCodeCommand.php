<?php

namespace ShibuyaKosuke\LaravelAddressCodeJapan\Console;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use ShibuyaKosuke\LaravelAddressCodeJapan\Imports\AddressCodeImport;
use ShibuyaKosuke\LaravelAddressCodeJapan\Imports\AddressCodeQueueImport;

/**
 * Class AddressCodeCommand
 * @package ShibuyaKosuke\LaravelAddressCodeJapan\Console
 */
class AddressCodeCommand extends Command
{
    /**
     * 保存時のファイル名
     */
    private const FILENAME = 'address_code_japan.csv';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:import {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geolonia 住所データをダウンロードして、データベースに登録します。';

    /**
     * @var Application app
     */
    protected $app;

    /**
     * @var Repository config
     */
    protected $config;

    /**
     * AddressCodeCommand constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct();

        $this->app = $app;
        $this->config = $this->app['config'];
    }

    /**
     * 処理の実装
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $this->download() && $this->import();
    }

    /**
     * CSV ファイルをダウンロードする
     * @throws GuzzleException|\Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function download(): bool
    {
        $url = $this->config->get('address_code_japan.data_url');

        $client = new Client();
        $response = $client->request('GET', $url);

        if ($response->getStatusCode() === 200) {
            $body = $response->getBody();
            $new_hash = hash('sha1', $body);
            $old_hash = hash('sha1', Storage::get(self::FILENAME));
            if ($new_hash === $old_hash && !$this->option('force')) {
                return false;
            }
            return Storage::put(self::FILENAME, $body);
        }
        return false;
    }

    /**
     * DBにインポートする
     */
    private function import(): void
    {
        $file = storage_path(sprintf('app/%s', self::FILENAME));
        (new AddressCodeImport())->withOutput($this->output)->import($file);
    }
}
