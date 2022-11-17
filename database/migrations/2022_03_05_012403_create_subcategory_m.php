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
        if (Schema::hasTable('subcategory_m')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('subcategory_m', function (Blueprint $table) {

            $table
                ->increments('subcategory_cd')
                ->comment('中分類コード:連番');

            $table
                ->integer('maincategory_cd')
                ->default(0)
                ->comment('大分類コード');
            
            $table
                ->string('subcategory_name', 50)
                ->comment('中分類名');

            $table
                ->integer('display_order')
                ->default(0)
                ->comment('並び順:大分類毎にグルーピングする');

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
        });

        // ALTER 文を実行しテーブルにコメントを設定
        DB::statement("ALTER TABLE subcategory_m COMMENT '中分類マスタ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcategory_m');
    }
};
