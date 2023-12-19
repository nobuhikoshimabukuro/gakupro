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
        if(Schema::hasTable('job_search_history_t')){
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('job_search_history_t', function (Blueprint $table) {

            $table
                ->increments('id')
                ->comment('連番');

            $table
                ->integer('job_supplement_subcategory_cd')                
                ->comment('求人補足中分類コード');

            $table
                ->date('search_date')                
                ->comment('検索日');

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
        DB::statement("ALTER TABLE job_search_history_t COMMENT '求人検索履歴テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_search_history_t');
    }
};
