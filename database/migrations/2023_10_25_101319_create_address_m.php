<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('address_m')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('address_m', function (Blueprint $table) {

            $table
                ->string('prefectural_cd', 2)
                ->comment('都道府県コード');

            $table
                ->string('prefectural_name', 100)
                ->nullable()
                ->comment('都道府県名');

            $table
                ->string('prefectural_name_kana', 100)
                ->nullable()
                ->comment('都道府県名カナ');

            $table
                ->string('municipality_cd', 10)
                ->comment('市区町村コード');

            $table
                ->string('municipality_name', 200)
                ->nullable()
                ->comment('市区町村名カナ');

            $table
                ->string('municipality_name_kana', 200)
                ->nullable()
                ->comment('市区町村名カナ');


            
            $table
                ->dateTime('created_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'))
                ->comment('作成日時:自動生成');

            $table
                ->integer('created_by')
                ->nullable()
                ->comment('作成者');

            $table
                ->dateTime('updated_at')
                ->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))
                ->comment('更新日時:自動生成');

            $table
                ->integer('updated_by')
                ->nullable()
                ->comment('更新者');

            $table
                ->dateTime('deleted_at')
                ->nullable()
                ->comment('削除日時');

            $table
                ->integer('deleted_by')
                ->nullable()
                ->comment('削除者');

            $table->primary(['prefectural_cd','municipality_cd'], 'address_m');

        });

        // ALTER 文を実行しテーブルにコメントを設定
        DB::statement("ALTER TABLE address_m COMMENT '住所マスタ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_m');
    }
};
