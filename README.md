# laravel-addresscode-japan

[Geolonia 住所データ](https://geolonia.github.io/japanese-addresses/) をインポートする Laravel 用のライブラリです。

## Geolonia 住所データ とは？

> 全国の町丁目レベル（189,540件）の住所データをオープンデータとして公開いたします。
>
> 本データは、国土交通省位置参照情報ダウンロードサービスで配布されている「大字・町丁目レベル位置参照情報」をベースとしていますが、「大字・町丁目レベル位置参照情報」データは年に一回更新であるのに対して、本リポジトリで配布するデータは毎月更新しています。

## インストール

```bash
composer require shibuyakosuke/laravel-addresscode-japan
```

## 使用方法

```bash
php artisan migrate
```

を実行して、データを保存するためのテーブルを作成します。

```bash
php artisan address:import
```

上記のコマンドで、Geolonia 住所データをダウンロードして、データベースにデータを投入します。

コマンドを繰り返したときも、正常に動作しますが、前回ダウンロードしたCSVファイルとの差分変更がない場合はデータベースへの投入は行われません。
強制的に上書きしたい場合は、`--force` オプションを指定してください。
 
## 設定ファイル

以下のコマンドで設定ファイルを `app/config/address_code_japan.php` に出力できます。

```bash
php artisan vendor:publish --tag=address_code_japan
```

### 設定項目

`table_name` を変更すると、任意のテーブルに変更できますが、編集後は必ず、マイグレーションを実行してください。
`data_url` の値はデータ提供元のURLが変更されない限り、変更する必要はありません。

```php
<?php

return [
    /*
     * データを投入するテーブル名
     */
    'table_name' => 'geolonia_address_code_japan',

    /*
     * データのダウンロードURL設定
     */
    'data_url' => 'https://raw.githubusercontent.com/geolonia/japanese-addresses/master/data/latest.csv',
];
```
