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
        if (Schema::hasTable('job_supplement_subcategory_m')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('job_supplement_subcategory_m', function (Blueprint $table) {

            $table
                ->increments('job_supplement_subcategory_cd')
                ->comment('求人補足中分類コード:連番');

            $table
                ->integer('job_supplement_maincategory_cd')
                ->nullable()
                ->comment('求人補足大分類コード');

            $table
                ->string('job_supplement_subcategory_name', 100)
                ->comment('中分類名');
                
            $table
                ->integer('display_order')
                ->default(1)
                ->comment('並び順');

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
        DB::statement("ALTER TABLE job_supplement_subcategory_m COMMENT '求人補足中分類マスタ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_supplement_subcategory_m');
    }
};
