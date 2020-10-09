<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateGeoloniaAddressCodeJapan
 */
class CreateGeoloniaAddressCodeJapan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create(config('address_code_japan.table_name'), function (Blueprint $table) {
            $table->unsignedTinyInteger('prefecture_code')->index()->comment('都道府県コード');
            $table->string('prefecture_name')->comment('都道府県名');
            $table->string('prefecture_name_kana')->comment('都道府県名カナ');
            $table->string('prefecture_name_roman')->comment('都道府県名ローマ字');
            $table->unsignedInteger('city_code')->index()->comment('市区町村コード');
            $table->string('city_name')->comment('市区町村名');
            $table->string('city_name_kana')->comment('市区町村名カナ');
            $table->string('city_name_roman')->comment('市区町村名ローマ字');
            $table->unsignedBigInteger('chome_code')->primary()->comment('大字町丁目コード');
            $table->string('chome_name')->comment('大字町丁目名');
            $table->decimal('latitude', 8, 6)->index()->comment('緯度');
            $table->decimal('longitude', 9, 6)->index()->comment('緯度');
            $table->timestamp('created_at')->nullable()->comment('作成日時');
            $table->timestamp('updated_at')->nullable()->comment('更新日時');

            $table->tableComment('住所データ（Geolonia）');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('address_code_japan.table_name'));
    }
}
